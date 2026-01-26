<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pedido #{{ $order->id }}</title>
</head>
<body style="margin:0; padding:0; font-family:'Arial', sans-serif; background-color:#f4f4f4; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                    
                    <tr>
                        <td style="background-color:#2CA1B5; padding:20px; text-align:center;">
                            <img src="{{ asset('img/LogoVector.png') }}" alt="Logo Óptica" style="max-width:150px; height:auto; display:block; margin:0 auto;">
                            <h1 style="color:#ffffff; margin:10px 0; font-size:24px;">¡Nuevo Pedido Recibido!</h1>
                            <p style="color:#e0f7fa; margin:5px 0;">Referencia: <strong>#{{ $order->id }}</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;">
                            <h3 style="color:#2CA1B5; margin-bottom:15px; border-bottom:2px solid #2CA1B5; padding-bottom:5px;">Datos de Envío y Contacto</h3>
                            
                            @php
                                $user = $order->user;
                                // Construcción segura de la dirección usando los campos del modelo User
                                $direccion = trim(($user->calle ?? '') . ' ' . ($user->numero ?? ''));
                                if (!empty($user->piso)) {
                                    $direccion .= ', Piso ' . $user->piso;
                                }
                                $ciudadInfo = trim(($user->codigo_postal ?? '') . ' - ' . ($user->ciudad ?? ''));
                                $pais = $user->pais ?? 'España';
                                
                                $nombreCompleto = trim(($user->name ?? '') . ' ' . ($user->apellidos ?? ''));
                            @endphp

                            <div style="background-color:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #eee;">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:15px; line-height:1.6;">
                                    <tr>
                                        <td width="30%" style="font-weight:bold; vertical-align:top;">Cliente:</td>
                                        <td style="vertical-align:top;">{{ $nombreCompleto ?: 'N/D' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; vertical-align:top;">Email:</td>
                                        <td style="vertical-align:top;"><a href="mailto:{{ $user->email }}" style="color:#2CA1B5; text-decoration:none;">{{ $user->email ?? 'N/D' }}</a></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; vertical-align:top;">Teléfono:</td>
                                        <td style="vertical-align:top;"><a href="tel:{{ $user->telefono }}" style="color:#333; text-decoration:none;">{{ $user->telefono ?? 'N/D' }}</a></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; vertical-align:top; padding-top:10px;">Dirección:</td>
                                        <td style="vertical-align:top; padding-top:10px;">
                                            {{ $direccion ?: 'Dirección no disponible' }}<br>
                                            {{ $ciudadInfo }}<br>
                                            {{ $pais }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <h3 style="color:#2CA1B5; margin-top:30px; margin-bottom:15px; border-bottom:2px solid #2CA1B5; padding-bottom:5px;">Artículos a Preparar</h3>
                            
                            <ul style="font-size:15px; line-height:1.5; padding-left:0; list-style:none;">
                                @foreach($order->orderItems as $item)
                                    @php
                                        // 1. Detección Inteligente
                                        $prod = $item->product;
                                        $marcaModelo = trim(($prod->marca ?? '').' '.($prod->modelo ?? 'Producto'));
                                        $catNombre = strtolower($prod->categoria->nombre ?? '');

                                        $esCristalGafa = !empty($item->tipo_cristal) && empty($item->tipo_lentilla);
                                        $pareceLentilla = (str_contains($catNombre, 'lentilla') || str_contains($catNombre, 'contact') || str_contains(strtolower($marcaModelo), 'lentilla'));
                                        $esLentilla = ( !empty($item->tipo_lentilla) || $pareceLentilla ) && !$esCristalGafa;
                                        
                                        // 2. Lógica Estricta de Visualización (Si no es NULL en BD, se muestra)
                                        $mostrarOD = !is_null($item->od_esfera);
                                        $mostrarOI = !is_null($item->oi_esfera);

                                        // Nombre a mostrar
                                        $nombreMostrar = $esCristalGafa ? 'Lentes Graduadas' : $marcaModelo;
                                    @endphp

                                    <li style="margin-bottom:20px; border:1px solid #ddd; border-radius:6px; overflow:hidden;">
                                        
                                        <div style="background-color:#eee; padding:10px; font-weight:bold; color:#333; border-bottom:1px solid #ddd;">
                                            {{ $nombreMostrar }} <span style="font-weight:normal; font-size:13px; color:#555;">(Cant: {{ $item->cantidad }})</span>
                                            <span style="float:right; font-weight:normal;">ID: {{ $item->product_id }}</span>
                                        </div>

                                        <div style="padding:15px; background-color:#fff; color:#555;">
                                            
                                            {{-- LENTILLAS --}}
                                            @if($esLentilla)
                                                @if($mostrarOD)
                                                    <div style="margin-bottom:10px; border-bottom:1px dashed #eee; padding-bottom:8px;">
                                                        <div><strong style="color:#000;">OJO DERECHO:</strong> 
                                                            Esf: {{ $item->od_esfera }}
                                                            @if(!empty($item->od_cilindro) && $item->od_cilindro != '0.00'), Cil: {{ $item->od_cilindro }} @endif
                                                            @if(!empty($item->od_eje)), Eje: {{ $item->od_eje }} @endif
                                                        </div>
                                                        @if(!empty($item->adicion) && $item->adicion != '0.00')
                                                            <div><strong>Adición:</strong> {{ $item->adicion }}</div>
                                                        @endif
                                                        @if($item->ojo_dominante === 'Derecho')
                                                            <div style="color:#444;"><strong>Ojo Dominante:</strong> Derecho</div>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if($mostrarOI)
                                                    <div style="margin-bottom:10px;">
                                                        <div><strong style="color:#000;">OJO IZQUIERDO:</strong> 
                                                            Esf: {{ $item->oi_esfera }}
                                                            @if(!empty($item->oi_cilindro) && $item->oi_cilindro != '0.00'), Cil: {{ $item->oi_cilindro }} @endif
                                                            @if(!empty($item->oi_eje)), Eje: {{ $item->oi_eje }} @endif
                                                        </div>
                                                        @if(!empty($item->adicion) && $item->adicion != '0.00')
                                                            <div><strong>Adición:</strong> {{ $item->adicion }}</div>
                                                        @endif
                                                        @if($item->ojo_dominante === 'Izquierdo')
                                                            <div style="color:#444;"><strong>Ojo Dominante:</strong> Izquierdo</div>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if(!empty($item->color_lentilla))
                                                    <div style="margin-top:5px; padding-top:5px; border-top:1px solid #eee; font-weight:bold; color:#000;">
                                                        Color: {{ $item->color_lentilla }}
                                                    </div>
                                                @endif

                                                @if(!$mostrarOD && !$mostrarOI && empty($item->color_lentilla))
                                                    <div style="font-style:italic; color:#999;">Sin graduación especificada</div>
                                                @endif

                                            {{-- GAFAS GRADUADAS --}}
                                            @elseif($esCristalGafa)
                                                <div style="margin-bottom:10px;">
                                                    <div><strong style="color:#000;">OD:</strong> Esf: {{ $item->od_esfera ?? '0.00' }} 
                                                        @if(!empty($item->od_cilindro) && $item->od_cilindro != '0.00'), Cil: {{ $item->od_cilindro }}, Eje: {{ $item->od_eje ?? '0' }}° @endif
                                                    </div>
                                                    <div><strong style="color:#000;">OI:</strong> Esf: {{ $item->oi_esfera ?? '0.00' }}
                                                        @if(!empty($item->oi_cilindro) && $item->oi_cilindro != '0.00'), Cil: {{ $item->oi_cilindro }}, Eje: {{ $item->oi_eje ?? '0' }}° @endif
                                                    </div>
                                                </div>
                                                
                                                <div style="font-size:13px; background:#f9f9f9; padding:8px; border-radius:4px;">
                                                    <div style="font-weight:bold; margin-bottom:2px;">Detalles Lente:</div>
                                                    @if(!empty($item->tipo_cristal)) <div>Tipo: {{ $item->tipo_cristal }}</div> @endif
                                                    @if(!empty($item->indice_lente)) <div>Índice: {{ $item->indice_lente }}</div> @endif
                                                    @if(!empty($item->color_cristal)) <div>Color: {{ $item->color_cristal }}</div> @endif
                                                </div>
                                            @endif

                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div style="text-align:right; margin-top:20px; font-size:16px; border-top:2px solid #eee; padding-top:10px;">
                                <p style="margin:5px 0;"><strong>Total Pagado: {{ number_format($order->total_amount, 2) }} €</strong></p>
                            </div>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>