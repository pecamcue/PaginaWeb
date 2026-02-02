<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResenyaController;

// CSRF cookie para SPA (Sanctum) - redirige a la ruta de Sanctum
Route::get('/sanctum/csrf-cookie', function () {
    return app(\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class)->show(request());
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/token-login', [ApiAuthController::class, 'tokenLogin']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/token', [ApiTokenController::class, 'getToken'])->middleware('auth:sanctum');
Route::post('/sync-login', [ApiAuthController::class, 'syncLogin']);

Route::get('/productos/categoria/{slug}', [ProductController::class, 'porCategoriaNombre']);
Route::get('/productos/slug/{slug}', [ProductController::class, 'verProductoPorSlug']);
Route::get('/productos/id/{id}', [ProductController::class, 'ver']);
Route::get('productos/marcas/{slug}', [ProductController::class, 'obtenerMarcasPorCategoria']);

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::delete('/products/imagen/{id}', [ProductController::class, 'eliminarImagen']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-order', [StripeController::class, 'createOrder'])->name('stripe.createOrder');
    Route::get('/checkout/{orderId}', [StripeController::class, 'showCheckout'])->name('stripe.checkout');
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);

    // NUEVAS RUTAS PARA REDIRECCIÓN A PASARELAS
    Route::post('/stripe/checkout-session/{orderId}', [StripeController::class, 'createStripeCheckoutSession']);
    Route::post('/paycomet/generate-url/{orderId}', [StripeController::class, 'generatePaycometUrl']);

    // Dirección temporal
    Route::post('/orders/{orderId}/address', [StripeController::class, 'updateOrderAddress']);

    // Páginas de retorno (éxito y cancelación)
    Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
});

// Reseñas de productos
Route::get('/productos/{productId}/resenyas', [ResenyaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/resenyas', [ResenyaController::class, 'store']);
});