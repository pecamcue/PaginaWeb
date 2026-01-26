@extends('layouts.app')

@section('content')
<style>
    .text-primary {
        color: #2CA1B5 !important;
    }
    .btn-primary {
        background-color: #2CA1B5;
        border-color: #2CA1B5;
    }
    .btn-primary:hover {
        background-color: #1e8291;
        border-color: #1e8291;
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

        h1 {
            font-size: 1.5rem;
        }

        /* Ajustes para el formulario (genérico, ya que appointment.form no está proporcionado) */
        form {
            font-size: 0.9rem;
        }

        form .form-group {
            margin-bottom: 15px;
        }

        form label {
            font-size: 0.9rem;
        }

        form input,
        form select,
        form textarea {
            font-size: 0.9rem;
            padding: 8px;
            width: 100%;
        }

        form button[type="submit"] {
            font-size: 0.9rem;
            padding: 8px 12px;
            width: 100%;
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
    }
</style>

<div class="container py-5">
    <h1 class="mb-4">Crear Nueva Cita</h1>

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

    @include('appointment.form', ['from_portal' => true])
</div>
@endsection