<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{

    public function create()
    {
        // Devuelve la vista Blade de registro
        return view('auth.register');
    }


    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['required', 'string', 'max:20', 'unique:users'],
            'calle' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:10'],
            'piso' => ['nullable', 'string', 'max:10'],
            'ciudad' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['required', 'string', 'max:20'],
            'pais' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'piso' => $request->piso,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
            'pais' => $request->pais,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Login automático
        Auth::login($user);

        // ← MODIFICACIÓN: Si es JSON/AJAX o in_reservation_flow, retornar user data directamente
        if ($request->expectsJson() || $request->has('in_reservation_flow')) {
            return response()->json([
                'message' => 'Usuario registrado correctamente',
                'id' => $user->id,
                'name' => $user->name,
                'apellidos' => $user->apellidos ?? '',
                'email' => $user->email,
                'telefono' => $user->telefono ?? 'No disponible'
            ], 201);
        }

        // Si es formulario Blade → redirigir a inicio con sesión iniciada
        return redirect('/')->with('success', 'Bienvenido, ' . $user->name . '!');
    }
}