@extends('layouts.app')
@section('title', 'Lentes de Contacto | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Servicios &rarr; Lentes de Contacto</li>
        </ol>
    </nav>

    <!-- Sección principal: título alineado con la imagen -->
    <div class="row align-items-center g-5">
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            <h1 class="display-4 fw-bold text-primary mb-4">
                👀 Lentes de Contacto
            </h1>
            <p class="lead text-muted mb-4">
                Las lentes de contacto ofrecen una visión sin límites y comodidad para tu día a día.
                Contamos con diferentes tipos de lentes adaptadas a tus necesidades.
            </p>
            <ul class="list-unstyled mb-5">
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Lentes diarias</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Lentes mensuales</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Lentes tóricas (astigmatismo)</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Lentes progresivas</li>
            </ul>
            <a href="{{ config('app.front_url') }}/productos/categoria/lentes-de-contacto"
               class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg" style="font-size: 1.2rem;">
                Ver Catálogo
            </a>
        </div>
        <div class="col-lg-6 order-lg-2 order-1 mb-5 mb-lg-0" data-aos="fade-left">
            <img src="{{ asset('img/contactologia.jpg') }}" alt="Lentes de Contacto"
                 class="img-fluid rounded shadow-lg w-100">
        </div>
    </div>
</div>

<!-- Beneficios -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">✨ Beneficios de las Lentes de Contacto</h2>
            <p class="lead text-muted" data-aos="fade-down">
                Disfruta de una visión clara sin limitaciones y con la máxima comodidad.
            </p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-5" data-aos="zoom-in">
                <i class="fas fa-eye fa-4x text-primary mb-4"></i>
                <h4 class="fw-bold">Mayor Campo Visual</h4>
                <p class="text-muted">Sin monturas que limiten tu visión.</p>
            </div>
            <div class="col-md-4 mb-5" data-aos="zoom-in" data-aos-delay="200">
                <i class="fas fa-running fa-4x text-success mb-4"></i>
                <h4 class="fw-bold">Libertad de Movimiento</h4>
                <p class="text-muted">Perfectas para practicar deportes.</p>
            </div>
            <div class="col-md-4 mb-5" data-aos="zoom-in" data-aos-delay="400">
                <i class="fas fa-sun fa-4x text-warning mb-4"></i>
                <h4 class="fw-bold">Compatible con Gafas de Sol</h4>
                <p class="text-muted">Úsalas con cualquier tipo de gafas.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Botón catálogo más destacado */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }

    /* Iconos en beneficios más grandes en móvil */
    @media (max-width: 768px) {
        .fa-4x {
            font-size: 3rem !important;
        }
        .display-4 {
            font-size: 2.5rem;
        }
        .display-5 {
            font-size: 2rem;
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