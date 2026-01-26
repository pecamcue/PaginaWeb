<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller {

    public function redirectToAngular(Request $request)
{
    // 1. Obtenemos la URL de la tienda desde el archivo .env (vía config)
    $urlTienda = config('app.front_url') . '/inicio';

    if (Auth::check()) {
        $user = Auth::user();
        $token = $user->createToken('shared-auth-token')->plainTextToken;
        $user->auth_token = $token;
        $user->save();

        // 2. Redirigimos usando la URL dinámica con el token
        return redirect($urlTienda . '?auth_token=' . $token);
    }

    // 3. Redirigimos usando la URL dinámica sin token
    return redirect($urlTienda);
    }
}