@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start min-vh-100" style="background-color: white; width: 100%; padding-top: 1rem;">
    <div style="max-width: 400px; width: 90%;">
        <div class="card shadow-lg border-0 rounded p-4 login-card" style="background-color: #30A2B6 !important; color: white !important;">
            <h2 class="text-center fw-bold mb-4">Bienvenido</h2>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show p-2 mb-3" style="font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('password.request') }}" class="text-light text-decoration-underline" style="font-size:0.9rem;">¿Olvidaste tu contraseña?</a>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-light text-primary fw-bold">Iniciar Sesión</button>
                </div>

                <div class="text-center">
                    <span>¿Aún no tienes cuenta?</span>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-bold ms-2">Registrarse</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Inputs iguales */
    .form-control {
        height: 3rem;
        font-size: 1rem;
        border-radius: 0.5rem;
    }

    /* Flexbox para centrar login horizontalmente */
    .min-vh-100 {
        display: flex;
        align-items: start;
        justify-content: center;
    }

    /* Ajuste de card para que no se vea pegada a los bordes en móviles */
    .login-card {
        width: 100%;
        background-color: #30A2B6 !important;
        color: white !important;
    }
    .login-card .form-label {
        color: white !important;
        font-weight: bold !important;
    }
    .login-card .form-control {
        background-color: rgba(255, 255, 255, 0.9) !important;
        border: 1px solid #ffffff !important;
        color: #333 !important;
    }
    .login-card .form-control:focus {
        background-color: #ffffff !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25) !important;
        color: #333 !important;
    }
    .login-card .btn-light {
        background-color: #ffffff !important;
        color: #30A2B6 !important;
        border-color: #ffffff !important;
    }
    .login-card .btn-light:hover {
        background-color: #f8f9fa !important;
        color: #30A2B6 !important;
    }
    .login-card .alert-danger {
        color: #dc3545 !important;
        background-color: rgba(220, 53, 69, 0.1) !important;
        border-color: #dc3545 !important;
    }
    .login-card a.text-light {
        color: white !important;
    }
    .login-card .text-light {
        color: white !important;
    }
    @media (max-width: 768px) {
        .login-card {
            max-width: 350px;
            margin: 0 auto;
        }
    }
</style>
@endsection