@extends('layouts.app')
@section('title', 'Óptica | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Servicios &rarr; Óptica</li>
        </ol>
    </nav>

    <!-- Sección principal: título alineado con la imagen -->
    <div class="row align-items-center g-5">
        <div class="col-lg-6 order-lg-2 order-1 mb-5 mb-lg-0" data-aos="fade-left">
            <img src="{{ asset('img/optica.jpg') }}" alt="Óptica Concha Cuevas"
                 class="img-fluid rounded shadow-lg w-100">
        </div>
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            <h1 class="display-4 fw-bold text-primary mb-4">
                👓 Óptica Concha Cuevas
            </h1>
            <p class="lead text-muted mb-4">
                Trabajamos cada día para mejorar tu visión y sus capacidades mediante lentes, filtros, prismas y terapia visual.
            </p>
            <p class="text-muted mb-5">
                Realizamos pruebas personalizadas según tus necesidades, edad y antecedentes para garantizar el mejor cuidado de tu salud visual.
            </p>
            <a href="{{ route('appointment.create') }}"
               class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg" style="font-size: 1.2rem;">
                Pide tu cita ahora
            </a>
        </div>
    </div>
</div>

<!-- Servicios / Estudio Optométrico -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">Estudio Optométrico Completo</h2>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h5 class="fw-bold text-primary">Refracción Optométrica</h5>
                    <p class="text-muted mt-auto">
                        Evaluamos tu estado refractivo y corregimos anomalías como el astigmatismo, miopía o hipermetropía.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h5 class="fw-bold text-primary">Binocularidad & Visión en Profundidad</h5>
                    <p class="text-muted mt-auto">
                        Analizamos cómo trabajan juntos tus ojos para garantizar una visión eficiente y cómoda.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h5 class="fw-bold text-primary">Motilidad Ocular & Campo Visual</h5>
                    <p class="text-muted mt-auto">
                        Evaluamos la movilidad de tus ojos y el campo visual para detectar posibles problemas.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="600">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h5 class="fw-bold text-primary">Tonometría (Tensión Ocular)</h5>
                    <p class="text-muted mt-auto">
                        Medimos la presión intraocular para detectar posibles riesgos de glaucoma y otras afecciones oculares.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Fondo blanco uniforme en toda la página */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Botón más destacado */
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

    /* Cards más limpias y con misma altura */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }

    /* Responsive ajustes */
    @media (max-width: 768px) {
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