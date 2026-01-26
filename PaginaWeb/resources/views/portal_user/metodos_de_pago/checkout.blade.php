@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Finalizar Pago - Pedido #{{ $order->id }}</h2>

    @if (session('success'))
        <div class="alert alert-success alert-fixed">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-fixed">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Total:</strong> {{ number_format($order->total_amount, 2) }} €</p>
            <p><strong>Fecha:</strong> {{ $order->order_date->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <h4 class="mb-3">Seleccionar Método de Pago</h4>
    @if ($paymentMethods->isEmpty())
        <p>No tienes métodos de pago registrados. Añade uno nuevo.</p>
    @else
        <form action="{{ route('user.payment.process', $order->id) }}" method="POST">
            @csrf
            <div class="row">
                @foreach ($paymentMethods as $method)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $method->card_type }} (**** {{ $method->last_four_digits }})</h5>
                                <p class="card-text">
                                    <strong>Titular:</strong> {{ $method->card_holder }}<br>
                                    <strong>Fecha de vencimiento:</strong> {{ $method->expiry_date }}
                                </p>
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}" required>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-3">Pagar ahora</button>
        </form>
    @endif

    <div class="mt-4">
        <a href="{{ route('user.payment.add.form') }}" class="btn btn-secondary">+ Añadir nuevo método de pago</a>
        <a href="{{ route('user.orders') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
@endsection