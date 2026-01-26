@extends('layouts.app')

@section('content')
<style>
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
</style>

<div class="container py-5">
    @include('appointment.edit', ['from_portal' => true, 'appointment' => $appointment])
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('edit-form');

    const submitButton = form.querySelector('button[type="submit"]');
    if (!submitButton) {
        console.error('Botón submit no encontrado en el formulario.');
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(this)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} ${response.statusText}`);
            }
            return response.json().catch(() => {
                throw new Error('Respuesta no es JSON válido');
            });
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Éxito',
                    text: data.message || 'Cita modificada correctamente',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-custom'
                    }
                }).then(() => {
                    window.location.href = '{{ route("user.appointments") }}';
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.error || 'Error al modificar la cita.',
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
            console.error('Error en la solicitud AJAX:', error);
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
    });
});
</script>
@endsection