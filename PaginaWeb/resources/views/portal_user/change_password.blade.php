@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Cambiar contraseña</h2>

    @if (session('success') || $errors->any())
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
                @if ($errors->any())
                    Swal.fire({
                        title: 'Error',
                        text: '{!! implode("<br>", $errors->all()) !!}',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        customClass: {
                            popup: 'swal2-custom-error'
                        }
                    });
                @endif
            });
        </script>
    @endif

    <form method="POST" action="{{ route('perfil.updatePassword') }}">
        @csrf

        <!-- Campo de contraseña actual -->
        <div class="mb-3">
            <label for="current_password" class="form-label">Contraseña actual</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>

        <!-- Campo de nueva contraseña -->
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <!-- Confirmar nueva contraseña -->
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
    </form>
</div>

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
</style>
@endsection