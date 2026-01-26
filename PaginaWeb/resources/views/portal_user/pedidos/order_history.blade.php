@extends('layouts.app')

@section('content')
<style>
    /* Ajustes responsive para pantallas menores a 768px */
    @media (max-width: 768px) {
        .container {
            padding: 0 10px;
        }

        h2 {
            font-size: 1.5rem;
        }

        /* Apilar filas de la tabla como tarjetas */
        .table {
            display: block;
            border: none;
        }

        .table thead {
            display: none; /* Ocultar encabezados en móvil */
        }

        .table tbody {
            display: block;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .table td {
            display: block;
            text-align: left;
            padding: 8px 10px;
            font-size: 0.9rem;
            border-bottom: 1px solid #eee;
        }

        .table td:last-child {
            border-bottom: none;
        }

        /* Añadir etiquetas a los datos de la tabla */
        .table td:before {
            content: attr(data-label);
            font-weight: bold;
            color: #2CA1B5;
            margin-right: 10px;
            font-size: 0.85rem;
        }

        .table td[data-label="Nº Pedido"] {
            font-weight: bold;
            font-size: 1rem;
        }

        /* Ajustar botones */
        .btn-primary,
        .btn-outline-primary {
            font-size: 0.85rem;
            padding: 6px 12px;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-primary + .btn-outline-primary {
            margin-left: 0;
        }

        /* Ajustar contenedor de mensaje sin pedidos */
        .text-center.py-5 {
            padding: 20px;
            font-size: 1rem;
        }
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">Historial de <span class="text-primary">Pedidos</span></h2>

    <div class="mb-4">
        <a href="http://localhost:4200/inicio" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
            <i class="fas fa-shopping-cart me-2"></i>Realizar Nuevo Pedido
        </a>
    </div>

    @if ($orders->isEmpty())
        <div class="text-center py-5 bg-light rounded-3">
            <p class="text-muted fs-5">No tienes pedidos registrados.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover rounded-3 overflow-hidden shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Nº Pedido</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Pago</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="align-middle">
                            <td class="text-center" data-label="Nº Pedido">{{ $order->id }}</td>
                            <td class="text-center" data-label="Fecha">{{ $order->order_date->format('d/m/Y H:i') }}</td>
                            <td class="text-center" data-label="Estado">
                                <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="text-center" data-label="Pago">
                                <span class="badge {{ $order->payment_status_badge_class }}">{{ $order->payment_status_label }}</span>
                            </td>
                            <td class="text-center text-dark fw-bold" data-label="Total">{{ number_format($order->total_amount, 2) }} €</td>
                            <td class="text-center" data-label="Acciones">
                                <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-primary me-2 rounded-pill">
                                    <i class="fas fa-eye me-1"></i> Ver detalles
                                </a>
                                <a href="{{ route('user.orders.downloadInvoice', $order->id) }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="fas fa-download me-1"></i> Factura
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection