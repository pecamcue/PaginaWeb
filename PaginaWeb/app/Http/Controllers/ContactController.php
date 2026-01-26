<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;  

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|max:15',
            'mensaje' => 'required|string',
        ]);

        // Enviar el correo
        Mail::to('info@conchacuevas.es')->send(new ContactFormMail($validated));

        // Redirigir con mensaje de éxito
        return back()->with('success', 'Formulario enviado con éxito.');
    }
}
