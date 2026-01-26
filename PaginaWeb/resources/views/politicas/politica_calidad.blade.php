@extends('layouts.app')
@section('title', 'Política de Calidad | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Política de Calidad</li>
        </ol>
    </nav>

    <!-- Compromiso con la Calidad -->
    <section id="compromiso" class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-4 fw-bold text-primary mb-4">
            Compromiso con la Calidad
        </h2>
        <p class="lead text-muted mx-auto" style="max-width: 900px;">
            Óptica y Audiología Concha Cuevas está comprometida con el servicio que desarrollamos para garantizar la máxima satisfacción de nuestros clientes y la calidad de las lentes.
        </p>
        <p class="text-muted mx-auto" style="max-width: 900px;">
            Para asegurar el cumplimiento de estas responsabilidades, dispone de un Sistema Integrado de Gestión de Calidad basado en la norma UNE-EN-ISO 9001:2015.
        </p>
        <p class="text-muted mx-auto" style="max-width: 900px;">
            La Dirección se compromete a disponer de los recursos humanos y medios materiales necesarios para cumplir con los requisitos de las actividades que se desarrollan, los objetivos y mejorar continuamente la eficacia de nuestro Sistema de Gestión de Calidad. La Política del SGC es revisada para su continua adecuación y se comunica convenientemente para su difusión.
        </p>
    </section>

    <!-- Misión y Visión -->
    <section id="mision-vision" class="mb-5" data-aos="fade-up">
        <h2 class="display-4 fw-bold text-primary text-center mb-5">
            Misión y Visión
        </h2>
        <div class="row g-5 justify-content-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="text-center p-4 rounded shadow-sm bg-light">
                    <h3 class="h4 fw-bold text-primary mb-3">MISIÓN</h3>
                    <p class="lead text-muted">
                        Mejorar el bienestar de la sociedad a través de la innovación constante en productos y servicios de salud visual y auditiva de alta calidad.
                    </p>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="text-center p-4 rounded shadow-sm bg-light">
                    <h3 class="h4 fw-bold text-primary mb-3">VISIÓN</h3>
                    <p class="lead text-muted">
                        Ser la mejor óptica gracias a nuestros servicios personalizados, atención de calidad y excelentes productos.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestros Valores (acordeón CERRADO por defecto) -->
    <section id="valores" class="mb-5" data-aos="fade-up">
        <h2 class="display-4 fw-bold text-primary text-center mb-5">
            Nuestros Valores
        </h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="accordionValores">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#valor1">
                                Orientación al Cliente
                            </button>
                        </h2>
                        <div id="valor1" class="accordion-collapse collapse">
                            <div class="accordion-body text-muted">
                                El cliente es la prioridad de nuestro trabajo todos los días. Las preocupaciones de nuestros clientes también son las nuestras.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#valor2">
                                Afán de Superación
                            </button>
                        </h2>
                        <div id="valor2" class="accordion-collapse collapse">
                            <div class="accordion-body text-muted">
                                Sentimos pasión por nuestro trabajo. El éxito es un trabajo de equipo. Investigamos, innovamos y estudiamos constantemente.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#valor3">
                                Integridad
                            </button>
                        </h2>
                        <div id="valor3" class="accordion-collapse collapse">
                            <div class="accordion-body text-muted">
                                Trabajamos con una sólida ética laboral, honestidad y transparencia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#valor4">
                                Compromiso
                            </button>
                        </h2>
                        <div id="valor4" class="accordion-collapse collapse">
                            <div class="accordion-body text-muted">
                                Fomentamos la salud de la sociedad. Formación periódica de nuestra plantilla para que sepan responder a las necesidades de los pacientes y que siempre estén al día de los avances de la tecnología. Estamos comprometidos con acciones sociales y de medio ambiente.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Títulos más grandes y consistentes */
    .display-4 {
        font-size: 3rem;
    }

    /* Acordeón elegante con tu color */
    .accordion-button {
        background-color: #f8fdff !important;
        color: var(--primary-color) !important;
        font-weight: bold;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color) !important;
        color: white !important;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-body {
        background-color: #ffffff;
    }

    /* Cards de Misión/Visión con fondo muy claro */
    .bg-light {
        background-color: #f8fdff !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
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