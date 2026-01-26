<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido #{{ $order->id }}</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f4f4f4;color:#333;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.1);">
<tr>
    <td style="background:#2CA1B5;padding:20px;text-align:center;">
        <img src="{{ asset('img/LogoVector.png') }}" alt="Logo" style="max-width:150px;height:auto;">
        <h1 style="color:#fff;margin:10px 0;font-size:24px;">¡Pedido Confirmado!</h1>
    </td>
</tr>
<tr><td style="padding:30px;">
<p style="font-size:16px;line-height:1.5;margin-bottom:20px;">
    ¡Hola, {{ $order->user->name ?? 'Usuario' }}!<br>
    Muchas gracias por tu compra en Óptica y Audiología Concha Cuevas.
</p>
<h3 style="color:#2CA1B5;margin-bottom:10px;">Artículos en tu Pedido</h3>
<ul style="font-size:16px;line-height:1.5;margin:0 0 20px;padding-left:0;list-style:none;">

@foreach($order->orderItems as $item)
    @php
        // 1. DETECCIÓN ROBUSTA
        $producto = $item->product;
        $categoriaNombre = strtolower($producto->categoria->nombre ?? '');
        $nombreProductoBase = trim(($producto->marca ?? '').' '.($producto->modelo ?? 'Producto'));

        $esCristalGafa = !empty($item->tipo_cristal) && empty($item->tipo_lentilla);
        $pareceLentillaPorNombre = (str_contains($categoriaNombre, 'lentilla') || str_contains($categoriaNombre, 'contact') || str_contains(strtolower($nombreProductoBase), 'lentilla'));
        $esLentilla = ( !empty($item->tipo_lentilla) || $pareceLentillaPorNombre ) && !$esCristalGafa;
        
        // 2. LÓGICA ESTRICTA
        $mostrarOD = !is_null($item->od_esfera);
        $mostrarOI = !is_null($item->oi_esfera);

        // Valores
        $od_esf = $item->od_esfera; 
        $oi_esf = $item->oi_esfera;

        // Nombre
        if ($esCristalGafa) {
            $nombreMostrar = 'Lentes Graduadas';
        } else {
            $nombreMostrar = $nombreProductoBase;
        }
        
        $precioTotalItem = $item->precio_unitario * $item->cantidad;
    @endphp

    <li style="margin-bottom:25px;border-bottom:1px solid #ddd;padding-bottom:10px;">
        
        <div style="font-weight:bold;overflow:hidden;margin-bottom:5px;">
            • {{ $nombreMostrar }} ({{ $item->cantidad }} uds.)
            <span style="float:right;">{{ number_format($precioTotalItem, 2) }} €</span>
        </div>

        <div style="margin-top:10px;font-size:14px;line-height:1.6;padding-left:15px;color:#555;">
            
            {{-- LENTILLAS --}}
            @if($esLentilla)
                
                {{-- Ojo Derecho --}}
                @if($mostrarOD)
                <div style="margin-bottom: 8px; border-bottom: 1px dashed #eee; padding-bottom: 4px;">
                    <div>
                        <strong>OD:</strong> Esf: {{ $od_esf }}
                        @if($item->od_cilindro && $item->od_cilindro != '0.00'), Cil: {{ $item->od_cilindro }} @endif
                        @if($item->od_eje), Eje: {{ $item->od_eje }} @endif
                    </div>
                    @if(!empty($item->adicion) && $item->adicion != '0.00')
                        <div><strong>Adición:</strong> {{ $item->adicion }}</div>
                    @endif
                    @if($item->ojo_dominante === 'Derecho')
                        <div style="margin-top:2px;"><strong>Ojo Dominante:</strong> Derecho</div>
                    @endif
                </div>
                @endif

                {{-- Ojo Izquierdo --}}
                @if($mostrarOI)
                <div style="margin-bottom: 8px;">
                    <div>
                        <strong>OI:</strong> Esf: {{ $oi_esf }}
                        @if($item->oi_cilindro && $item->oi_cilindro != '0.00'), Cil: {{ $item->oi_cilindro }} @endif
                        @if($item->oi_eje), Eje: {{ $item->oi_eje }} @endif
                    </div>
                    @if(!empty($item->adicion) && $item->adicion != '0.00')
                        <div><strong>Adición:</strong> {{ $item->adicion }}</div>
                    @endif
                    @if($item->ojo_dominante === 'Izquierdo')
                        <div style="margin-top:2px;"><strong>Ojo Dominante:</strong> Izquierdo</div>
                    @endif
                </div>
                @endif

                @if(!empty($item->color_lentilla))
                    <div style="margin-top:5px;"><strong>Color:</strong> {{ $item->color_lentilla }}</div>
                @endif

                @if(!$mostrarOD && !$mostrarOI)
                    <div style="font-style:italic;color:#999;">Sin graduación especificada</div>
                @endif

            {{-- GAFAS --}}
            @elseif($esCristalGafa)
                <div style="font-weight:bold;margin-bottom:5px;color:#333;">DATOS DE GRADUACIÓN:</div>
                <div style="margin-bottom:10px;">
                    <div><strong>OD:</strong> Esf: {{ $item->od_esfera ?? '0.00' }} 
                        @if($item->od_cilindro && $item->od_cilindro != '0.00'), Cil: {{ $item->od_cilindro }}, Eje: {{ $item->od_eje ?? '0' }} @endif
                    </div>
                    <div><strong>OI:</strong> Esf: {{ $item->oi_esfera ?? '0.00' }}
                        @if($item->oi_cilindro && $item->oi_cilindro != '0.00'), Cil: {{ $item->oi_cilindro }}, Eje: {{ $item->oi_eje ?? '0' }} @endif
                    </div>
                </div>

                <div style="font-weight:bold;margin-top:10px;margin-bottom:5px;color:#333;">CARACTERÍSTICAS DEL CRISTAL:</div>
                @if(!empty($item->tipo_cristal))
                    <div><strong>Tratamiento:</strong> {{ $item->tipo_cristal }}</div>
                @endif
                @if(!empty($item->indice_lente))
                    <div><strong>Índice:</strong> {{ $item->indice_lente }}</div>
                @endif
                @if(!empty($item->color_cristal))
                    <div><strong>Color:</strong> {{ $item->color_cristal }}</div>
                @endif
            @endif

        </div>
    </li>
@endforeach

</ul>

@if($order->shipping_cost > 0)
    <ul style="list-style:none;padding:0;margin:0 0 10px;">
        <li style="border-top:1px solid #ddd;padding:10px 0;overflow:hidden;">
            <strong>Gastos de Envío</strong>
            <span style="float:right;">{{ number_format($order->shipping_cost, 2) }} €</span>
        </li>
    </ul>
@endif

<p style="text-align:right;margin:20px 0;font-size:18px;font-weight:bold;color:#2CA1B5;">
    Total Pagado: {{ number_format($order->total_amount, 2) }} €
</p>
<p style="text-align:center;font-weight:bold;color:#28a745;margin-top:40px;">
    ¡Gracias por elegirnos! Tu satisfacción es nuestra prioridad.
</p>
</td></tr>
<tr>
    <td style="background:#f8f9fa;padding:20px;text-align:center;font-size:14px;color:#6c757d;border-top:1px solid #dee2e6;">
        <p style="margin:0;font-weight:bold;">Óptica y Audiología Concha Cuevas</p>
        <p style="margin:5px 0;">Av. Seminari 4, 46113 Moncada, Valencia | Tel: 644 100 773</p>
        <p style="margin:0;"><a href="mailto:info@conchacuevas.es" style="color:#2CA1B5;text-decoration:none;">info@conchacuevas.es</a></p>
    </td>
</tr>
</table>
</td></tr>
</table>
</body>
</html>