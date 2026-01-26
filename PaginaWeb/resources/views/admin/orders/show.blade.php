@extends('layouts.app')

@section('title', 'Detalles del Pedido - Admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Fila 1: información y acciones --}}
    <div class="row mb-4">
        {{-- Columna izquierda --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-info-circle me-2"></i> Información del Pedido
                </div>
                <div class="card-body">
                    {{-- Cliente --}}
                    <h6 class="fw-bold mb-2">Cliente</h6>
                    <p class="mb-1"><strong>{{ $order->user->name ?? 'N/A' }}</strong></p>
                    <p class="text-muted small">{{ $order->user->email ?? 'N/A' }}</p>

                    <hr>

                    {{-- Resumen financiero --}}
                    <h6 class="fw-bold mb-2">Resumen Financiero</h6>
                    <ul class="list-unstyled mb-3">
                        <li class="d-flex justify-content-between py-1">
                            <span>Subtotal:</span>
                            <span>{{ number_format($order->subtotal, 2) }} €</span>
                        </li>
                        <li class="d-flex justify-content-between py-1">
                            <span>Envío:</span>
                            <span>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2).' €' : 'Gratis' }}</span>
                        </li>
                        <li class="border-top mt-2 pt-2 d-flex justify-content-between fw-bold text-primary fs-5">
                            <span>Total:</span>
                            <span>{{ number_format($order->total_amount, 2) }} €</span>
                        </li>
                    </ul>

                    {{-- Estado --}}
                    <h6 class="fw-bold mb-2">Estado</h6>
                    <p class="mb-1">
                        <strong>Pedido:</strong>
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </p>
                    <p class="mb-0">
                        <strong>Pago:</strong>
                        <span class="badge {{ $order->payment_status_badge_class }}">{{ $order->payment_status_label }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Columna derecha --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-cogs me-2"></i> Acciones
                </div>
                <div class="card-body">
                    {{-- Cambiar estado del pedido --}}
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-3">
                        @csrf @method('PATCH')
                        <label class="fw-bold small mb-1">Estado del Pedido</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="pendiente" {{ $order->status==='pendiente'?'selected':'' }}>Pendiente</option>
                            <option value="enviado" {{ $order->status==='enviado'?'selected':'' }}>Enviado</option>
                            <option value="completado" {{ $order->status==='completado'?'selected':'' }}>Completado</option>
                            <option value="cancelado" {{ $order->status==='cancelado'?'selected':'' }}>Cancelado</option>
                        </select>
                    </form>

                    {{-- Cambiar estado del pago --}}
                    <form method="POST" action="{{ route('admin.orders.update-payment-status', $order) }}" class="mb-3">
                        @csrf @method('PATCH')
                        <label class="fw-bold small mb-1">Estado del Pago</label>
                        <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="pendiente" {{ $order->payment_status==='pendiente'?'selected':'' }}>Pendiente</option>
                            <option value="pagado" {{ $order->payment_status==='pagado'?'selected':'' }}>Pagado</option>
                            <option value="reembolsado" {{ $order->payment_status==='reembolsado'?'selected':'' }}>Reembolsado</option>
                        </select>
                    </form>

                    {{-- Cancelar pedido (SweetAlert) --}}
                    <form id="cancel-form-{{ $order->id }}" method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                        @csrf
                    </form>
                    @if(!$order->is_cancelled)
                        <button class="btn btn-danger w-100 mb-2" onclick="confirmCancel({{ $order->id }})">
                            <i class="fas fa-times me-1"></i> Cancelar Pedido
                        </button>
                    @endif

                    {{-- Descargar factura --}}
                    <a href="{{ route('user.orders.downloadInvoice', $order) }}" target="_blank"
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-download me-1"></i> Descargar Factura
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Fila 2: tabla de productos (ANCHO COMPLETO) --}}
    <div class="container-fluid px-0">
        <div class="card shadow-sm w-100">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-shopping-cart me-2"></i> Productos ({{ $order->orderItems->count() }})
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio Unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->marca ?? 'N/A' }} {{ $item->product->modelo ?? '' }}</strong>
                                    @if($item->tipo_cristal || $item->indice_lente || $item->color_cristal)
                                        <br>
                                        <small class="text-muted">
                                            {{ $item->tipo_cristal ?? '' }}
                                            {{ $item->indice_lente ? '| '.$item->indice_lente : '' }}
                                            {{ $item->color_cristal ? '| '.$item->color_cristal : '' }}
                                        </small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->cantidad }}</td>
                                <td class="text-center">{{ number_format($item->precio_unitario, 2) }} €</td>
                                <td class="text-end fw-bold">{{ number_format($item->precio_unitario * $item->cantidad, 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function confirmCancel(orderId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esto cancelará el pedido y reembolsará el pago.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('cancel-form-' + orderId).submit();
        }
    });
}
</script>
@endpush
@endsection
