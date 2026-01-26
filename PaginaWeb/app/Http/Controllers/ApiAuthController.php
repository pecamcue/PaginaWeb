<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('shared-auth-token')->plainTextToken;


            $cookie = cookie(
                'auth_token', $token, 120, '/', null, true, true, false, 'Lax'               
            );

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200)->withCookie($cookie);
        }

        return response()->json([
            'message' => 'Credenciales inválidas',
        ], 401);
    }

   public function logout(Request $request): JsonResponse
{
    try {
        $user = $request->user();

        if ($user) {
            // Borra SOLO el token actual
            $user->currentAccessToken()->delete();
        }

        // Borra la cookie del token
        $cookie = cookie('auth_token', '', -1);

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ], 200)->withCookie($cookie);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error interno al cerrar sesión',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

    public function tokenLogin(Request $request): JsonResponse
    {
        $token = $request['token'];
        
        $user = User::where('auth_token', $token)->first();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
