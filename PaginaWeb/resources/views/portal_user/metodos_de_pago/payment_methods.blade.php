@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Formas de <span class="text-primary">Pago</span></h2>

    <div class="mb-4">
        <a href="{{ route('user.payment-methods.add.form') }}" class="btn btn-primary">Añadir forma de pago</a>
    </div>

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

    @if ($paymentMethods->isEmpty())

        <p class="text-center text-muted">No tienes métodos de pago registrados.</p>
    
    @else
        <div class="row">
            @foreach ($paymentMethods as $method)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $method->card_type }} (**** {{ $method->last_four_digits }})</h5>
                            <p class="card-text">
                                <strong>Titular:</strong> {{ $method->card_holder }}<br>
                                <strong>Fecha de vencimiento:</strong> {{ $method->expiry_date }}<br>
                                <strong>Registrada:</strong> {{ $method->created_at->format('d/m/Y') }}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.payment-methods.edit', $method->id) }}" class="btn btn-warning btn-sm">Modificar</a>
                                <form action="{{ route('user.payment-methods.delete', $method->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta forma de pago?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 