<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $token = $user->createToken('shared-auth-token')->plainTextToken;
            $cookie = cookie('auth_token', $token, 120, '/', null, false, true, false, 'Lax');

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200)->withCookie($cookie);
        }

        return response()->json([
            'message' => 'No autenticado',
        ], 401);
    }
}