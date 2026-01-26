@extends('layouts.app') 

@section('title', 'Nosotros - Óptica y Audiología')

@section('content')

<div class="container py-5">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nosotros</li>
        </ol>
    </nav>

    <!-- Título principal -->
    <div class="text-center mb-5" data-aos="fade-up">
        <h1 class="fw-bold text-primary">👓 Óptica y Audiología Concha Cuevas</h1>
        <p class="lead text-muted">Comprometidos con tu salud visual y auditiva desde 2003.</p>
    </div>

    <!-- Contenido por bloques numerados -->
    <div class="row gy-4">
        <!-- 1. Desde 2003 contigo -->
        <div class="col-md-6" data-aos="fade-right">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">1</span>
                    <i class="bi bi-calendar2-check-fill me-2"></i> Desde 2003 contigo
                </h5>
                <p>Fundada en <strong>Julio de 2003</strong>, nuestra óptica ha crecido gracias a la <strong>innovación constante</strong>, la adaptación tecnológica y una formación continua que nos mantiene a la vanguardia.</p>
            </div>
        </div>

        <!-- 2. Selección de productos -->
        <div class="col-md-6" data-aos="fade-left">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">2</span>
                    <i class="bi bi-eyeglasses me-2"></i> Selección de productos
                </h5>
                <p>Ofrecemos <strong>gafas de sol, graduadas, lentes de contacto, audífonos</strong>, líquidos… Todo con un <strong>asesoramiento cercano</strong> para que encuentres justo lo que necesitas.</p>
            </div>
        </div>

        <!-- 3. Instalaciones y equipo humano -->
        <div class="col-md-6" data-aos="fade-right">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">3</span>
                    <i class="bi bi-buildings-fill me-2"></i> Instalaciones y equipo humano
                </h5>
                <p>Nuestras <strong>instalaciones modernas</strong> y un <strong>equipo profesional</strong> hacen de nuestro centro un lugar de referencia en <strong>Moncada y alrededores</strong>.</p>
            </div>
        </div>

        <!-- 4. Asesoramiento visual -->
        <div class="col-md-6" data-aos="fade-left">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">4</span>
                    <i class="bi bi-search-heart me-2"></i> Asesoramiento visual completo
                </h5>
                <p>Desde un <strong>reconocimiento visual detallado</strong> hasta elegir <strong>la montura perfecta</strong>, te acompañamos en cada paso para que tu experiencia sea perfecta.</p>
            </div>
        </div>

        <!-- 5. Filosofía -->
        <div class="col-md-6" data-aos="fade-right">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">5</span>
                    <i class="bi bi-stars me-2"></i> Filosofía y profesionalidad
                </h5>
                <p>Somos conocidos por nuestro <strong>asesoramiento profesional</strong>, <strong>tecnología de vanguardia</strong> y un equipo comprometido con la <strong>excelencia en cada detalle</strong>.</p>
            </div>
        </div>

        <!-- 6. Audiología -->
        <div class="col-md-6" data-aos="fade-left">
            <div class="p-4 rounded shadow-sm bg-light h-100">
                <h5 class="text-primary">
                    <span class="badge me-2" style="background-color: #2CA1B5; color: white;">6</span>
                    <i class="bi bi-ear me-2"></i> También cuidamos tu audición
                </h5>
                <p>Incorporamos los <strong>últimos avances en audiología</strong> para ofrecerte una experiencia completa de salud auditiva.</p>
            </div>
        </div>

        <!-- 7. Frase final -->
        <div class="col-12" data-aos="zoom-in">
            <div class="p-4 rounded shadow bg-white text-center">
                <h4 class="fw-bold text-primary"><i class="bi bi-heart-pulse-fill me-2"></i> Calidad y confianza</h4>
                <p class="mb-0">
                    Nuestra base es la <strong>calidad</strong>, nuestro motor es la <strong>confianza</strong>. <br>
                    <strong class="text-secondary d-block mt-2" style="text-transform: uppercase;">
                        CONCHA CUEVAS ES TU ÓPTICA AMIGA PARA UNA MEJOR VISIÓN Y UNA MEJOR AUDICIÓN.
                    </strong>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
