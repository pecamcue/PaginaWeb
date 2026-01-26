<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /* Display the login view */
    public function create(): View
    {
        return view('auth.login');
    }

    /* Handle an incoming authentication request */
    public function store(LoginRequest $request): RedirectResponse | \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Agregado 'apellidos' al JSON. Verificar si estamos en el flujo de reserva o expectsJson
        if (($request->has('in_reservation_flow') && $request->in_reservation_flow === 'true') || $request->expectsJson()) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'apellidos' => $user->apellidos ?? '',
                'email' => $user->email,
                'telefono' => $user->telefono ?? null,
            ]);
        }

        // Redirigir a la página de inicio fuera del flujo de reserva
        return redirect('/');
    }

    /*  Destroy an authenticated session */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}