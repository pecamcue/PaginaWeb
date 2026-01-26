@extends('layouts.app')

@section('title', 'Panel de Administración - Pedidos')

@section('content')
<div class="container-fluid py-4">
    <!-- Solo título -->
    <h2 class="mb-4">Gestión de Pedidos</h2>

    <!-- Filtros (ANCHO COMPLETO, ahora con buscador también) -->
    <div class="container-fluid px-0 mb-4">
        <div class="card shadow-sm w-100">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-filter me-2"></i>Filtros
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                    <!-- Buscar por número o cliente -->
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control" placeholder="Buscar por número de pedido o cliente">
                    </div>
                    <!-- Filtro estado -->
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Estado del pedido</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Filtro pago -->
                    <div class="col-md-3">
                        <select name="payment_status" class="form-select">
                            <option value="">Estado del pago</option>
                            @foreach($paymentStatuses as $status)
                                <option value="{{ $status }}" {{ request('payment_status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Botón filtrar -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                    <!-- Botón limpiar -->
                    <div class="col-md-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla pedidos (ANCHO COMPLETO) -->
    <div class="container-fluid px-0">
        <div class="card shadow-sm w-100">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-list me-2"></i>Lista de Pedidos
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Pago</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>
                                    <div>{{ $order->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $order->order_date->format('d/m/Y H:i') }}</td>
                                <td><strong class="text-primary">{{ number_format($order->total_amount, 2) }} €</strong></td>
                                <td><span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span></td>
                                <td><span class="badge {{ $order->payment_status_badge_class }}">{{ $order->payment_status_label }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$order->is_completed && !$order->is_cancelled)
                                        <button class="btn btn-sm btn-outline-success change-status-btn" 
                                                data-order-id="{{ $order->id }}" data-status="enviado">
                                            <i class="fas fa-truck"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <div>No se encontraron pedidos</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
