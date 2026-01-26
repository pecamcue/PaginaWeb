@extends('layouts.app')
@section('title', 'Audiología | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Servicios &rarr; Audiología</li>
        </ol>
    </nav>

    <!-- Sección principal: título alineado con la imagen -->
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            <h1 class="display-4 fw-bold text-primary mb-4">
                🎧 Centro de Audiología
            </h1>
            <p class="lead text-muted mb-4">
                Ofrecemos lo último en tecnología auditiva para mejorar tu calidad de vida.
            </p>
            <p class="text-muted mb-5">
                Nuestro centro auditivo ofrece lo último en tecnología de ayuda auditiva y diseño adaptable siguiendo los estándares de calidad y nuestra forma de ser.
            </p>
            <a href="{{ route('appointment.create') }}"
               class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg" style="font-size: 1.2rem;">
                Pide tu cita ahora
            </a>
        </div>
        <div class="col-lg-6 order-lg-2 order-1 mb-5 mb-lg-0" data-aos="fade-left">
            <img src="{{ asset('img/audio.jpg') }}" alt="Centro Auditivo"
                 class="img-fluid rounded shadow-lg w-100">
        </div>
    </div>
</div>

<!-- Acordeón de servicios -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">En nuestro centro auditivo se le realizará:</h2>
        </div>

        <div class="accordion" id="accordionServicios">
            <div class="accordion-item" data-aos="fade-up">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Asesoramiento y venta de audífonos
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Conocerte, conocer tu problema auditivo, tus aspiraciones y tu forma de vida es necesario para ofrecerte el mejor asesoramiento y así solucionar tu problema auditivo.
                    </div>
                </div>
            </div>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        Adaptación de audífonos
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Los audífonos necesitan ser adaptados a tu pérdida de audición.
                    </div>
                </div>
            </div>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        Estudio auditivo sin compromiso
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Revisamos tu audición. Evaluamos no solo cómo escuchas sino cómo entiendes.
                    </div>
                </div>
            </div>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                        Tratamiento de Tinnitus o Acúfenos
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        El derecho al descanso, a pasar noches tranquilas y en silencio, se pierde con la aparición de los acúfenos. El tinnitus tiene tratamiento, y una de las bases de su éxito consiste en adoptar las medidas necesarias lo antes posible.
                    </div>
                </div>
            </div>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                        Tapones a medida
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        ¿En tu trabajo estás expuesto a un alto nivel de ruido? ¿Practicas natación o caza? Si la respuesta es sí, tu audición puede estar en riesgo. Una buena solución para estas situaciones son los tapones a medida. Fabricamos todo tipo de tapones personalizados.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Beneficios exclusivos -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">✅ Beneficios exclusivos de nuestro centro auditivo</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul class="list-unstyled text-muted lead">
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Precio acorde a relación calidad/precio.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Última tecnología auditiva.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Demostraciones gratuitas de productos.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Exámenes auditivos gratuitos.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Seguimiento gratuito del proceso.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Mantenimiento del dispositivo de forma gratuita.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Garantía mínima gratuita (varía en función del modelo).</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Pilas gratuitas*.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Periodo de prueba.</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-5">
            <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">🔗 Complementa tus audífonos con accesorios</h2>
            <p class="lead text-muted mt-4">
                Cada fabricante ofrece diferentes soluciones sin cables que pueden mejorar la experiencia al ver la televisión y la comunicación por teléfono. Para más información sobre accesorios o para aprender más sobre otros dispositivos compatibles con su audífono, visite nuestro Centro Auditivo.
            </p>
        </div>
    </div>
</section>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Acordeón personalizado con tu color */
    .accordion-button {
        background-color: var(--primary-color) !important;
        color: white !important;
        font-weight: bold;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--primary-hover) !important;
        color: white !important;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-body {
        background-color: #f8fdff;
        color: #333;
    }

    /* Botón destacado */
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

    /* Responsive */
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