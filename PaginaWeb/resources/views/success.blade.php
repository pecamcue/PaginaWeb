<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Gracias por tu pedido! #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { background: #2CA1B5; color: white; padding: 1.5rem; text-align: center; border-radius: 8px 8px 0 0; }
        
        .product-img { 
            width: 80px; 
            height: auto; 
            max-height: 80px; 
            object-fit: contain; 
            border-radius: 4px; 
            background-color: #fff;
            border: 1px solid #eee;
        }

        .graduacion-container { font-size: 0.9rem; color: #555; margin-top: 8px; line-height: 1.5; }
        .dato-linea { display: block; margin-bottom: 2px; }
        .separador-ojo { margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #eee; }
        .separador-ojo:last-child { border-bottom: none; }
        
        .text-primary { color: #2CA1B5 !important; }
        .btn-primary { background-color: #2CA1B5; border-color: #2CA1B5; }
        .btn-primary:hover { background-color: #248a9b; border-color: #248a9b; }
        .btn-outline-primary { color: #2CA1B5; border-color: #2CA1B5; }
        .btn-outline-primary:hover { background-color: #2CA1B5; color: white; }

        @media print {
            body { background: white; margin: 0; padding: 0; font-size: 12px; }
            .btn, .sweetalert, .no-print { display: none !important; }
            .card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
<div class="container mt-4 mb-5">

    <div class="header">
        <h1 class="mb-0">¡Gracias por su pedido!</h1>
    </div>

    <div class="card border-0">
        <div class="card-body p-4">

            <h5 class="text-primary fw-bold">Detalles del pedido:</h5>
            <p class="mb-2">
                <strong>Nº Pedido:</strong> {{ $order->id }}<br>
                <strong>Fecha:</strong> {{ $order->order_date->format('d/m/Y') }}
            </p>

            <hr class="my-3">

            <h5 class="text-primary fw-bold">Envío:</h5>
            <div class="alert alert-info border-0 bg-light p-2 mb-3 small">
                <small class="text-primary">
                    <strong>Compruebe especialmente el código postal y que la dirección esté correcta y completa.</strong>
                </small>
            </div>
            <p class="mb-2 small">
                <strong>Método:</strong> {{ $order->shipping_method ?? 'Mensajería' }}<br>
                <strong>Dirección:</strong><br>
                {{ $order->user->name ?? '' }} {{ $order->user->apellidos ?? '' }}<br>
                {{ $order->user->calle ?? '' }} {{ $order->user->numero ?? '' }} {{ $order->user->piso ?? '' }}<br>
                {{ $order->user->ciudad ?? '' }} - {{ $order->user->codigo_postal ?? '' }}<br>
                Tel: {{ $order->user->telefono ?? '' }}
            </p>

            <hr class="my-3">

            <h5 class="text-primary fw-bold">Artículos:</h5>

            @foreach($order->orderItems as $item)
            @php
                // 1. DETECCIÓN DE TIPO
                $categoriaNombre = strtolower($item->product->categoria->nombre ?? '');
                $nombreProducto = strtolower($item->product->marca . ' ' . $item->product->modelo);

                $esCristalGafa = !empty($item->tipo_cristal) && empty($item->tipo_lentilla);
                $pareceLentillaPorNombre = (str_contains($categoriaNombre, 'lentilla') || str_contains($categoriaNombre, 'contact') || str_contains($nombreProducto, 'lentilla'));
                $esLentilla = ( !empty($item->tipo_lentilla) || $pareceLentillaPorNombre ) && !$esCristalGafa;
                
                // 2. LÓGICA STRICTA (Mostrar solo si existe en BD)
                $mostrarOD = !is_null($item->od_esfera);
                $mostrarOI = !is_null($item->oi_esfera);

                // Valores directos
                $od_esf = $item->od_esfera; 
                $oi_esf = $item->oi_esfera;

                // Definir imagen y nombre
                if ($esCristalGafa) {
                    $tipo = strtolower($item->tipo_cristal);
                    $nombreMostrar = 'Lentes Graduadas';
                    if (str_contains($tipo, 'sol')) {
                        $imagen = asset('img/cristal_graduado_sol.jpg');
                    } else {
                        $imagen = asset('img/lentes_gradudada_blanca.jpg');
                    }
                } else {
                    $nombreMostrar = $item->product->marca . ' ' . $item->product->modelo;
                    $imagen = $item->product->imagen
                        ? asset('storage/' . $item->product->imagen)
                        : asset('img/default-product.png');
                }
            @endphp

            <div class="d-flex align-items-start mb-3 p-3 border rounded bg-light">
                <img src="{{ $imagen }}" class="product-img me-3 mt-1">

                <div class="flex-grow-1">
                    <strong style="font-size: 1.1rem;">
                        {{ $nombreMostrar }}
                    </strong>
                    <div class="text-muted small mb-2">Cantidad: {{ $item->cantidad }}</div>

                    <div class="graduacion-container">
                        
                        {{-- BLOQUE LENTILLAS --}}
                        @if($esLentilla)
                            {{-- Ojo Derecho --}}
                            @if($mostrarOD)
                            <div class="separador-ojo">
                                <div>
                                    <strong>OD:</strong> Esf: {{ $od_esf }}
                                    @if($item->od_cilindro && $item->od_cilindro != '0.00') , Cil: {{ $item->od_cilindro }} @endif
                                    @if($item->od_eje) , Eje: {{ $item->od_eje }} @endif
                                </div>
                                {{-- Adición --}}
                                @if(!empty($item->adicion) && $item->adicion != '0.00') 
                                    <div class="dato-linea"><strong>Adición:</strong> {{ $item->adicion }}</div>
                                @endif
                                {{-- Ojo Dominante (SIN COLOR AZUL) --}}
                                @if($item->ojo_dominante === 'Derecho') 
                                    <div class="dato-linea"><strong>Ojo Dominante:</strong> Derecho</div>
                                @endif
                            </div>
                            @endif

                            {{-- Ojo Izquierdo --}}
                            @if($mostrarOI)
                            <div class="separador-ojo">
                                <div>
                                    <strong>OI:</strong> Esf: {{ $oi_esf }}
                                    @if($item->oi_cilindro && $item->oi_cilindro != '0.00') , Cil: {{ $item->oi_cilindro }} @endif
                                    @if($item->oi_eje) , Eje: {{ $item->oi_eje }} @endif
                                </div>
                                {{-- Adición --}}
                                @if(!empty($item->adicion) && $item->adicion != '0.00') 
                                    <div class="dato-linea"><strong>Adición:</strong> {{ $item->adicion }}</div>
                                @endif
                                {{-- Ojo Dominante (SIN COLOR AZUL) --}}
                                @if($item->ojo_dominante === 'Izquierdo') 
                                    <div class="dato-linea"><strong>Ojo Dominante:</strong> Izquierdo</div>
                                @endif
                            </div>
                            @endif

                            {{-- Color --}}
                            @if(!empty($item->color_lentilla))
                                <div class="mt-2"><strong>Color:</strong> {{ $item->color_lentilla }}</div>
                            @endif

                            @if(!$mostrarOD && !$mostrarOI)
                                <div class="text-muted fst-italic small">Sin graduación especificada</div>
                            @endif
                        @endif

                        {{-- BLOQUE GAFAS (Lentes Graduadas) --}}
                        @if($esCristalGafa)
                            <div class="mb-2 pb-2 border-bottom border-light">
                                <div>
                                    <strong>OD:</strong> Esf: {{ $item->od_esfera ?? '0.00' }}
                                    @if($item->od_cilindro && $item->od_cilindro != '0.00') , Cil: {{ $item->od_cilindro }}, Eje: {{ $item->od_eje ?? '0' }} @endif
                                </div>
                                <div>
                                    <strong>OI:</strong> Esf: {{ $item->oi_esfera ?? '0.00' }}
                                    @if($item->oi_cilindro && $item->oi_cilindro != '0.00') , Cil: {{ $item->oi_cilindro }}, Eje: {{ $item->oi_eje ?? '0' }} @endif
                                </div>
                            </div>
                            
                            {{-- Detalles de la Lente --}}
                            <div class="mt-2">
                                @if(!empty($item->tipo_cristal))
                                    <div class="dato-linea"><strong>Tipo:</strong> {{ $item->tipo_cristal }}</div>
                                @endif
                                @if(!empty($item->indice_lente))
                                    <div class="dato-linea"><strong>Índice:</strong> {{ $item->indice_lente }}</div>
                                @endif
                                @if(!empty($item->color_cristal))
                                    <div class="dato-linea"><strong>Color:</strong> {{ $item->color_cristal }}</div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>

                <div class="text-end text-nowrap ms-2">
                    <strong>{{ number_format($item->precio_unitario * $item->cantidad, 2) }} €</strong>
                </div>
            </div>
            @endforeach

            <hr>

            <div class="text-end mt-3 small">
                <p class="mb-1"><strong>Subtotal:</strong> {{ number_format($order->subtotal, 2) }} €</p>
                <p class="mb-1"><strong>Envío:</strong> {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2).' €' : 'Gratis' }}</p>
                <p class="h6 text-primary" style="font-size: 1.2rem;"><strong>Total (Impuestos Inc.):</strong> {{ number_format($order->total_amount, 2) }} €</p>
            </div>

            <div class="text-center mt-4 no-print">
                @php
                    $signatureData = ['user_id' => $order->user->id, 'order_id' => $order->id, 'timestamp' => time()];
                    $signature = base64_encode(json_encode($signatureData));
                @endphp
                <a href="{{ route('auto.login') }}?user_id={{ $order->user->id }}&order_id={{ $order->id }}&signature={{ $signature }}" class="btn btn-primary btn-lg">Ver en Mi Cuenta</a>
                <button onclick="window.print()" class="btn btn-outline-secondary ms-2">Imprimir</button>
                <a href="{{ $redirectUrl }}" class="btn btn-outline-primary ms-2">Volver a la tienda</a>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Pago confirmado!',
            text: 'Su pedido se ha procesado correctamente y se ha enviado un correo de confirmación.',
            timer: 3000,
            showConfirmButton: false
        });
    });
</script>
</body>
</html>