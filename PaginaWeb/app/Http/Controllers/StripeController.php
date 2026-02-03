<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotification;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\PaymentIntent;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\ConfirmacionPedido;
use App\Mail\AdminOrderNotificationPedido;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;


class StripeController extends Controller
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
    
    // Función helper para determinar si es una Lente/Cristal (con o sin graduación)
    private function isGafaGraduatedLens($item)
    {
        return empty($item->tipo_lentilla) && !empty($item->tipo_cristal);
    }
    
    /**
     * Función helper para procesar datos de factura y crear el registro Factura.
     */
    private function _processInvoiceData(Order $order)
    {
        $order->load(['orderItems.product.categoria', 'user']);

        $itemsWithIVA = [];
        $subtotalTotal = 0;
        $impuestosTotal = 0;

        foreach ($order->orderItems as $item) {
            $categoria = $item->product->categoria ?? null;
            $categoriaNombre = strtolower($categoria->nombre ?? '');
            
            $esLentillasOLiquidos = !empty($item->tipo_lentilla) || $categoriaNombre === 'liquidos';
            $esGafasGraduadas = $this->isGafaGraduatedLens($item);
            
            $itemsToFacture = [];

            if ($esGafasGraduadas) {
                $precioMonturaBase = $item->product->precio ?? 0;

                $precioMonturaConIVA = $precioMonturaBase * $item->cantidad;
                $ivaRateMontura = 0.10;
                
                $precioSuplementoUnitario = max(0, $item->precio_unitario - $precioMonturaBase);
                $precioSuplementoConIVA = $precioSuplementoUnitario * $item->cantidad;
                $ivaRateSuplemento = 0.10;
                
                if ($precioMonturaConIVA > 0) {
                    $itemsToFacture[] = [
                        'nombre' => $item->product->marca . ' ' . $item->product->modelo . ' (Montura de Vista)',
                        'precio_con_iva' => $precioMonturaConIVA,
                        'iva_rate' => $ivaRateMontura,
                        'cantidad' => $item->cantidad,
                    ];
                }
                
                if ($precioSuplementoConIVA > 0) {
                    $itemsToFacture[] = [
                        'nombre' => 'Lentes Graduadas (' . ($item->product->modelo ?? 'N/A') . ')',
                        'precio_con_iva' => $precioSuplementoConIVA,
                        'iva_rate' => $ivaRateSuplemento,
                        'cantidad' => $item->cantidad,
                    ];
                }
            } 
            else {
                $precioConIVA = $item->precio_unitario * $item->cantidad;
                $ivaRate = 0.21;

                if ($esLentillasOLiquidos) {
                    $ivaRate = 0.10;
                } elseif ($categoriaNombre === 'accesorios' || $categoriaNombre === 'pilas' || $categoriaNombre === 'gafas de sol') {
                    $ivaRate = 0.21;
                }
                
                if ($precioConIVA > 0) {
                    $itemsToFacture[] = [
                        'nombre' => $item->product->marca . ' ' . $item->product->modelo,
                        'precio_con_iva' => $precioConIVA,
                        'iva_rate' => $ivaRate,
                        'cantidad' => $item->cantidad,
                    ];
                }
            }
            
            foreach($itemsToFacture as $tempItem) {
                if ($tempItem['precio_con_iva'] <= 0) {
                    continue; 
                }
                
                $ivaRate = $tempItem['iva_rate'];
                $base = $tempItem['precio_con_iva'] / (1 + $ivaRate);
                $imp = $base * $ivaRate;

                $subtotalTotal += round($base, 2); 
                $impuestosTotal += round($imp, 2);

                $itemsWithIVA[] = [
                    'nombre' => $tempItem['nombre'],
                    'cantidad' => $tempItem['cantidad'],
                    'precio_unitario' => $tempItem['precio_con_iva'] / $tempItem['cantidad'], 
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
                    'tipo_lentilla' => $item->tipo_lentilla,
                    'categoria' => $categoria ? $categoria->nombre : 'General',
                    'iva_rate' => $ivaRate,
                    'base_sin_iva' => round($base, 2), 
                    'impuesto' => round($imp, 2), 
                ];
            }
        }

        if ($order->shipping_cost > 0) {
            $ivaShip = 0.21;
            $baseShip = $order->shipping_cost / (1 + $ivaShip);
            $impShip = $baseShip * $ivaShip;
            $subtotalTotal += round($baseShip, 2);
            $impuestosTotal += round($impShip, 2);
            
            $itemsWithIVA[] = [
                'nombre' => 'Gastos de envío',
                'cantidad' => 1,
                'precio_unitario' => $order->shipping_cost, 
                'iva_rate' => $ivaShip,
                'base_sin_iva' => round($baseShip, 2),
                'impuesto' => round($impShip, 2),
                'categoria' => 'Envío',
                'od_esfera' => null, 'od_cilindro' => null, 'od_eje' => null, 
                'oi_esfera' => null, 'oi_cilindro' => null, 'oi_eje' => null,
                'adicion' => null, 'ojo_dominante' => null, 'tipo_cristal' => null,
                'indice_lente' => null, 'color_cristal' => null, 'tipo_lentilla' => null,
            ];
        }

        $factura = Factura::firstOrCreate(
            ['order_id' => $order->id],
            [
                'numero_factura' => Factura::generarNumeroFactura(),
                'user_id' => $order->user_id,
                'fecha_emision' => now(),
                'subtotal' => round($subtotalTotal, 2),
                'impuestos' => round($impuestosTotal, 2),
                'total' => round($order->total_amount, 2), 
            ]
        );

        $factura->load(['order.orderItems.product.categoria', 'user']);
        
        $tempAddress = json_decode($order->temp_address, true);
        $user = $order->user;

        $calle = $tempAddress['calle'] ?? ($user->calle ?? '');
        $numero = $tempAddress['numero'] ?? ($user->numero ?? '');
        $piso = $tempAddress['piso'] ?? ($user->piso ?? '');
        $ciudad = $tempAddress['ciudad'] ?? ($user->ciudad ?? '');
        $cp = $tempAddress['codigo_postal'] ?? ($user->codigo_postal ?? '');

        $direccion = trim($calle . ' ' . $numero);
        if (!empty($piso)) {
            $direccion .= ', ' . $piso;
        }

        $localidad_cp = trim($ciudad . (!empty($cp) ? ' - ' . $cp : ''));
        
        $nombre_completo = trim(($user->name ?? '') . ' ' . ($user->apellidos ?? '')) ?: 'N/A';
        $direccion_final = $direccion ?: 'N/A';
        $localidad_cp_final = $localidad_cp ?: 'N/A';

        $userData = [
            'nombre_completo' => $nombre_completo,
            'email' => $user->email ?? 'N/A',
            'direccion' => $direccion_final,
            'localidad_cp' => $localidad_cp_final,
            'nif' => $user->nif ?? 'N/A', 
            'telefono' => $user->telefono ?? 'N/A',
        ];

        return [
            'factura' => $factura,
            'itemsWithIVA' => $itemsWithIVA,
            'userData' => $userData,
        ];
    }

    public function showCheckout($orderId)
    {
        try {
            $order = Order::with('orderItems.product')->findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $paymentMethods = PaymentMethod::where('user_id', Auth::id())->get();

            return response()->json([
                'order' => [
                    'id' => $order->id,
                    'total' => $order->total_amount,
                    'order_date' => $order->order_date,
                    'items' => $order->orderItems->map(function ($item) {
                        $productNameFull = $item->product
                            ? $item->product->marca . ' ' . $item->product->modelo
                            : 'Producto desconocido';
                            
                        $productModel = $item->product ? $item->product->modelo : 'N/A';

                        $name = $productNameFull;

                        if (!empty($item->tipo_lentilla)) {
                            $name = $productNameFull . ' (Lentilla ' . $item->tipo_lentilla . ')';
                        } elseif ($this->isGafaGraduatedLens($item)) {
                            $name = "Lentes Graduadas (" . $productModel . ")";
                        }

                        $graduacion = [
                            'derecho' => [
                                'esfera' => $item->od_esfera ?? null,
                                'cilindro' => $item->od_cilindro ?? null,
                                'eje' => $item->od_eje ?? null,
                                'adicion' => $item->adicion ?? null,
                                'dominante' => 'No', 
                            ],
                            'izquierdo' => [
                                'esfera' => $item->oi_esfera ?? null,
                                'cilindro' => $item->oi_cilindro ?? null,
                                'eje' => $item->oi_eje ?? null,
                                'adicion' => $item->adicion ?? null,
                                'dominante' => 'No', 
                            ],
                        ];

                        if ($item->ojo_dominante === 'Derecho') {
                            $graduacion['derecho']['dominante'] = 'Sí';
                            $graduacion['izquierdo']['dominante'] = 'No';
                        } elseif ($item->ojo_dominante === 'Izquierdo') {
                            $graduacion['derecho']['dominante'] = 'No';
                            $graduacion['izquierdo']['dominante'] = 'Sí';
                        }

                        if ($item->tipo_lentilla === 'multifocal') {
                            $graduacion['derecho']['cilindro'] = null;
                            $graduacion['derecho']['eje'] = null;
                            $graduacion['izquierdo']['cilindro'] = null;
                            $graduacion['izquierdo']['eje'] = null;
                        }

                        return [
                            'product_id' => $item->product_id,
                            'name' => $name,
                            'cantidad' => $item->cantidad,
                            'precio_unitario' => $item->precio_unitario,
                            'tipo_cristal' => $item->tipo_cristal,
                            'indice_lente' => $item->indice_lente,
                            'color_cristal' => $item->color_cristal,
                            'tipo_lentilla' => $item->tipo_lentilla,
                            'graduacion' => $graduacion,
                            'product' => $item->product ? ['imagen' => $item->product->imagen] : null,
                        ];
                    })->toArray(),
                ],
                'paymentMethods' => $paymentMethods,
            ]);
        } catch (\Exception $e) {
            Log::error('Error en showCheckout: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Error al cargar los datos del checkout: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cart' => 'required|array',
                'cart.*.product_id' => 'required|integer|exists:products,id',
                'cart.*.cantidad' => 'required|integer|min:1',
                'cart.*.precio_unitario' => 'required|numeric|min:0',
                'cart.*.graduacion' => 'nullable|array',
                'cart.*.tipo_cristal' => 'nullable|string',
                'cart.*.indice_lente' => 'nullable|string',
                'cart.*.color_cristal' => 'nullable|string',
                'cart.*.tipo_lentilla' => 'nullable|string',
                'total' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                Log::error('Validación fallida en createOrder: ' . json_encode($validator->errors()));
                return response()->json(['error' => $validator->errors()], 400);
            }

            $cart = $request->input('cart');
            $total = $request->input('total');

            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['precio_unitario'] * $item['cantidad'];
            }

            $shippingCost = $subtotal < 50 ? 5.95 : 0;

            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pendiente',
                'payment_status' => 'pendiente',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'shipping_method' => 'Envío estándar',
                'payment_method' => 'stripe',
                'total_amount' => $total,
                'order_date' => now(),
            ]);

            foreach ($cart as $item) {
                $graduacion = $item['graduacion'] ?? [];
                Log::info('Datos de graduación recibidos para item: ' . json_encode($graduacion));

                $ojoDominante = null;
                if (isset($graduacion['derecho']['dominante']) && strtolower($graduacion['derecho']['dominante']) === 'sí') {
                    $ojoDominante = 'Derecho';
                } elseif (isset($graduacion['izquierdo']['dominante']) && strtolower($graduacion['izquierdo']['dominante']) === 'sí') {
                    $ojoDominante = 'Izquierdo';
                }

                Log::info('Asignando ojo_dominante para item: ' . $ojoDominante);

                $od_esfera = isset($graduacion['derecho']) 
                    ? ($graduacion['derecho']['esfera'] ?? '0.00') 
                    : null;

                $oi_esfera = isset($graduacion['izquierdo']) 
                    ? ($graduacion['izquierdo']['esfera'] ?? '0.00') 
                    : null;

                Order_item::create([
                    'order_id' => $order->id,
                    'product_id' => (int) $item['product_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    
                    'od_esfera' => $od_esfera,
                    'oi_esfera' => $oi_esfera,
                    
                    'od_cilindro' => $graduacion['derecho']['cilindro'] ?? null,
                    'od_eje' => $graduacion['derecho']['eje'] ?? null,
                    'oi_cilindro' => $graduacion['izquierdo']['cilindro'] ?? null,
                    'oi_eje' => $graduacion['izquierdo']['eje'] ?? null,
                    'adicion' => $graduacion['derecho']['adicion'] ?? null,
                    'ojo_dominante' => $ojoDominante,
                    'tipo_cristal' => $item['tipo_cristal'] ?? null,
                    'indice_lente' => $item['indice_lente'] ?? null,
                    'color_cristal' => $item['color_cristal'] ?? null,
                    'tipo_lentilla' => $item['tipo_lentilla'] ?? null,
                    'color_lentilla' => $item['color_lentilla'] ?? null,
                ]);

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['cantidad']);
                } else {
                    DB::rollBack();
                    return response()->json(['error' => 'Producto no encontrado: ' . $item['product_id']], 400);
                }
            }
            
            $this->_processInvoiceData($order);

            DB::commit();
            return response()->json(['order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en createOrder: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error al crear la orden: ' . $e->getMessage()], 500);
        }
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));
            $order = Order::findOrFail($request->order_id);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => (int) (round($order->total_amount, 2) * 100),
                'currency' => 'eur',
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => Auth::id()
                ],
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);

        } catch (\Exception $e) {
            Log::error('Error Stripe Intent: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // NUEVO: Crear sesión de Stripe Checkout (redirección a pasarela oficial)
    public function createStripeCheckoutSession(Request $request, $orderId)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));

            $order = Order::with('orderItems.product')->findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            if ($order->payment_status === 'pagado') {
                return response()->json(['error' => 'El pedido ya está pagado'], 400);
            }

            $lineItems = [];
            foreach ($order->orderItems as $item) {
                $productName = $item->product
                    ? ($item->product->marca . ' ' . $item->product->modelo)
                    : 'Producto #' . $item->product_id;
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => ['name' => $productName],
                        'unit_amount' => (int) round($item->precio_unitario * 100),
                    ],
                    'quantity' => (int) $item->cantidad,
                ];
            }

            if ($order->shipping_cost > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => ['name' => 'Gastos de envío'],
                        'unit_amount' => round($order->shipping_cost * 100),
                    ],
                    'quantity' => 1,
                ];
            }

            $session = CheckoutSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?order_id=' . $orderId,
                'cancel_url' => route('stripe.cancel') . '?order_id=' . $orderId,
                'metadata' => ['order_id' => $order->id],
            ]);

            return response()->json(['url' => $session->url]);

        } catch (\Exception $e) {
            Log::error('Error creando sesión Stripe Checkout: ' . $e->getMessage());
            return response()->json(['error' => 'Error al iniciar pago con Stripe'], 500);
        }
    }

    // NUEVO: Generar URL para PAYCOMET / Banco Sabadell (usando el paquete oficial)
    public function generatePaycometUrl(Request $request, $orderId)
{
    try {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($order->payment_status === 'pagado') {
            return response()->json(['error' => 'El pedido ya está pagado'], 400);
        }

        $merchantCode = env('PAYCOMET_MERCHANT_CODE', '999008881');
        $terminal = env('PAYCOMET_TERMINAL', '1');
        $password = env('PAYCOMET_PASSWORD', 'sq7HjrUOBfKmC576ILgskD5srU870gJ7');

        $amount = (int) round($order->total_amount * 100);
        $orderReference = 'PED' . str_pad($order->id, 8, '0', STR_PAD_LEFT);

        $signatureString = $merchantCode . $orderReference . $amount . $terminal . 'EUR' . $password;
        $signature = strtoupper(hash('sha512', $signatureString));

        $baseUrl = rtrim(env('PAYMENT_RETURN_BASE_URL', config('app.url')), '/');
        $urlOk = $baseUrl . '/payment/success?order_id=' . $order->id;
        $urlKo = $baseUrl . '/payment/cancel?order_id=' . $order->id;

        $params = [
            'DS_MERCHANT_MERCHANTCODE'       => $merchantCode,
            'DS_MERCHANT_TERMINAL'           => $terminal,
            'DS_MERCHANT_ORDER'              => $orderReference,
            'DS_MERCHANT_AMOUNT'             => $amount,
            'DS_MERCHANT_CURRENCY'           => '978',
            'DS_MERCHANT_TRANSACTIONTYPE'    => '0',
            'DS_MERCHANT_MERCHANTSIGNATURE'  => $signature,
            'DS_MERCHANT_URLOK'              => $urlOk,
            'DS_MERCHANT_URLKO'              => $urlKo,
            'DS_MERCHANT_MERCHANTNAME'       => config('app.name'),
            'DS_MERCHANT_CONSUMERLANGUAGE'   => '001',
            'DS_MERCHANT_PRODUCTDESCRIPTION' => 'Pedido #' . $order->id . ' en ' . config('app.name'),
        ];

        // ENDPOINT CORRECTO CON .php AL FINAL
        $paycometUrl = 'https://api.paycomet.com/gateway/xml-bankstore.php?' . http_build_query($params);

        return response()->json(['url' => $paycometUrl]);

    } catch (\Exception $e) {
        Log::error('Error generando URL PAYCOMET: ' . $e->getMessage());
        return response()->json(['error' => 'Error al iniciar el pago con tarjeta'], 500);
    }
}
    public function success(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));

            $orderId = $request->query('order_id');

            Log::info('Iniciando success para order_id: ' . $orderId);

            $order = Order::with('orderItems.product.categoria', 'user')->findOrFail($orderId);

            if ($order->status === 'pendiente') {
                DB::beginTransaction();

                $order->update([
                    'status' => 'preparacion',
                    'payment_status' => 'pagado',
                ]);

                $this->_processInvoiceData($order);

                DB::commit();

                // Vaciar carrito
                try {
                    if (Auth::check()) {
                        Auth::user()->cart()->delete();
                    } else {
                        DB::table('carts')->where('user_id', $order->user_id)->delete();
                    }
                } catch (\Exception $cartError) {
                    Log::error('Error vaciando carrito: ' . $cartError->getMessage());
                }

                // Email de confirmación al cliente
                try {
                    $user = $order->user;
                    if ($user && $user->email) {
                        Mail::to($user->email)->send(new ConfirmacionPedido($order));
                    }
                } catch (\Exception $emailError) {
                    Log::error('Error enviando email para order_id: ' . $order->id . ': ' . $emailError->getMessage(), ['trace' => $emailError->getTraceAsString()]);
                }

                // Email confirmacion pedido al administrador
                try {
                    Mail::to('pecamcue09@hotmail.com')->send(new AdminOrderNotification($order));
                } catch (\Exception $adminEmailError) {
                    Log::error('Error enviando email al administrador para order_id: ' . $order->id . ': ' . $adminEmailError->getMessage());
                }

                return view('success', [
                    'order' => $order,
                    'redirectUrl' => 'http://localhost:4200/inicio?payment=success&order_id=' . $order->id
                ]);
            } else {
                Log::warning('Pago no confirmado para order_id: ' . $order->id . ', status: ' . $order->status);
                $order->update(['status' => 'cancelado', 'payment_status' => 'cancelado']);
                return view('cancel', [
                    'order_id' => $order->id,
                    'message' => 'Pago no confirmado',
                    'redirectUrl' => 'http://localhost:4200/carrito?payment=cancel&order_id=' . $order->id . '&message=' . urlencode('Pago no confirmado')
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error general en success: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $orderId = $request->query('order_id');
            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status === 'pendiente') {
                    $order->update(['status' => 'cancelado', 'payment_status' => 'cancelado']);
                }
            }
            return view('cancel', [
                'order_id' => $orderId ?? null,
                'message' => $e->getMessage(),
                'redirectUrl' => 'http://localhost:4200/carrito?payment=cancel&order_id=' . ($orderId ?? '') . '&message=' . urlencode($e->getMessage())
            ]);
        }
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $data = $this->_processInvoiceData($order);
        $factura = $data['factura'];
        $itemsWithIVA = $data['itemsWithIVA'];
        $userData = $data['userData'];

        $pdf = Pdf::loadView('emails.factura', [
            'factura' => $factura,
            'itemsWithIVA' => $itemsWithIVA,
            'userData' => $userData
        ]);

        return $pdf->download('factura_' . $factura->numero_factura . '.pdf');
    }

    public function cancel(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status === 'pendiente') {
                    $order->update(['status' => 'cancelado', 'payment_status' => 'cancelado']);
                }
            }

            return view('cancel', [
                'order_id' => $orderId,
                'message' => 'Pago cancelado',
                'redirectUrl' => 'http://localhost:4200/carrito?payment=cancel&order_id=' . ($orderId ?? '') . '&message=' . urlencode('Pago cancelado')
            ]);
        } catch (\Exception $e) {
            return view('cancel', [
                'order_id' => $request->query('order_id') ?? null,
                'message' => $e->getMessage(),
                'redirectUrl' => 'http://localhost:4200/carrito?payment=cancel&order_id=' . ($request->query('order_id') ?? '') . '&message=' . urlencode($e->getMessage())
            ]);
        }
    }

    public function updateOrderAddress(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'calle' => 'required|string',
            'numero' => 'required|string',
            'ciudad' => 'required|string',
            'codigo_postal' => 'required|string',
            'piso' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $order = Order::findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $order->update([
                'temp_address' => json_encode([
                    'calle' => $request->calle,
                    'numero' => $request->numero,
                    'piso' => $request->piso ?? null,
                    'ciudad' => $request->ciudad,
                    'codigo_postal' => $request->codigo_postal,
                ])
            ]);

            return response()->json(['message' => 'Dirección actualizada']);
        } catch (\Exception $e) {
            Log::error('Error actualizando dirección temporal: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}