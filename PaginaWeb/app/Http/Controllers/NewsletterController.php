<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterConfirmationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function manage(Request $request)
    {
        $subscription = NewsletterSubscription::where('email', Auth::user()->email)
                                             ->where('is_active', true)
                                             ->first();

        return view('portal_user.newsletter.manage', compact('subscription'));
    }

    public function subscribe(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'email' => 'required|email',
            'accept_terms' => $request->input('from_menu') ? 'nullable' : 'required|accepted',
        ]);

        // Verificar si ya está suscrito
        $existingSubscription = NewsletterSubscription::where('email', $validatedData['email'])->where('is_active', true)->first();

        if ($existingSubscription) {
            // Si es desde la página de inicio, mostrar SweetAlert2 sin redirigir
            if (!$request->input('from_menu')) {
                return back()->with('error', 'Ya estás suscrito con este correo.');
            }
            // Si es desde el portal, mantener comportamiento actual
            return redirect()->route('newsletter.manage')->with('error', 'Ya estás suscrito con este correo.');
        }

        // Crear un token único para la cancelación
        $unsubscribeToken = Str::random(60);

        // Guardar suscripción
        $subscription = NewsletterSubscription::create([
            'email' => $validatedData['email'],
            'unsubscribe_token' => $unsubscribeToken,
            'is_active' => true,
        ]);

        // Enviar correo de confirmación solo si NO es desde el menú/página de gestión
        if (!$request->input('from_menu')) {
            Mail::to($subscription->email)->send(new NewsletterConfirmationMail($subscription));
        }

        // Redirigir con mensaje de éxito
        if ($request->input('from_menu')) {
            return redirect()->route('newsletter.manage')->with('status', '¡Gracias por suscribirte a nuestra newsletter!');
        }
        return back()->with('success', '¡Gracias por suscribirte a nuestra newsletter!');
    }

    public function cancelSubscription(Request $request, $email, $token)
    {
        // Buscar la suscripción con el email y el token
        $subscription = NewsletterSubscription::where('email', $email)
                                            ->where('unsubscribe_token', $token)
                                            ->where('is_active', true)
                                            ->first();

        // Si encontramos la suscripción, la eliminamos
        if ($subscription) {
            $subscription->delete();

            // No enviamos correo si es desde el menú/página de gestión
            if (!$request->input('from_menu')) {
                // Aquí podrías añadir un correo de confirmación de desuscripción si lo deseas
            }

            return redirect()->route('newsletter.manage')->with('status', 'Tu suscripción ha sido cancelada exitosamente.');
        }

        // Si no se encuentra la suscripción o el token no es válido
        return redirect()->route('newsletter.manage')->with('error', 'No se pudo cancelar la suscripción. El enlace podría ser inválido.');
    }
}