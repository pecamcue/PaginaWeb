@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Editar información personal</h2>

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

    <form action="{{ route('perfil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $user->apellidos) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}" required>
        </div>

        <div class="mb-3">
            <label>Calle</label>
            <input type="text" name="calle" class="form-control" value="{{ old('calle', $user->calle) }}" required>
        </div>

        <div class="mb-3">
            <label>Número</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero', $user->numero) }}" required>
        </div>

        <div class="mb-3">
            <label>Piso (opcional)</label>
            <input type="text" name="piso" class="form-control" value="{{ old('piso', $user->piso) }}">
        </div>

        <div class="mb-3">
            <label>Ciudad</label>
            <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $user->ciudad) }}" required>
        </div>

        <div class="mb-3">
            <label>Código Postal</label>
            <input type="text" name="codigo_postal" class="form-control" value="{{ old('codigo_postal', $user->codigo_postal) }}" required>
        </div>

        <div class="mb-3">
            <label>País</label>
            <input type="text" name="pais" class="form-control" value="{{ old('pais', $user->pais) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
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