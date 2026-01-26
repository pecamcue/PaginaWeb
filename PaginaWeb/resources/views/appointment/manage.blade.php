@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestión de tu Cita</h1>

    <p><strong>Servicio:</strong> {{ $appointment->service_type }}</p>
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
    <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</p>
    <p><strong>Dirección:</strong> Av. Seminari 4, Moncada - Valencia</p>

    <!-- Botones para cancelar o modificar -->
    @if ($appointment->status !== 'cancelada')
        <form action="{{ route('appointment.confirm_cancel', $appointment->id) }}" method="GET" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Cancelar Cita</button>
        </form>
        
        <a href="{{ route('appointment.edit', $appointment->id) }}" class="btn btn-primary mt-3">Modificar Cita</a>
    @endif
</div>
@endsection
