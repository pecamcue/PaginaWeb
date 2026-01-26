<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\PaymentIntent;
use Stripe\Customer;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancellation;
use App\Mail\AppointmentModification;
use Illuminate\Validation\ValidationException;

class UserPortalController extends Controller
{
    // Función helper para detectar si un ítem tiene graduación (activa 10% IVA)
    private function hasGraduation($item)
    {
        return !empty($item->od_esfera) || !empty($item->oi_esfera) || 
               !empty($item->tipo_lentilla) || !empty($item->adicion) || 
               !empty($item->ojo_dominante) || !empty($item->od_cilindro) || 
               !empty($item->oi_cilindro) || !empty($item->od_eje) || 
               !empty($item->oi_eje);
    }

    public function index()
    {
        $user = Auth::user();
        return view('portal_user.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('portal_user.perfil_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telefono' => 'required|string|max:20|unique:users,telefono,' . $user->id,
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'piso' => 'nullable|string|max:10',
            'ciudad' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'pais' => 'required|string|max:100',
        ]);

        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;
        $user->telefono = $request->telefono;
        $user->calle = $request->calle;
        $user->numero = $request->numero;
        $user->piso = $request->piso;
        $user->ciudad = $request->ciudad;
        $user->codigo_postal = $request->codigo_postal;
        $user->pais = $request->pais;

        $user->save();

        return back()->with('success', 'Datos actualizados correctamente.')->with('sweetalert', [
            'title' => '¡Éxito!',
            'text' => 'Datos actualizados correctamente.',
            'icon' => 'success',
        ]);
    }

    public function showChangePasswordForm()
    {
        return view('portal_user.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.'])->with('sweetalert', [
                'title' => '¡Error!',
                'text' => 'La contraseña actual no es correcta.',
                'icon' => 'error',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.')->with('sweetalert', [
            'title' => '¡Éxito!',
            'text' => 'Contraseña actualizada correctamente.',
            'icon' => 'success',
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::find(Auth::id());
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada correctamente.')->with('sweetalert', [
            'title' => '¡Cuenta eliminada!',
            'text' => 'Tu cuenta ha sido eliminada correctamente.',
            'icon' => 'success',
        ]);
    }

    public function orders()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderByDesc('order_date')
            ->get();

        return view('portal_user.pedidos.order_history', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('portal_user.pedidos.order_details', compact('order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('orderItems.product.categoria', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $order->load(['orderItems.product.categoria', 'user']);

        $itemsWithIVA = [];
        $impuestosTotal = 0;
        $subtotalTotal = $order->subtotal;

        foreach ($order->orderItems as $item) {
            $categoria = $item->product->categoria;
            // NUEVA LÓGICA: Override a 10% si hay graduación
            $ivaRate = $categoria ? $categoria->iva_rate : 0.21;
            if ($this->hasGraduation($item)) {
                $ivaRate = 0.10; // Tipo reducido para productos graduados/sanitarios
                Log::info('Graduación detectada en ítem ' . $item->id . ': IVA al 10%');
            }

            $subtotalItem = $item->precio_unitario * $item->cantidad;
            $impuestoItem = $subtotalItem * $ivaRate;

            $itemsWithIVA[] = [
                'marca' => $item->product->marca ?? '',
                'modelo' => $item->product->modelo ?? '',
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'od_esfera' => $item->od_esfera,
                'od_cilindro' => $item->od_cilindro,
                'od_eje' => $item->od_eje,
                'oi_esfera' => $item->oi_esfera,
                'oi_cilindro' => $item->oi_cilindro,
                'oi_eje' => $item->oi_eje,
                'adicion' => $item->adicion,
                'ojo_dominante' => $item->ojo_dominante,
                'tipo_cristal' => $item->tipo_cristal,
                'indice_lente' => $item->indice_lente,
                'color_cristal' => $item->color_cristal,
                'categoria' => $categoria ? $categoria->nombre : 'General',
                'iva_rate' => $ivaRate, // Para desglose en PDF
            ];

            $impuestosTotal += $impuestoItem;
        }

        if ($order->shipping_cost > 0) {
            $impuestosTotal += $order->shipping_cost * 0.21;
        }

        $factura = Factura::firstOrCreate(
            ['order_id' => $order->id],
            [
                'numero_factura' => Factura::generarNumeroFactura(),
                'user_id' => $order->user_id,
                'fecha_emision' => now(),
                'subtotal' => $subtotalTotal,
                'impuestos' => $impuestosTotal,
                'total' => $subtotalTotal + $impuestosTotal,
            ]
        );

        $factura->load(['order.orderItems.product.categoria', 'user']);

        // Cargar logo como base64 para DomPDF
        $logoPath = public_path('img/Logo.jpg');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('emails.factura', [
            'factura' => $factura,
            'itemsWithIVA' => $itemsWithIVA,
            'logoBase64' => $logoBase64
        ]);

        return $pdf->download('factura_' . $factura->numero_factura . '.pdf');
    }

    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())->get();
        return response()->json(['paymentMethods' => $paymentMethods]);
    }

    public function storePaymentMethod(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        $request->validate([
            'payment_method_id' => 'required|string',
            'card_type' => 'required|in:visa,mastercard,amex',
            'last_four_digits' => 'required|string|size:4',
            'card_holder' => 'required|string|max:255',
            'expiry_date' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
        ]);

        try {
            $user = Auth::user();
            if (!$user->stripe_customer_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }

            $stripePaymentMethod = StripePaymentMethod::retrieve($request->payment_method_id);
            $stripePaymentMethod->attach(['customer' => $user->stripe_customer_id]);

            $paymentMethod = new PaymentMethod();
            $paymentMethod->user_id = $user->id;
            $paymentMethod->stripe_payment_method_id = $request->payment_method_id;
            $paymentMethod->card_type = $request->card_type;
            $paymentMethod->last_four_digits = $request->last_four_digits;
            $paymentMethod->card_holder = $request->card_holder;
            $paymentMethod->expiry_date = $request->expiry_date;
            $paymentMethod->save();

            return response()->json([
                'success' => true,
                'message' => 'Método de pago añadido con éxito',
                'sweetalert' => [
                    'title' => '¡Éxito!',
                    'text' => 'Método de pago añadido con éxito.',
                    'icon' => 'success',
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar método de pago: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'sweetalert' => [
                    'title' => '¡Error!',
                    'text' => 'Error al procesar la solicitud.',
                    'icon' => 'error',
                ]
            ], 500);
        }
    }

    public function showAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('portal_user.appointments.index', compact('appointments'));
    }

    public function createAppointment()
    {
        return view('portal_user.appointments.create');
    }

    public function storeAppointment(Request $request)
    {
        Log::info('Datos recibidos en storeAppointment: ' . json_encode($request->all()));
        Log::info('Usuario autenticado: ' . Auth::id());

        $request->validate([
            'service' => 'required|string|in:Examen_Visual,Examen_Audiologico,Revision_Lentillas',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string|regex:/^[0-2][0-9]:[0-5][0-9]$/',
        ]);

        $appointmentDate = Carbon::parse($request->date);
        $appointmentTime = Carbon::createFromFormat('H:i', $request->time);

        $existingAppointment = Appointment::whereDate('appointment_date', $appointmentDate->format('Y-m-d'))
            ->whereTime('appointment_time', $appointmentTime->format('H:i'))
            ->where('status', 'confirmada')
            ->exists();

        if ($existingAppointment) {
            return back()->with('error', 'La hora seleccionada ya está reservada.')->with('sweetalert', [
                'title' => '¡Error!',
                'text' => 'La hora seleccionada ya está reservada.',
                'icon' => 'error',
            ]);
        }

        $appointment = new Appointment();
        $appointment->service_type = $request->service;
        $appointment->appointment_date = $appointmentDate;
        $appointment->appointment_time = $appointmentTime;
        $appointment->status = 'confirmada';
        $appointment->confirmation_token = Str::random(40);
        $appointment->user_id = Auth::id();
        $appointment->save();

        Log::info('Cita guardada - ID: ' . $appointment->id . ', user_id: ' . $appointment->user_id);

        try {
            Mail::to(Auth::user()->email)->send(new AppointmentConfirmation($appointment));
            Log::info('Correo de confirmación enviado a: ' . Auth::user()->email);
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
        }

        return redirect()->route('user.appointments')->with('success', 'Cita creada con éxito')->with('sweetalert', [
            'title' => '¡Éxito!',
            'text' => 'Cita creada con éxito.',
            'icon' => 'success',
        ]);
    }

    public function editAppointment($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->orWhere(function ($query) {
                $query->where('guest_email', Auth::user()->email)
                      ->whereNotNull('guest_email')
                      ->whereNull('user_id');
            })
            ->findOrFail($id);

        return view('portal_user.appointments.edit', compact('appointment'));
    }

    public function updateAppointment(Request $request, $id)
    {
        try {
            $appointment = Appointment::where('user_id', Auth::id())
                ->orWhere(function ($query) {
                    $query->where('guest_email', Auth::user()->email)
                          ->whereNotNull('guest_email')
                          ->whereNull('user_id');
                })
                ->findOrFail($id);

            try {
                $request->validate([
                    'service' => 'required|string|in:Examen_Visual,Examen_Audiologico,Revision_Lentillas',
                    'date' => 'required|date|after_or_equal:today',
                    'time' => 'required|string|regex:/^[0-2][0-9]:[0-5][0-9]$/',
                ]);
            } catch (ValidationException $e) {
                $errors = $e->validator->errors()->all();
                Log::error('Validación fallida en updateAppointment: ' . implode(', ', $errors));
                return response()->json([
                    'success' => false,
                    'error' => 'Errores de validación: ' . implode(', ', $errors),
                    'sweetalert' => [
                        'title' => '¡Error!',
                        'text' => 'Errores en el formulario: ' . implode(', ', $errors),
                        'icon' => 'error',
                    ]
                ], 422);
            }

            $newDate = Carbon::parse($request->date)->format('Y-m-d');
            $newTime = $request->time;

            $existingAppointment = Appointment::where('appointment_date', $newDate)
                ->where('appointment_time', $newTime)
                ->where('status', 'confirmada')
                ->where('id', '!=', $id)
                ->exists();

            if ($existingAppointment) {
                return response()->json([
                    'success' => false,
                    'error' => 'La hora seleccionada ya está reservada.',
                    'sweetalert' => [
                        'title' => '¡Error!',
                        'text' => 'La hora seleccionada ya está reservada.',
                        'icon' => 'error',
                    ]
                ], 422);
            }

            $newAppointment = new Appointment();
            $newAppointment->service_type = $request->service;
            $newAppointment->appointment_date = $newDate;
            $newAppointment->appointment_time = $newTime;
            $newAppointment->status = 'confirmada';
            $newAppointment->confirmation_token = Str::random(40);
            $newAppointment->user_id = $appointment->user_id ?: Auth::id();
            $newAppointment->guest_name = $appointment->guest_name;
            $newAppointment->guest_email = $appointment->guest_email;
            $newAppointment->guest_phone = $appointment->guest_phone;
            $newAppointment->save();

            // Enviar correo de modificación ANTES de borrar
            $recipientEmail = Auth::user()->email;
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new AppointmentModification($appointment, $newAppointment));
                Log::info('Correo de modificación enviado a: ' . $recipientEmail);
            }

            // Borrar la cita anterior DESPUÉS del envío
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cita actualizada con éxito',
                'redirect' => route('user.appointments'),
                'sweetalert' => [
                    'title' => '¡Éxito!',
                    'text' => 'Cita actualizada con éxito.',
                    'icon' => 'success',
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error en updateAppointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'sweetalert' => [
                    'title' => '¡Error!',
                    'text' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                    'icon' => 'error',
                ]
            ], 500);
        }
    }

    public function cancelAppointment($id)
    {
        try {
            Log::info('Solicitud DELETE recibida para cancelAppointment, ID: ' . $id);
            $appointment = Appointment::where('user_id', Auth::id())
                ->orWhere(function ($query) {
                    $query->where('guest_email', Auth::user()->email)
                          ->whereNotNull('guest_email')
                          ->whereNull('user_id');
                })
                ->findOrFail($id);

            // Enviar correo de cancelación ANTES de borrar
            $recipientEmail = Auth::user()->email;
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new AppointmentCancellation($appointment));
                Log::info('Correo de cancelación enviado a: ' . $recipientEmail);
            }

            // Borrar la cita DESPUÉS del envío
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cita eliminada con éxito',
                'redirect' => route('user.appointments'),
                'sweetalert' => [
                    'title' => '¡Éxito!',
                    'text' => 'Cita eliminada con éxito.',
                    'icon' => 'success',
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error en cancelAppointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'sweetalert' => [
                    'title' => '¡Error!',
                    'text' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                    'icon' => 'error',
                ]
            ], 500);
        }
    }
}