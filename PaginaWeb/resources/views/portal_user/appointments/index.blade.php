@extends('layouts.app')

@section('content')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .swal2-custom {
        background-color: #ffffff !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb !important;
        border-radius: 8px !important;
        max-width: 300px !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
    }
    .swal2-custom-error {
        background-color: #ffffff !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb !important;
        border-radius: 8px !important;
        max-width: 300px !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
    }

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
            border-bottom: 1px solid #dee2e6; /* Línea de separación */
            border-radius: 10px; /* Bordes redondeados en móvil */
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
            color: #2CA1B5; /* Coincide con text-primary */
            margin-right: 10px;
            font-size: 0.85rem;
        }

        .table td[data-label="Fecha"] {
            font-weight: bold;
            font-size: 1rem;
        }

        /* Ajustar botones */
        .btn-primary,
        .btn-danger {
            font-size: 0.85rem;
            padding: 6px 12px;
            width: 100%;
            margin-bottom: 10px;
            margin-right: 0;
        }

        /* Ajustar contenedor de mensaje sin citas */
        .text-center.fs-5 {
            font-size: 1rem;
            padding: 20px;
        }

        /* Ajustar SweetAlert2 para pantallas pequeñas */
        .swal2-custom,
        .swal2-custom-error {
            max-width: 90% !important;
            font-size: 0.9rem;
        }

        .swal2-title {
            font-size: 1.2rem !important;
        }

        .swal2-content {
            font-size: 0.9rem !important;
        }

        .swal2-confirm,
        .swal2-cancel {
            font-size: 0.85rem !important;
            padding: 8px 12px !important;
        }
    }
</style>

<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Mis <span class="text-primary">Citas</span></h2>

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                    Swal.fire({
                        title: 'Éxito',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-custom'
                        }
                    });
                @endif
                @if (session('error'))
                    Swal.fire({
                        title: 'Error',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-custom-error'
                        }
                    });
                @endif
            });
        </script>
    @endif

    <div class="mb-4 text-start">
        <a href="{{ route('user.appointment.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i>Crear Nueva Cita
        </a>
    </div>

    @if ($appointments->isEmpty())
        <div class="text-center py-5 bg-light rounded-3">
            <p class="text-muted fs-5">No tienes citas programadas.</p>
        </div>
    @else
        <div class="table-responsive">
            <!-- Quitamos border-primary y table-bordered -->
            <table class="table table-hover rounded-3 overflow-hidden shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Hora</th>
                        <th class="text-center">Servicio</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr class="align-middle" data-appointment-id="{{ $appointment->id }}">
                            <td class="text-center" data-label="Fecha">{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                            <td class="text-center" data-label="Hora">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                            <td class="text-center" data-label="Servicio">
                                @switch($appointment->service_type)
                                    @case('Examen_Visual') Revisión optométrica @break
                                    @case('Examen_Audiologico') Revisión audiológica @break
                                    @case('Revision_Lentillas') Revisión lentillas @break
                                    @default Desconocido
                                @endswitch
                            </td>
                            <td class="text-center" data-label="Estado">
                                @if ($appointment->status === 'completed')
                                    <span class="badge bg-success">Completado</span>
                                @elseif ($appointment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif ($appointment->status === 'cancelada')
                                    <span class="badge bg-danger">Cancelado</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center" data-label="Acciones">
                                @if ($appointment->status !== 'cancelada')
                                    <a href="{{ route('user.appointment.edit', $appointment->id) }}" class="btn btn-primary me-2 rounded-pill">
                                        <i class="fas fa-edit"></i> Modificar
                                    </a>
                                    <button class="btn btn-danger rounded-pill delete-appointment" data-id="{{ $appointment->id }}">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-appointment').forEach(button => {
                button.addEventListener('click', function () {
                    const appointmentId = this.getAttribute('data-id');
                    Swal.fire({
                        title: '¿Eliminar cita?',
                        text: '¿Estás seguro de que quieres eliminar esta cita?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2CA1B5',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí',
                        cancelButtonText: 'No',
                        customClass: {
                            popup: 'swal2-custom'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('mi-cuenta/citas') }}/${appointmentId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.querySelector(`tr[data-appointment-id="${appointmentId}"]`).remove();
                                    Swal.fire({
                                        title: 'Éxito',
                                        text: data.message || 'La cita ha sido eliminada correctamente.',
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'swal2-custom'
                                        }
                                    }).then(() => {
                                        window.location.href = data.redirect;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: data.error || 'Error al eliminar la cita.',
                                        icon: 'error',
                                        timer: 3000,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'swal2-custom-error'
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Error al procesar: ' + error.message,
                                    icon: 'error',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal2-custom-error'
                                    }
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>
@endpush
@endsection