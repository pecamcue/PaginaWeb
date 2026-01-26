@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Añadir Forma de <span class="text-primary">Pago</span></h2>

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

    <form action="{{ route('user.payment-methods.add') }}" method="POST" id="payment-form">
        @csrf
        <div class="mb-3">
            <label for="card_type" class="form-label">Tipo de tarjeta</label>
            <select name="card_type" id="card_type" class="form-select" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="American Express">American Express</option>
            </select>
            @error('card_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="card_number" class="form-label">Número de tarjeta</label>
            <input type="text" name="card_number" id="card_number" class="form-control" required maxlength="19" placeholder="1234 5678 9012 3456" autocomplete="off">
            @error('card_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="card_holder" class="form-label">Titular de la tarjeta</label>
            <input type="text" name="card_holder" id="card_holder" class="form-control" required autocomplete="off">
            @error('card_holder')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Fecha de vencimiento (MM/AA)</label>
            <input type="text" name="expiry_date" id="expiry_date" class="form-control" required placeholder="MM/YY" maxlength="5" autocomplete="off">
            @error('expiry_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control" required maxlength="4" autocomplete="off">
            @error('cvv')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('user.payment-methods') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

@push('scripts')
<script>
    // Formatear número de tarjeta (grupos de 4 dígitos)
    const cardNumberInput = document.getElementById('card_number');
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formatted = '';
        for (let i = 0; i < value.length; i += 4) {
            formatted += (formatted ? ' ' : '') + value.slice(i, i + 4);
        }
        e.target.value = formatted.trim();
    });

    // Formatear fecha de vencimiento (MM/YY)
    const expiryDateInput = document.getElementById('expiry_date');
    expiryDateInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            e.target.value = value.slice(0, 2) + '/' + value.slice(2, 4);
        } else {
            e.target.value = value;
        }
    });
</script>
@endpush
@endsection 