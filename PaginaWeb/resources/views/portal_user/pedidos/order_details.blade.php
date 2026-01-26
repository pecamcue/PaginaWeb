@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #2CA1B5;
        --primary-hover: #228a9b;
        --secondary-hover: #0e7a84;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-modern th, .table-modern td {
        border: none;
        padding: 15px;
        background-color: #f8f9fa;
        vertical-align: middle;
    }

    .table-modern thead th {
        background-color: var(--primary-color);
        color: white;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 1px;
    }

    .table-modern tbody tr {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-radius: 8px;
    }

    .graduacion-list {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.875rem;
    }

    .suplemento {
        color: #6c757d;
        font-style: italic;
    }

    .envio-gratis {
        color: green;
        font-weight: bold;
    }

    .envio-pago {
        color: red;
        font-weight: bold;
    }

    .total-final {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .no-suplementos {
        border-top: 1px dashed #ccc;
        padding-top: 5px;
        color: #999;
    }

    .btn-outline-custom-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background-color: #ffffff;
    }

    .btn-outline-custom-primary:hover {
        color: #ffffff;
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
    }

    .btn-custom-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #ffffff;
    }

    .btn-custom-primary:hover {
        background-color: #ffffff;
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .container {
            padding: 0 10px;
        }

        h2 {
            font-size: 1.5rem;
        }

        h4 {
            font-size: 1.25rem;
        }

        .table-modern {
            border-spacing: 0;
            display: block;
        }

        .table-modern thead {
            display: none;
        }

        .table-modern tbody {
            display: block;
        }

        .table-modern tbody tr {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table-modern td {
            display: block;
            text-align: left;
            padding: 8px 10px;
            font-size: 0.9rem;
            border-bottom: 1px solid #eee;
        }

        .table-modern td:last-child {
            border-bottom: none;
        }

        .table-modern td:before {
            content: attr(data-label);
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 0.85rem;
        }

        .table-modern td[data-label="Producto"] {
            font-weight: bold;
            font-size: 1rem;
        }

        .graduacion-list {
            font-size: 0.8rem;
        }

        .summary-section {
            font-size: 0.9rem;
        }

        .total-final {
            font-size: 1.1rem;
        }

        .btn-outline-custom-primary,
        .btn-custom-primary {
            font-size: 0.9rem;
            padding: 8px 12px;
            width: 100%;
            margin-bottom: 10px;
        }

        .card-body .row {
            flex-direction: column;
            text-align: left;
        }

        .card-body .col-md-6 {
            width: 100%;
            text-align: left;
        }

        .card-body .text-md-end {
            text-align: left;
        }

        .card-header .btn {
            font-size: 0.85rem;
            padding: 6px 12px;
        }
    }
</style>

<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4 text-primary">Detalles del Pedido #{{ $order->id }}</h2>

    <div class="card shadow-sm rounded-3 mb-4" style="min-height: 150px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Información General</span>
            <a href="{{ route('user.orders') }}" class="btn btn-light btn-sm rounded-pill">Volver</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Fecha:</strong> <span class="text-muted">{{ $order->order_date->format('d/m/Y H:i') }}</span></p>
                    
                    <p class="mb-2"><strong>Estado del Pedido:</strong>
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </p>
                    
                    <p class="mb-2"><strong>Estado del Pago:</strong>
                        <span class="badge {{ $order->payment_status_badge_class }}">{{ $order->payment_status_label }}</span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0"><strong>Total:</strong> <span class="text-dark fw-bold">{{ number_format($order->total_amount, 2) }} €</span></p>
                    @if($order->shipping_method)
                        <p class="mb-0 text-muted"><small><strong>Método de Envío:</strong> {{ $order->shipping_method }}</small></p>
                    @endif
                    @if($order->payment_method)
                        <p class="mb-0 text-muted"><small><strong>Pago:</strong> {{ ucfirst($order->payment_method) }}</small></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3 text-primary">Productos</h4>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Base</th>
                    <th>Suplementos</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    @php
                        // Obtener precios de configuración (temporal hasta implementar BBDD)
                        $preciosTratamientos = [
                            'Antirreflejante' => 50.00,
                            'Filtro Azul' => 80.00,
                            'Sol' => 40.00,
                            'Sol Polarizado' => 90.00,
                        ];
                        $preciosIndices = [
                            '1.5' => 0.00,
                            '1.6' => 30.00,
                            '1.67' => 60.00,
                        ];
                        $preciosColoresSol = [
                            'Verde' => 0.00,
                            'Marrón' => 0.00,
                            'Gris' => 0.00,
                            'Degradado Verde' => 20.00,
                            'Degradado Marrón' => 20.00,
                            'Degradado Gris' => 20.00,
                            'Espejado Verde' => 45.00,
                            'Espejado Azul' => 45.00,
                            'Espejado Rojo' => 45.00,
                            'Espejado Amarillo' => 45.00,
                        ];

                        // Calcular suplementos
                        $suplementoTipoCristal = $preciosTratamientos[$item->tipo_cristal] ?? 0;
                        $suplementoIndiceLente = $preciosIndices[$item->indice_lente] ?? 0;
                        $suplementoColorCristal = $preciosColoresSol[$item->color_cristal] ?? 0;
                        $supplementTotal = $suplementoTipoCristal + $suplementoIndiceLente + $suplementoColorCristal;

                        // Precio base = precio_unitario - suplementos
                        $basePrice = $item->precio_unitario - $supplementTotal;
                        $basePrice = max($basePrice, 0);
                        $subtotal = $item->precio_unitario * $item->cantidad;

                        // --- INICIO DE LA MODIFICACIÓN (Lógica para renombrar Lentes Graduadas) ---
                        $displayName = $item->product->marca . ' ' . $item->product->modelo;
                        
                        // Condición para determinar si este item es el componente de Lentes
                        $isLentesComponent = 
                            !empty($item->tipo_cristal) || 
                            !empty($item->indice_lente) || 
                            !empty($item->color_cristal);
                        
                        // Asumiendo que existe la relación producto->categoría
                        $productCategory = strtolower($item->product->categoria->nombre ?? '');
                        $isGafaCategory = str_contains($productCategory, 'gafas');

                        if ($isLentesComponent && $isGafaCategory) {
                            // Si es el componente de lentes de unas gafas, renombramos
                            $displayName = 'Lentes Graduadas para ' . $item->product->modelo;
                        }
                        // --- FIN DE LA MODIFICACIÓN ---

                    @endphp
                    <tr>
                        <td data-label="Producto">{{ $displayName }}</td>
                        <td data-label="Cantidad">{{ $item->cantidad }}</td>
                        <td data-label="Precio Base">{{ number_format($basePrice, 2) }} €</td>
                        <td data-label="Suplementos">
                            @if ($supplementTotal > 0)
                                <ul class="graduacion-list">
                                    @if ($item->tipo_cristal && $suplementoTipoCristal > 0)
                                        <li class="suplemento"><strong>Tipo Cristal:</strong> {{ $item->tipo_cristal }} (+ {{ number_format($suplementoTipoCristal, 2) }} €)</li>
                                    @endif
                                    @if ($item->indice_lente && $suplementoIndiceLente > 0)
                                        <li class="suplemento"><strong>Índice Lente:</strong> {{ $item->indice_lente }} (+ {{ number_format($suplementoIndiceLente, 2) }} €)</li>
                                    @endif
                                    @if ($item->color_cristal && $suplementoColorCristal > 0)
                                        <li class="suplemento"><strong>Color Cristal:</strong> {{ $item->color_cristal }} (+ {{ number_format($suplementoColorCristal, 2) }} €)</li>
                                    @endif
                                </ul>
                            @else
                                <div class="no-suplementos">-----</div>
                            @endif
                        </td>
                        <td data-label="Subtotal">{{ number_format($subtotal, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary-section mt-4 p-3 bg-light rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span><strong>Subtotal:</strong></span>
            <span>{{ number_format($order->subtotal, 2) }} €</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span><strong>Envío:</strong></span>
            @if($order->shipping_cost > 0)
                <span class="envio-pago">{{ number_format($order->shipping_cost, 2) }} €</span>
            @else
                <span class="envio-gratis">Gratis</span>
            @endif
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <span><strong>Total Final:</strong></span>
            <span class="total-final">{{ number_format($order->total_amount, 2) }} €</span>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('user.orders.downloadInvoice', $order->id) }}" class="btn btn-outline-custom-primary rounded-pill me-3">
            <i class="fas fa-download me-1"></i> Descargar Factura
        </a>
        <a href="{{ route('user.orders') }}" class="btn btn-custom-primary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>
@endsection