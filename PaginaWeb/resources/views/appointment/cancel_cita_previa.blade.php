@extends('layouts.app')

@section('content')
<style>
    .confirmation-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    #status-message {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        display: none;
        font-size: 16px;
        font-weight: bold;
        width: 300px;
        background-color: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
    }
    #status-message.show {
        display: block;
    }
    #status-message.alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center"><i data-lucide="alert-triangle" class="me-2"></i>Confirmar Eliminación</h2>

    <div id="status-message" class="alert" role="alert">
        <span id="message-text"></span>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="confirmation-card">
                <p class="text-center"><strong>¿Estás seguro de que deseas eliminar esta cita?</strong></p>

                <div class="mt-4">
                    <h5>Detalles de la cita:</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Servicio:</strong>
                            @switch($appointment->service_type)
                                @case('Examen_Visual')
                                    Revisión optométrica
                                    @break
                                @case('Examen_Audiologico')
                                    Revisión audiológica
                                    @break
                                @case('Revision_Lentillas')
                                    Revisión lentillas
                                    @break
                                @default
                                    Desconocido
                            @endswitch
                        </li>
                        <li class="list-group-item"><strong>Fecha:</strong> {{ $appointment->appointment_date->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</li>
                        <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($appointment->status) }}</li>
                    </ul>
                </div>

                <form id="cancel-form" action="{{ request()->input('from_portal') === 'true' ? route('user.cancel', $appointment->id) : route('appointment.cancel', $appointment->id) }}" method="POST" class="mt-4 text-center">
                    @csrf
                    <input type="hidden" name="from_portal" value="{{ request()->input('from_portal', 'false') }}">

                    <button type="submit" class="btn btn-danger">Sí, eliminar cita</button>
                    <a href="{{ request()->input('from_portal') === 'true' ? route('user.appointments') : route('appointment.manage', $appointment->confirmation_token) }}" class="btn btn-secondary ms-2">No, volver</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    const cancelForm = document.getElementById('cancel-form');
    const statusMessage = document.getElementById('status-message');
    const messageText = document.getElementById('message-text');

    function showMessage(message, type) {
        statusMessage.className = 'alert';
        statusMessage.classList.add(`alert-${type}`, 'show');
        messageText.textContent = message;
        statusMessage.style.display = 'block';
        setTimeout(() => {
            statusMessage.style.display = 'none';
            statusMessage.classList.remove('show');
        }, 3000);
    }

    cancelForm.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar cita?',
            text: '¿Estás seguro de que quieres eliminar esta cita?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            customClass: {
                popup: 'swal2-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: data.message || 'Cita eliminada con éxito',
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
</script>
@endsection