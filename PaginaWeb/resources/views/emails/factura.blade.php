<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura{{ $factura->numero_factura ?? 'N/A' }}</title>
    <style>
        @page { margin: 1.5cm; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; line-height: 1.4; }
        
        /* HEADER y LOGO */
        .header { text-align: center; margin-bottom: 10px; }
        .logo { max-width: 300px; height: auto; display: block; margin: 0 auto; font-size: 24px; font-weight: bold; }

        /* ESTILO PARA LA TABLA DE FECHA/FACTURA */
        .invoice-header-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        .invoice-header-table td {
            padding: 5px 0;
            font-size: 13px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        
        /* INFO EMPRESA Y CLIENTE */
        .info-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin-bottom: 30px; }
        .info-table td { width: 50%; padding: 0; vertical-align: top; }
        .company-info, .client-info { background: #f8f9fa; padding: 12px; border: 1px solid #dee2e6; box-sizing: border-box; font-size: 11px; height: 140px; }
        .company-info p, .client-info p { margin: 2px 0; line-height: 1.2; }
        
        /* TABLA DE PRODUCTOS */
        table.items-table { width: 100%; border-collapse: collapse; margin: 0; border: none; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 6px 4px; text-align: left; vertical-align: top; font-size: 11px; }
        .items-table th { background-color: #2CA1B5; color: white; font-weight: bold; text-align: center; padding: 8px; }
        .description-td { width: 50%; padding-left: 8px; }
        
        /* TOTALES */
        .totals-container { 
            width: 100%; 
            margin-top: 20px; 
        }
        .totals { 
            width: 300px; 
            margin-left: auto; 
            margin-right: 0; 
            font-size: 12px; 
            border: 1px solid #ddd; 
            border-top: none; 
        }
        .summary-row { 
            display: flex; 
            justify-content: space-between;
            padding: 5px 10px; 
            border-top: 1px solid #ddd; 
            line-height: 1.5;
        }
        .summary-row span:first-child { 
            font-weight: normal; 
            text-align: left;
        }
        .summary-row span:last-child { 
            font-weight: bold; 
            text-align: right;
        }
        
        /* Total Factura */
        .grand-total-row { 
            background-color: #2CA1B5; 
            color: white; 
            padding: 10px; 
            margin-top: 0; 
            line-height: 1; 
            border-top: 1px solid #ddd;
            display: flex; 
            justify-content: space-between;
        }
        .grand-total-label, .grand-total-value { 
            font-weight: bold; 
            font-size: 14px; 
        }

        /* DETALLES ESPECÍFICOS DE PRODUCTOS */
        .graduacion, .detalle-cristal { display: block; margin-bottom: 1px; font-size: 10px; line-height: 1.2; }
        .caracteristicas { font-weight: bold; margin: 5px 0 2px 0; font-size: 10px; line-height: 1.2; }
        .precio-base { font-weight: bold; font-size: 12px; margin-bottom: 2px; }
        .suplemento { font-style: italic; color: #666; font-size: 9px; display: block; margin-bottom: 1px; }

        /* FOOTER */
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
        .footer p { margin: 2px 0; }
    </style>
</head>
<body>
    @php
        // --- VARIABLES DE ENVÍO Y DESCUENTO ---
        $envioPrecioBaseConIVA = 5.95;
        $ivaEnvioRate = 0.21;
        $envioPrecioBaseSinIVA = $envioPrecioBaseConIVA / (1 + $ivaEnvioRate);
        $ivaEnvioBase = $envioPrecioBaseConIVA - $envioPrecioBaseSinIVA;

        // CÁLCULO DE TOTALES DE PRODUCTOS
        $factura = $factura ?? (object)['numero_factura' => 'N/A', 'fecha_emision' => \Carbon\Carbon::now()];
        $itemsWithIVA = $itemsWithIVA ?? [];
        
        // RECUPERAR DATOS DE USUARIO REAL
        $user = $factura->user ?? null;

        if ($user) {
            $direccion = trim(($user->calle ?? '') . ' ' . ($user->numero ?? ''));
            if (!empty($user->piso)) {
                $direccion .= ', Piso ' . $user->piso;
            }
            $localidad_cp = trim(($user->ciudad ?? '') . (!empty($user->codigo_postal) ? (' - ' . $user->codigo_postal) : ''));
            
            $userData = [
                'nombre_completo' => trim(($user->name ?? '') . ' ' . ($user->apellidos ?? '')) ?: 'N/A',
                'email' => $user->email ?? 'N/A',
                'direccion' => $direccion ?: 'N/A',
                'localidad_cp' => $localidad_cp ?: 'N/A',
                'nif' => $user->nif ?? 'N/A', 
                'telefono' => $user->telefono ?? 'N/A',
            ];
        } else {
            $userData = [
                'nombre_completo' => 'N/A', 'email' => 'N/A', 'direccion' => 'N/A',
                'localidad_cp' => 'N/A', 'nif' => 'N/A', 'telefono' => 'N/A' 
            ];
        }

        // --- PRECIOS ---
        $preciosTratamientos = [
            'Antirreflejante' => 50.00, 'Filtro Azul' => 80.00, 'Sol' => 40.00, 'Sol Polarizado' => 90.00,
        ];
        $preciosIndices = ['1.5' => 0.00, '1.6' => 30.00, '1.67' => 60.00];
        $preciosColoresSol = [
            'Verde' => 0.00, 'Marrón' => 0.00, 'Gris' => 0.00, 'Degradado Verde' => 20.00, 'Degradado Marrón' => 20.00,
            'Degradado Gris' => 20.00, 'Espejado Verde' => 45.00, 'Espejado Azul' => 45.00, 'Espejado Rojo' => 45.00, 'Espejado Amarillo' => 45.00,
        ];
        
        $orderSubtotalItemsConIVA = collect($itemsWithIVA ?? [])->sum(function ($item) {
            $precioConIVAUnit = $item['precio_unitario'] ?? 0;
            $cant = $item['cantidad'] ?? 1;
            return $precioConIVAUnit * $cant;
        });
        
        $ivaTotalItems = collect($itemsWithIVA ?? [])->sum(function ($item) {
            $precioConIVAUnit = $item['precio_unitario'] ?? 0;
            $ivaRate = $item['iva_rate'] ?? 0.21;
            $precioUnitSinIVA = $ivaRate != -1 ? $precioConIVAUnit / (1 + $ivaRate) : $precioConIVAUnit; 
            $cant = $item['cantidad'] ?? 1;
            return ($precioConIVAUnit - $precioUnitSinIVA) * $cant;
        });
        
        // --- LÓGICA DE DESCUENTO DE ENVÍO ---
        $aplicaDescuentoEnvio = $orderSubtotalItemsConIVA > 50;
        $descuentoEnvioConIVA = $aplicaDescuentoEnvio ? $envioPrecioBaseConIVA : 0.00;
        $descuentoEnvioSinIVA = $aplicaDescuentoEnvio ? $envioPrecioBaseSinIVA : 0.00;
        $ivaDescuentoEnvio = $aplicaDescuentoEnvio ? $ivaEnvioBase : 0.00;

        $shippingConIVA = $envioPrecioBaseConIVA - $descuentoEnvioConIVA;
        $shippingSinIVA = $envioPrecioBaseSinIVA - $descuentoEnvioSinIVA;
        $ivaEnvioFinal = $ivaEnvioBase - $ivaDescuentoEnvio;

        // --- CÁLCULO DE TOTALES FINALES ---
        $subtotalItemsSinIVA = $orderSubtotalItemsConIVA - $ivaTotalItems;
        $totalSinIVA = $subtotalItemsSinIVA + $shippingSinIVA;
        $totalIVA = $ivaTotalItems + $ivaEnvioFinal; 
        $granTotal = $orderSubtotalItemsConIVA + $shippingConIVA; 

    @endphp

    <div class="header">
        @if(isset($logoBase64) && $logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo Óptica" class="logo">
        @else
            <div class="logo">LOGO DE ÓPTICA</div>
        @endif
    </div>

    <table class="invoice-header-table">
        <tr>
            <td style="text-align: left; width: 50%;">
                Factura Simplificada Nº: {{ $factura->numero_factura ?? 'N/A' }}
            </td>
            <td style="text-align: right; width: 50%;">
                Fecha de Emisión: {{ $factura->fecha_emision?->format('d/m/Y') ?? 'N/A' }}
            </td>
        </tr>
    </table>
    
    <table class="info-table">
        <tr>
            <td>
                <div class="company-info">
                    <p><strong>Audiología y Óptica Concha Cuevas</strong></p>
                    <p>Avenida Seminari 4</p>
                    <p>46113 Moncada, Valencia, España</p>
                    <p><strong>NIF:</strong> 73650045C</p>
                    <p><strong>Tel:</strong> 644 100 773</p>
                    <p><strong>Email:</strong> info@conchacuevas.es</p>
                </div>
            </td>
            <td>
                <div class="client-info">
                    <p><strong>Cliente:</strong> {{ $userData['nombre_completo'] ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $userData['email'] ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $userData['telefono'] ?? 'N/A' }}</p> 
                    <p><strong>Dirección:</strong> {{ $userData['direccion'] ?? 'N/A' }}</p>
                    <p>{{ $userData['localidad_cp'] ?? 'N/A' }}</p>
                    <p><strong>NIF:</strong> {{ $userData['nif'] ?? 'N/A' }}</p>
                </div>
            </td>
        </tr>
    </table>
    
    <table class="items-table">
        <thead>
            <tr style="background-color: #007bff;">
                <th style="width: 50%;">Descripción</th>
                <th>Cant.</th>
                <th>Precio Unit. (€)</th> 
                <th>IVA %</th>
                <th>Total (€)</th> 
            </tr>
        </thead>
        <tbody>
            @forelse ($itemsWithIVA ?? [] as $item)
                @php
                    $nombreProducto = ($item['marca'] ?? '') . ' ' . ($item['modelo'] ?? '');
                    $nombreLower = strtolower($nombreProducto);
                    
                    // --- LÓGICA DE DETECCIÓN ---
                    $categoria = strtolower($item['categoria'] ?? '');
                    $esCristalGafa = !empty($item['tipo_cristal']) && empty($item['tipo_lentilla']);
                    $pareceLentillaPorNombre = (str_contains($categoria, 'lentilla') || str_contains($categoria, 'contact') || str_contains($nombreLower, 'lentilla'));
                    $esLentilla = (!empty($item['tipo_lentilla']) || $pareceLentillaPorNombre) && !$esCristalGafa;

                    // --- LÓGICA ESTRICTA DE VISUALIZACIÓN ---
                    $mostrarOD = !is_null($item['od_esfera']);
                    $mostrarOI = !is_null($item['oi_esfera']);
                    
                    // Precios
                    $precioConIVAUnit = $item['precio_unitario'] ?? 0;
                    $ivaRate = $item['iva_rate'] ?? 0.21;
                    $precioUnitSinIVA = $ivaRate != -1 ? $precioConIVAUnit / (1 + $ivaRate) : $precioConIVAUnit;
                    $cant = $item['cantidad'] ?? 1;
                    $subtotalConIVA = $precioConIVAUnit * $cant; 
                    
                    // Suplementos
                    $mostrarSuplementos = !$esLentilla && !$esCristalGafa && (!empty($item['tipo_cristal']) || !empty($item['indice_lente']));
                    $suplementoTipoCristal = $mostrarSuplementos ? ($preciosTratamientos[$item['tipo_cristal'] ?? ''] ?? 0) : 0;
                    $suplementoIndiceLente = $mostrarSuplementos ? ($preciosIndices[$item['indice_lente'] ?? ''] ?? 0) : 0;
                    $suplementoColorCristal = $mostrarSuplementos ? ($preciosColoresSol[$item['color_cristal'] ?? ''] ?? 0) : 0;
                    $supTotal = $suplementoTipoCristal + $suplementoIndiceLente + $suplementoColorCristal;
                @endphp
                <tr>
                    <td class="description-td">
                        <div class="precio-base">{{ $esCristalGafa ? 'Lentes Graduadas' : ($nombreProducto ?: 'Producto') }}</div>
                        
                        {{-- CASO 1: LENTILLAS (Lógica Estricta) --}}
                        @if($esLentilla)
                            @if($mostrarOD || $mostrarOI)
                                <div class="caracteristicas">DATOS DE GRADUACIÓN:</div>
                                
                                {{-- Lógica para OD --}}
                                @php
                                    $od_parts = [];
                                    if ($mostrarOD) {
                                        // Mostrar SIEMPRE la esfera si existe (aunque sea 0.00)
                                        $od_parts[] = "Esfera " . $item['od_esfera'];
                                        
                                        // Cilindro solo si tiene valor
                                        if (!empty($item['od_cilindro']) && $item['od_cilindro'] !== '0.00') {
                                            $od_parts[] = "Cil. " . $item['od_cilindro'];
                                            // Eje solo si hay cilindro
                                            if (isset($item['od_eje']) && $item['od_eje'] !== '') {
                                                $od_parts[] = "Eje " . $item['od_eje'];
                                            }
                                        }
                                        // Adición
                                        if (!empty($item['adicion']) && $item['adicion'] !== '0.00') {
                                            $od_parts[] = "Adición " . $item['adicion'];
                                        }
                                    }
                                @endphp
                                @if(count($od_parts) > 0)
                                    <div class="graduacion"><strong>OD:</strong> {{ implode(', ', $od_parts) }}</div>
                                    @if(isset($item['ojo_dominante']) && $item['ojo_dominante'] === 'Derecho')
                                        <div class="graduacion"><strong>Ojo Dominante:</strong> Derecho</div>
                                    @endif
                                @endif

                                {{-- Lógica para OI --}}
                                @php
                                    $oi_parts = [];
                                    if ($mostrarOI) {
                                        // Mostrar SIEMPRE la esfera si existe
                                        $oi_parts[] = "Esfera " . $item['oi_esfera'];
                                        
                                        // Cilindro solo si tiene valor
                                        if (!empty($item['oi_cilindro']) && $item['oi_cilindro'] !== '0.00') {
                                            $oi_parts[] = "Cil. " . $item['oi_cilindro'];
                                            // Eje solo si hay cilindro
                                            if (isset($item['oi_eje']) && $item['oi_eje'] !== '') {
                                                $oi_parts[] = "Eje " . $item['oi_eje'];
                                            }
                                        }
                                        // Adición
                                        if (!empty($item['adicion']) && $item['adicion'] !== '0.00') {
                                            $oi_parts[] = "Adición " . $item['adicion'];
                                        }
                                    }
                                @endphp
                                @if(count($oi_parts) > 0)
                                    <div class="graduacion"><strong>OI:</strong> {{ implode(', ', $oi_parts) }}</div>
                                    @if(isset($item['ojo_dominante']) && $item['ojo_dominante'] === 'Izquierdo')
                                        <div class="graduacion"><strong>Ojo Dominante:</strong> Izquierdo</div>
                                    @endif
                                @endif
                            @endif

                            @if(!empty($item['color_lentilla']))
                                <div class="graduacion"><strong>Color:</strong> {{ $item['color_lentilla'] }}</div>
                            @endif

                        {{-- CASO 2: CRISTALES GAFA --}}
                        @elseif($esCristalGafa)
                            <div class="caracteristicas">DATOS DE GRADUACIÓN:</div>
                            
                            {{-- Lógica para OD (Gafas) --}}
                            @php
                                $od_gafas = [];
                                // Mostrar SIEMPRE la esfera (0.00 o valor)
                                $od_gafas[] = "Esfera " . ($item['od_esfera'] ?? '0.00');
                                
                                if (!empty($item['od_cilindro']) && $item['od_cilindro'] !== '0.00') {
                                    $od_gafas[] = "Cil. " . $item['od_cilindro'];
                                    // Eje solo si hay cilindro
                                    if (isset($item['od_eje']) && $item['od_eje'] !== '') {
                                        $od_gafas[] = "Eje " . $item['od_eje'];
                                    }
                                }
                            @endphp
                            @if(count($od_gafas) > 0)
                                <div class="graduacion"><strong>OD:</strong> {{ implode(', ', $od_gafas) }}</div>
                            @endif

                            {{-- Lógica para OI (Gafas) --}}
                            @php
                                $oi_gafas = [];
                                // Mostrar SIEMPRE la esfera
                                $oi_gafas[] = "Esfera " . ($item['oi_esfera'] ?? '0.00');
                                
                                if (!empty($item['oi_cilindro']) && $item['oi_cilindro'] !== '0.00') {
                                    $oi_gafas[] = "Cil. " . $item['oi_cilindro'];
                                    // Eje solo si hay cilindro
                                    if (isset($item['oi_eje']) && $item['oi_eje'] !== '') {
                                        $oi_gafas[] = "Eje " . $item['oi_eje'];
                                    }
                                }
                            @endphp
                            @if(count($oi_gafas) > 0)
                                <div class="graduacion"><strong>OI:</strong> {{ implode(', ', $oi_gafas) }}</div>
                            @endif
                            
                            <div class="caracteristicas">CARACTERÍSTICAS DEL CRISTAL:</div>
                            @if(!empty($item['tipo_cristal'])) <div class="detalle-cristal"><strong>Tratamiento:</strong> {{ $item['tipo_cristal'] }}</div> @endif
                            @if(!empty($item['indice_lente'])) <div class="detalle-cristal"><strong>Índice:</strong> {{ $item['indice_lente'] }}</div> @endif
                            @if(!empty($item['color_cristal'])) <div class="detalle-cristal"><strong>Color:</strong> {{ $item['color_cristal'] }}</div> @endif
                        @endif

                        {{-- SUPLEMENTOS (Si aplica) --}}
                        @if($mostrarSuplementos && $supTotal > 0)
                            <div class="suplemento">Suplementos:</div>
                            @if($suplementoIndiceLente > 0) <div class="suplemento">• Índice {{ $item['indice_lente'] }}: +{{ number_format($suplementoIndiceLente, 2) }} €</div> @endif
                            @if($suplementoTipoCristal > 0) <div class="suplemento">• Tipo {{ $item['tipo_cristal'] }}: +{{ number_format($suplementoTipoCristal, 2) }} €</div> @endif
                            @if($suplementoColorCristal > 0) <div class="suplemento">• Color {{ $item['color_cristal'] }}: +{{ number_format($suplementoColorCristal, 2) }} €</div> @endif
                            <div class="suplemento"><strong>Total Sup: {{ number_format($supTotal, 2) }} €</strong></div>
                        @endif
                    </td>
                    <td style="text-align: center; vertical-align: middle;">{{ $cant }} @if($esCristalGafa) (par) @endif</td>
                    <td style="text-align: right; vertical-align: middle;">{{ number_format($precioUnitSinIVA, 2) }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ number_format($ivaRate * 100, 0) }}%</td>
                    <td style="text-align: right; vertical-align: middle;">{{ number_format($subtotalConIVA, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">No hay ítems en esta factura.</td>
                </tr>
            @endforelse
            
            <tr>
                <td>Envío Estándar</td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right;">{{ number_format($envioPrecioBaseSinIVA, 2) }}</td>
                <td style="text-align: center;">{{ number_format($ivaEnvioRate * 100, 0) }}%</td>
                <td style="text-align: right;">{{ number_format($envioPrecioBaseConIVA, 2) }}</td>
            </tr>

            @if($aplicaDescuentoEnvio)
            <tr style="background-color: #e6ffed;">
                <td style="color: #28a745; font-weight: bold;">Descuento Envío (Pedido >50€)</td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right; color: #28a745; font-weight: bold;">-{{ number_format($descuentoEnvioSinIVA, 2) }}</td>
                <td style="text-align: center;">{{ number_format($ivaEnvioRate * 100, 0) }}%</td>
                <td style="text-align: right; color: #28a745; font-weight: bold;">-{{ number_format($descuentoEnvioConIVA, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="totals-container">
        <div class="totals">         
            <div class="summary-row">
                <span>Gastos de Envío:</span>
                <span>{{ $aplicaDescuentoEnvio ? 'Gratis' : number_format($shippingConIVA, 2) . ' €' }}</span>
            </div>

            <div class="summary-row">
                <span>Subtotal sin IVA:</span>
                <span>{{ number_format($totalSinIVA, 2) }} €</span>
            </div>
            
            <div class="summary-row">
                <span>Total IVA:</span>
                <span>{{ number_format($totalIVA, 2) }} €</span>
            </div>
            
            <div class="grand-total-row">
                <div class="grand-total-label">TOTAL A PAGAR: {{ number_format($granTotal, 2) }} €</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Factura Simplificada - no válida como factura de IVA</p>
        <p>Óptica y Audiología Concha Cuevas | Avenida Seminari 4, 46113 Moncada, Valencia</p>
        <p>Gracias por su confianza.</p>
    </div>
</body>
</html>