<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancellation;
use App\Mail\AppointmentModification;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('portal_user.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointment.form');
    }

    public function store(Request $request)
    {
        Log::info('Datos recibidos en store: ' . json_encode($request->all()));
        Log::info('Usuario autenticado: ' . (auth()->check() ? auth()->id() : 'No autenticado'));

        $validated = $request->validate([
            'service' => 'required|string|in:Examen_Visual,Examen_Audiologico,Revision_Lentillas',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string|regex:/^[0-2][0-9]:[0-5][0-9]$/',
            'user_type' => 'required|in:guest,registered',
            'user_id' => 'required_if:user_type,registered|nullable|exists:users,id',
            'guest_name' => 'required_if:user_type,guest|string|max:255',
            'guest_email' => 'required_if:user_type,guest|email|max:255',
            'guest_phone' => 'required_if:user_type,guest|string|regex:/\+?[0-9]{9,15}/',
        ]);

        $appointmentDate = Carbon::parse($request->date);
        $appointmentTime = Carbon::createFromFormat('H:i', $request->time);

        $existingAppointment = Appointment::whereDate('appointment_date', $appointmentDate->format('Y-m-d'))
            ->whereTime('appointment_time', $appointmentTime->format('H:i'))
            ->where('status', 'confirmada')
            ->exists();

        if ($existingAppointment) {
            return response()->json(['success' => false, 'error' => 'La hora seleccionada ya está reservada.'], 422);
        }

        $appointment = new Appointment();
        $appointment->service_type = $request->service;
        $appointment->appointment_date = $appointmentDate;
        $appointment->appointment_time = $appointmentTime;
        $appointment->status = 'confirmada';
        $appointment->confirmation_token = Str::random(40);

        if ($request->user_type === 'guest') {
            $appointment->guest_name = $request->guest_name;
            $appointment->guest_email = $request->guest_email;
            $appointment->guest_phone = $request->guest_phone;
        } else {
            $appointment->user_id = $request->user_id ?? (auth()->check() ? auth()->id() : null);
        }

        $appointment->save();

        Log::info('Cita guardada - ID: ' . $appointment->id . ', user_id: ' . $appointment->user_id . ', guest_email: ' . $appointment->guest_email);

        try {
            $recipientEmail = $request->user_type === 'guest' ? $request->guest_email : null;
            if (!$recipientEmail && $request->user_type === 'registered' && $appointment->user_id) {
                $user = \App\Models\User::find($appointment->user_id);
                $recipientEmail = $user ? $user->email : null;
            }
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new AppointmentConfirmation($appointment));
                Log::info('Correo de confirmación enviado a: ' . $recipientEmail);
            } else {
                Log::warning('No se encontró un correo válido para enviar la confirmación de la cita ID: ' . $appointment->id);
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
        }

        // Redirigir a /mi-cuenta/citas si el usuario está autenticado, de lo contrario a inicio
        $redirectRoute = auth()->check() ? route('user.appointments') : route('inicio');

        return response()->json([
            'success' => true,
            'message' => 'Cita reservada con éxito',
            'redirect' => $redirectRoute
        ]);
    }

    public function getAvailableHours(Request $request)
    {
        try {
            $request->validate(['date' => 'required|date']);
            $date = Carbon::parse($request->query('date'))->startOfDay();
            $now = Carbon::now()->setTimezone('Europe/Madrid');
            $isToday = $date->isSameDay($now);

            // Horario disponible por defecto
            $allHours = collect(['10:00', '10:45', '11:30', '12:15', '13:00', '17:00', '17:45', '18:15', '19:00']);

            // Si es hoy, filtra horas pasadas
            if ($isToday) {
                $allHours = $allHours->filter(function ($hour) use ($now) {
                    $hourTime = Carbon::createFromFormat('H:i', $hour, 'Europe/Madrid');
                    $currentTime = Carbon::createFromFormat('H:i', $now->format('H:i'), 'Europe/Madrid');
                    return $hourTime->greaterThan($currentTime);
                })->values();
            }

            // Horas ya reservadas (solo confirmadas) ese día
            $reservedHours = Appointment::whereDate('appointment_date', $date->format('Y-m-d'))
                ->where('status', 'confirmada')
                ->pluck('appointment_time')
                ->map(function ($time) {
                    return Carbon::parse($time)->format('H:i');
                })->toArray();

            // Filtra horas disponibles
            $availableHours = $allHours->diff($reservedHours)->values();

            return response()->json($availableHours);
        } catch (\Exception $e) {
            Log::error('Error al obtener horas disponibles: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar la solicitud'], 500);
        }
    }

    public function showEditForm($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointment.edit', ['appointment' => $appointment, 'from_portal' => false]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'service' => 'required|string|in:Examen_Visual,Examen_Audiologico,Revision_Lentillas',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|string|regex:/^[0-2][0-9]:[0-5][0-9]$/',
                'from_portal' => 'nullable'
            ]);

            $oldAppointment = Appointment::findOrFail($id);
            $newDate = Carbon::parse($request->date);
            $newTime = Carbon::createFromFormat('H:i', $request->time);
            $serviceType = $request->service;

            // Verificar conflicto excluyendo la propia cita
            $existingAppointment = Appointment::whereDate('appointment_date', $newDate->format('Y-m-d'))
                ->whereTime('appointment_time', $newTime->format('H:i'))
                ->where('status', 'confirmada')
                ->where('id', '!=', $id)
                ->exists();

            if ($existingAppointment) {
                return response()->json(['success' => false, 'error' => 'La hora seleccionada ya está reservada.'], 422);
            }

            $newAppointment = null;

            DB::transaction(function () use ($oldAppointment, $serviceType, $newDate, $newTime, &$newAppointment) {
                // Crear nueva cita confirmada
                $newAppointment = new Appointment();
                $newAppointment->service_type = $serviceType;
                $newAppointment->appointment_date = $newDate;
                $newAppointment->appointment_time = $newTime;
                $newAppointment->status = 'confirmada';
                $newAppointment->confirmation_token = Str::random(40);
                // Copiamos titular (usuario o invitado)
                $newAppointment->user_id = $oldAppointment->user_id;
                $newAppointment->guest_name = $oldAppointment->guest_name;
                $newAppointment->guest_email = $oldAppointment->guest_email;
                $newAppointment->guest_phone = $oldAppointment->guest_phone;
                $newAppointment->save();

                // Enviar correo de modificación ANTES de borrar la vieja
                $recipientEmail = $newAppointment->guest_email ?: null;
                if (!$recipientEmail && $newAppointment->user_id) {
                    $user = \App\Models\User::find($newAppointment->user_id);
                    $recipientEmail = $user ? $user->email : null;
                }
                if ($recipientEmail) {
                    Mail::to($recipientEmail)->send(new AppointmentModification($oldAppointment, $newAppointment));
                    Log::info('Correo de modificación enviado a: ' . $recipientEmail);
                } else {
                    Log::warning('No se encontró correo para modificación (cita ID nueva: ' . $newAppointment->id . ')');
                }

                // Borramos físicamente la cita antigua DESPUÉS del envío
                $oldAppointment->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Cita modificada con éxito',
                'redirect' => $request->boolean('from_portal') ? route('user.appointments') : route('inicio')
            ]);
        } catch (\Exception $e) {
            Log::error('Error en update(): ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            // Enviar correo de cancelación ANTES de borrar
            $recipientEmail = $appointment->guest_email ?? null;
            if (!$recipientEmail && $appointment->user_id) {
                $user = \App\Models\User::find($appointment->user_id);
                $recipientEmail = $user ? $user->email : null;
            }
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new AppointmentCancellation($appointment));
                Log::info('Correo de cancelación enviado a: ' . $recipientEmail);
            } else {
                Log::warning('No se encontró correo para cancelación (cita ID: ' . $appointment->id . ')');
            }

            // Borrar la cita después del envío
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cita eliminada con éxito',
                'redirect' => route('inicio')
            ]);
        } catch (\Exception $e) {
            Log::error('Error en cancel(): ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }

    public function manage($token)
    {
        $appointment = Appointment::where('confirmation_token', $token)->firstOrFail();
        return view('appointment.manage', compact('appointment'));
    }

    public function confirmCancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointment.cancel_cita_previa', ['appointment' => $appointment, 'from_portal' => false]);
    }
}