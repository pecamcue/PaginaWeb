<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserPortalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\GraduacionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\GoogleReviewsController;

// ================= INICIO =================
Route::get('/', function () {
    $response = app(GoogleReviewsController::class)->getReviews();
    $reviews = $response->getData()->reviews;
    return view('inicio', compact('reviews'));
})->name('inicio');

// ================= AUTENTICACIÓN =================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= CSRF TOKEN =================
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// ================= REDIRECCIÓN A ANGULAR =================
Route::get('/redirect-to-angular', [WebAuthController::class, 'redirectToAngular'])->name('redirect.to.angular');

// ================= NEWSLETTER =================
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/cancelar-suscripcion/{email}/{token}', [NewsletterController::class, 'cancelSubscription'])->name('unsubscribe');
Route::get('/newsletter/manage', [NewsletterController::class, 'manage'])->name('newsletter.manage')->middleware('auth');

// ================= SERVICIOS =================
Route::get('/servicios/optica', fn() => view('servicios.optica'))->name('servicio.optica');
Route::get('/servicios/audiologia', fn() => view('servicios.audiologia'))->name('servicio.audiologia');
Route::get('/servicios/lentes_contacto', fn() => view('servicios.lentes_contacto'))->name('servicio.lentes_contacto');
Route::get('/servicios/taller', fn() => view('servicios.taller'))->name('servicio.taller');

// ================= CONTACTO =================
Route::get('/contacto', fn() => view('contacto'))->name('contacto');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// ================= FAQ =================
Route::get('/preguntas_frec', fn() => view('preguntas_frec'))->name('preguntas_frec');

// ================= POLÍTICAS =================
Route::get('politicas/aviso_legal', fn() => view('politicas.aviso_legal'))->name('politicas.aviso_legal');
Route::get('politicas/politica_privacidad', fn() => view('politicas.politica_privacidad'))->name('politicas.politica_privacidad');
Route::get('politicas/terminos_condiciones', fn() => view('politicas.terminos_condiciones'))->name('politicas.terminos_condiciones');
Route::get('politicas/politica_cookies', fn() => view('politicas.politica_cookies'))->name('politicas.politica_cookies');
Route::get('politicas/politica_calidad', fn() => view('politicas.politica_calidad'))->name('politicas.politica_calidad');

// ================= CITAS =================
Route::get('/cita/horas-disponibles', [AppointmentController::class, 'getAvailableHours'])->name('appointment.available_hours');
Route::get('/cita', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/cita/guardar', [AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/cita/gestionar/{token}', [AppointmentController::class, 'manage'])->name('appointment.manage');
Route::get('/cita/confirmar-cancelacion/{id}', [AppointmentController::class, 'confirmCancel'])->name('appointment.confirm_cancel');
Route::post('/cita/cancelar/{id}', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
Route::get('/cita/modificar/{id}', [AppointmentController::class, 'showEditForm'])->name('appointment.edit');
Route::post('/cita/modificar/{id}', [AppointmentController::class, 'update'])->name('appointment.update');

// ================= NOSOTROS / PROMOCIONES =================
Route::get('/nosotros', fn() => view('nosotros'))->name('nosotros');
Route::get('/promociones', fn() => view('promociones'))->name('promociones');

// ================= PORTAL USUARIO =================
Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/perfil', [UserPortalController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [UserPortalController::class, 'update'])->name('perfil.update');
    Route::get('/mi-cuenta/cambiar-contraseña', [UserPortalController::class, 'showChangePasswordForm'])->name('perfil.changePassword');
    Route::post('/mi-cuenta/cambiar-contraseña', [UserPortalController::class, 'updatePassword'])->name('perfil.updatePassword');
    Route::delete('/mi-cuenta/eliminar', [UserPortalController::class, 'destroy'])->name('perfil.deleteAccount');

    // Pedidos usuario
    Route::get('orders', [UserPortalController::class, 'orders'])->name('user.orders');
    Route::get('orders/{id}', [UserPortalController::class, 'showOrder'])->name('user.orders.show');
    Route::get('orders/{id}/download-invoice', [UserPortalController::class, 'downloadInvoice'])->name('user.orders.downloadInvoice');

    // Citas usuario
    Route::get('/mi-cuenta/citas', [UserPortalController::class, 'showAppointments'])->name('user.appointments');
    Route::get('/mi-cuenta/citas/crear', [UserPortalController::class, 'createAppointment'])->name('user.appointment.create');
    Route::post('/mi-cuenta/citas', [UserPortalController::class, 'storeAppointment'])->name('user.appointment.store');
    Route::get('/mi-cuenta/citas/{id}/editar', [UserPortalController::class, 'editAppointment'])->name('user.appointment.edit');
    Route::post('/mi-cuenta/citas/{id}', [UserPortalController::class, 'updateAppointment'])->name('user.appointment.update');
    Route::delete('/mi-cuenta/citas/{id}', [UserPortalController::class, 'cancelAppointment'])->name('user.appointment.cancel');

    // Métodos de pago
    Route::get('payment-methods', [UserPortalController::class, 'paymentMethods'])->name('user.payment-methods');
    Route::get('payment-methods/add', [UserPortalController::class, 'addPaymentMethodForm'])->name('user.payment-methods.add.form');
    Route::post('payment-methods', [UserPortalController::class, 'storePaymentMethod'])->name('user.payment-methods.add');
    Route::get('payment-methods/{id}/edit', [UserPortalController::class, 'editPaymentMethod'])->name('user.payment-methods.edit');
    Route::put('payment-methods/{id}', [UserPortalController::class, 'updatePaymentMethod'])->name('user.payment-methods.update');
    Route::delete('payment-methods/{id}', [UserPortalController::class, 'deletePaymentMethod'])->name('user.payment-methods.delete');

    /*/ Checkout / Stripe
    Route::get('checkout/{orderId}', [UserPortalController::class, 'checkout'])->name('user.checkout');
    Route::post('checkout/{orderId}/process', [UserPortalController::class, 'processPayment'])->name('user.processPayment');

    Route::post('/create-order', [StripeController::class, 'createOrder'])->name('stripe.createOrder');
    Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession'])->name('stripe.create');

    */// Graduación
    Route::get('/graduacion/gestionar', [GraduacionController::class, 'gestionar'])->name('graduacion.gestionar');
    Route::post('/graduacion', [GraduacionController::class, 'guardar'])->name('graduacion.guardar');
    Route::put('/graduacion/{graduacion}', [GraduacionController::class, 'actualizar'])->name('graduacion.actualizar');
    Route::delete('/graduacion/{graduacion}', [GraduacionController::class, 'eliminar'])->name('graduacion.eliminar');
});

// ================= RUTAS STRIPE PÚBLICAS =================
Route::get('/payment/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/payment/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

// ================= ADMINISTRACIÓN =================
// CAMBIO: Middleware cambiado a ['auth'] solo, para que cualquier usuario logueado acceda (más rápido para desarrollo; agrega 'can:admin' después si necesitas seguridad)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('admin.panel');
    Route::get('/admin/categoria/{id}', [AdminController::class, 'productosPorCategoria'])->name('admin.categoria');
    Route::get('/admin/producto/crear', [AdminController::class, 'crearProducto'])->name('admin.producto.crear');
    Route::post('/admin/producto', [AdminController::class, 'guardarProducto'])->name('admin.producto.guardar');
    Route::get('/admin/producto/{id}/editar', [AdminController::class, 'editarProducto'])->name('admin.producto.editar');
    Route::put('/admin/producto/{producto}', [AdminController::class, 'actualizarProducto'])->name('admin.producto.actualizar');
    Route::delete('/admin/producto/{id}', [AdminController::class, 'eliminarProducto'])->name('admin.producto.eliminar');
    Route::delete('/admin/producto/imagen/{image}', [AdminController::class, 'eliminarImagen'])->name('admin.producto.eliminar-imagen');;

    // Pedidos admin
    Route::get('/admin/pedidos', [AdminController::class, 'ordersIndex'])->name('admin.orders.index');
    Route::get('/admin/pedidos/{order}', [AdminController::class, 'ordersShow'])->name('admin.orders.show');
    Route::patch('/admin/pedidos/{order}/status', [AdminController::class, 'ordersUpdateStatus'])->name('admin.orders.update-status');
    Route::patch('/admin/pedidos/{order}/payment-status', [AdminController::class, 'ordersUpdatePaymentStatus'])->name('admin.orders.update-payment-status');
    Route::post('/admin/pedidos/{order}/status', [AdminController::class, 'ordersChangeStatus'])->name('admin.orders.change-status');
    Route::post('/admin/pedidos/{order}/payment-status', [AdminController::class, 'ordersChangePaymentStatus'])->name('admin.orders.change-payment-status');
    Route::post('/admin/pedidos/{order}/cancel', [AdminController::class, 'ordersCancel'])->name('admin.orders.cancel');
});

    // ================= AUTO-LOGIN =================
Route::get('/auto-login', function (Request $request) {
    $userId = $request->query('user_id');
    $orderId = $request->query('order_id');
    $signature = $request->query('signature');

    if (!$userId || !$orderId || !$signature) {
        return redirect('/login')->with('error', 'Enlace inválido');
    }

    // Validar firma (expira en 5 min)
    try {
        $data = json_decode(base64_decode($signature), true);
        if (!$data || $data['user_id'] != $userId || $data['order_id'] != $orderId || (time() - $data['timestamp']) > 300) {
            return redirect('/login')->with('error', 'Enlace expirado o inválido');
        }
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Enlace corrupto');
    }

    $user = \App\Models\User::find($userId);
    if (!$user) {
        return redirect('/login')->with('error', 'Usuario no encontrado');
    }

    Auth::login($user);

    return redirect()->route('user.orders.show', $orderId);
})->name('auto.login');
require __DIR__ . '/auth.php';