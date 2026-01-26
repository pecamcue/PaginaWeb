@extends('layouts.app')
@section('title', 'Taller Óptico | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Servicios &rarr; Taller</li>
        </ol>
    </nav>

    <!-- Sección principal: texto + lista -->
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h1 class="display-4 fw-bold text-primary mb-4">
                🔧 Taller Óptico
            </h1>
            <p class="lead text-muted mb-4">
                Contamos con un taller propio para garantizarte el mejor servicio en reparación y montaje de gafas.
            </p>
            <ul class="list-unstyled mb-5">
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Montaje de lentes en 1 hora*</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Lentes en stock: antirreflejante, filtro azul y sol</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Reparación de monturas</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Servicio para otras ópticas</li>
                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Última tecnología en maquinaria óptica</li>
            </ul>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <!-- Puedes añadir una imagen general del taller aquí si tienes una -->
            <!-- <img src="{{ asset('img/taller-general.jpg') }}" class="img-fluid rounded shadow-lg w-100" alt="Taller Óptico"> -->
        </div>
    </div>
</div>

<!-- Equipos del taller -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">🔍 Nuestro Equipo en el Taller</h2>
            <p class="lead text-muted" data-aos="fade-down">
                Contamos con la mejor tecnología para garantizar un servicio rápido y preciso.
            </p>
        </div>

        <!-- Primera fila: 2 imágenes más grandes -->
        <div class="row justify-content-center g-4 mb-5">
            <div class="col-md-6 col-lg-5" data-aos="zoom-in">
                <figure class="text-center bg-white p-3 rounded shadow-sm">
                    <img src="{{ asset('img/biseladora-automatica.jpg') }}" class="img-fluid img-equipo" alt="Biseladora Automática">
                    <figcaption class="mt-3 fw-bold text-dark">Biseladora Automática</figcaption>
                </figure>
            </div>
            <div class="col-md-6 col-lg-5" data-aos="zoom-in" data-aos-delay="200">
                <figure class="text-center bg-white p-3 rounded shadow-sm">
                    <img src="{{ asset('img/biseladora-manual.jpg') }}" class="img-fluid img-equipo" alt="Biseladora Manual">
                    <figcaption class="mt-3 fw-bold text-dark">Biseladora Manual</figcaption>
                </figure>
            </div>
        </div>

        <!-- Segunda fila: 3 imágenes más pequeñas -->
        <div class="row justify-content-center g-4">
            <div class="col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="300">
                <figure class="text-center bg-white p-3 rounded shadow-sm">
                    <img src="{{ asset('img/pulidora.jpg') }}" class="img-fluid img-equipo" alt="Pulidora">
                    <figcaption class="mt-3 fw-bold text-dark">Pulidora</figcaption>
                </figure>
            </div>
            <div class="col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="500">
                <figure class="text-center bg-white p-3 rounded shadow-sm">
                    <img src="{{ asset('img/maquina-ultrasonidos.jpg') }}" class="img-fluid img-equipo" alt="Máquina de Ultrasonidos">
                    <figcaption class="mt-3 fw-bold text-dark">Máquina de Ultrasonidos</figcaption>
                </figure>
            </div>
            <div class="col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="700">
                <figure class="text-center bg-white p-3 rounded shadow-sm">
                    <img src="{{ asset('img/calentador.jpg') }}" class="img-fluid img-equipo" alt="Calentador de Monturas">
                    <figcaption class="mt-3 fw-bold text-dark">Calentador de Monturas</figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Imágenes del equipo: fondo blanco, centradas y con tamaño consistente */
    .img-equipo {
        max-height: 250px;
        object-fit: contain;
        background-color: #ffffff;
    }

    /* Figure con fondo blanco y sombra suave */
    figure {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    figure:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }

    figcaption {
        font-size: 1.1rem;
    }

    /* Responsive ajustes */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        .display-5 {
            font-size: 2rem;
        }
        .img-equipo {
            max-height: 200px;
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