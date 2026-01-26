@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: white; width: 100%;">
    <div style="max-width: 400px; width: 90%; margin-top: 2rem;">
        <div class="card shadow-lg border-0 rounded p-4 register-card" style="background-color: #30A2B6 !important; color: white !important;">
            <h2 class="text-center fw-bold mb-4">Regístrate</h2>
            <p class="text-center">Crea una cuenta para empezar</p>
            <p class="text-center"><strong>* Campos obligatorios</strong></p>

            <form id="register-form" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label required">Nombre</label>
                    <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Apellidos --}}
                <div class="mb-3">
                    <label for="apellidos" class="form-label required">Apellidos</label>
                    <input id="apellidos" class="form-control @error('apellidos') is-invalid @enderror" type="text" name="apellidos" value="{{ old('apellidos') }}" required>
                    @error('apellidos')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label required">Correo Electrónico</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="mb-3">
                    <label for="telefono" class="form-label required">Teléfono</label>
                    <input id="telefono" class="form-control @error('telefono') is-invalid @enderror" type="text" name="telefono" value="{{ old('telefono') }}" pattern="\+?[0-9]{9,15}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Calle --}}
                <div class="mb-3">
                    <label for="calle" class="form-label required">Calle</label>
                    <input id="calle" class="form-control @error('calle') is-invalid @enderror" type="text" name="calle" value="{{ old('calle') }}" required>
                    @error('calle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Número --}}
                <div class="mb-3">
                    <label for="numero" class="form-label required">Número</label>
                    <input id="numero" class="form-control @error('numero') is-invalid @enderror" type="text" name="numero" value="{{ old('numero') }}" required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Piso (opcional) --}}
                <div class="mb-3">
                    <label for="piso" class="form-label">Piso (Opcional)</label>
                    <input id="piso" class="form-control @error('piso') is-invalid @enderror" type="text" name="piso" value="{{ old('piso') }}">
                    @error('piso')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Código postal --}}
                <div class="mb-3">
                    <label for="codigo_postal" class="form-label required">Código Postal</label>
                    <input id="codigo_postal" class="form-control @error('codigo_postal') is-invalid @enderror" type="text" name="codigo_postal" value="{{ old('codigo_postal') }}" required>
                    @error('codigo_postal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ciudad --}}
                <div class="mb-3">
                    <label for="ciudad" class="form-label required">Ciudad</label>
                    <input id="ciudad" class="form-control @error('ciudad') is-invalid @enderror" type="text" name="ciudad" value="{{ old('ciudad') }}" required>
                    @error('ciudad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- País --}}
                <div class="mb-3">
                    <label for="pais" class="form-label required">País</label>
                    <input id="pais" class="form-control @error('pais') is-invalid @enderror" type="text" name="pais" value="{{ old('pais') }}" required>
                    @error('pais')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label required">Contraseña</label>
                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar Contraseña --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label required">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                </div>

                {{-- Botón --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-light">Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
    .register-card {
        background-color: #30A2B6 !important;
        color: white !important;
        transition: all 0.3s ease;
    }
    .register-card .form-label {
        color: white !important;
        font-weight: bold !important;
    }
    .register-card .form-control {
        background-color: rgba(255, 255, 255, 0.9) !important;
        border: 1px solid #ffffff !important;
        color: #333 !important;
        border-radius: 0.5rem;
        height: 2.5rem;
        transition: all 0.3s ease;
    }
    .register-card .form-control:focus {
        background-color: #ffffff !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25) !important;
        color: #333 !important;
    }
    .register-card .btn-light {
        background-color: #ffffff !important;
        color: #30A2B6 !important;
        border-color: #ffffff !important;
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .register-card .btn-light:hover {
        background-color: #f8f9fa !important;
        color: #30A2B6 !important;
    }
    .register-card .invalid-feedback {
        color: #dc3545 !important;
        background-color: rgba(220, 53, 69, 0.1) !important;
        border: 1px solid #dc3545 !important;
        border-radius: 0.25rem;
        padding: 0.25rem;
        transition: all 0.3s ease;
    }
    @media (max-width: 768px) {
        .register-card {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('register-form').addEventListener('submit', function (e) {
        const name = document.getElementById('name').value.trim();
        const apellidos = document.getElementById('apellidos').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const calle = document.getElementById('calle').value.trim();
        const numero = document.getElementById('numero').value.trim();
        const codigoPostal = document.getElementById('codigo_postal').value.trim();
        const ciudad = document.getElementById('ciudad').value.trim();
        const pais = document.getElementById('pais').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;

        if (!name || !apellidos || !email || !telefono || !calle || !numero || !codigoPostal || !ciudad || !pais || !password || !passwordConfirm) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, completa todos los campos obligatorios.',
                customClass: { popup: 'swal2-custom-error' }
            });
            return;
        }
        if (password !== passwordConfirm) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden.',
                customClass: { popup: 'swal2-custom-error' }
            });
            return;
        }
        if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, introduce un correo electrónico válido.',
                customClass: { popup: 'swal2-custom-error' }
            });
            return;
        }
        if (!telefono.match(/\+?[0-9]{9,15}/)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, introduce un número de teléfono válido.',
                customClass: { popup: 'swal2-custom-error' }
            });
            return;
        }
    });
});
</script>
@endpush
@endsection