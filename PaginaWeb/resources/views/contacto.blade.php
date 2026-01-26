@extends('layouts.app')
@section('title', 'Contacto | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white min-vh-100">  <!-- Fondo blanco uniforme y altura mínima para empujar footer abajo -->
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contacto</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Columna para el mapa (izquierda en desktop) -->
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            <h3 class="display-5 fw-bold text-primary mb-4">
                📍 Óptica y Audiología Concha Cuevas
            </h3>
            <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">  <!-- Mapa más grande y responsive -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5568.20115601485!2d-0.3909374245616762!3d39.54762650807785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd60443df120003f%3A0x16b1574f257a9ca3!2sConcha%20Cuevas%20%C3%93ptica%20y%20Audiolog%C3%ADa!5e1!3m2!1sen!2ses!4v1734093715018!5m2!1sen!2ses"
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Columna para el formulario (derecha en desktop) -->
        <div class="col-lg-6 order-lg-2 order-1" data-aos="fade-left">
            <h2 class="display-4 fw-bold text-primary mb-4">
                📩 Formulario de Contacto
            </h2>
            <p class="lead text-muted mb-5">
                Déjanos tu mensaje y nos pondremos en contacto contigo lo antes posible.
            </p>
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="mb-4" data-aos="fade-up">
                    <label for="nombre" class="form-label fw-bold">Nombre</label>
                    <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Tu nombre" required>
                </div>
                <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                    <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                    <label for="tel" class="form-label fw-bold">Teléfono de Contacto</label>
                    <input type="tel" class="form-control form-control-lg" id="tel" name="tel" placeholder="Tu número de teléfono" required>
                </div>
                <div class="mb-4" data-aos="fade-up" data-aos-delay="300">
                    <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                    <textarea class="form-control form-control-lg" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                <button class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg w-100" type="submit" data-aos="zoom-in">
                    📤 Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Mensaje de éxito con SweetAlert2 -->
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

<style>
    /* Fondo blanco uniforme en toda la página */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Mapa más grande y con mejor proporción */
    .ratio-16x9 {
        --bs-aspect-ratio: 56.25%; /* 16:9 estándar */
    }

    /* Formulario más espacioso y elegante */
    .form-control-lg {
        border-radius: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }

    /* Empuja el footer abajo si el contenido es corto */
    .min-vh-100 {
        min-height: 100vh;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .display-4 {
            font-size: 2.8rem;
        }
        .display-5 {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.3rem;
        }
        .ratio-16x9 {
            --bs-aspect-ratio: 75%; /* Más cuadrado en móvil */
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800
    });
</script>
@endsection