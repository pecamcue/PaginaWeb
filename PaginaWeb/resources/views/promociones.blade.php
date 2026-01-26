@extends('layouts.app')
@section('title', 'Promociones | Óptica y Audiología Concha Cuevas')
@section('content')
<div class="container py-5 bg-white">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Promociones Actuales</li>
        </ol>
    </nav>

    <h1 class="text-center mb-5 fw-bold text-primary display-4">
        Promociones Actuales
    </h1>

    <!-- 2 promociones por fila en desktop, 1 en móvil -->
    <div class="row g-5 justify-content-center">
        <!-- Promoción 1: Plan Veo -->
        <div class="col-12 col-md-6" data-aos="fade-up">
            <div class="card shadow-lg border-0 h-100">
                <img src="{{ asset('img/promoplanveo.jpg') }}" class="card-img-top img-promo" alt="Plan Veo 2025">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Plan Veo 2025</h3>
                        <p class="text-muted mb-4">
                            Ayuda de hasta 100€ para gafas infantiles. Ven a informarte y solicitarla.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>

        <!-- Promoción 2: Gafas estudiantes -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card shadow-lg border-0 h-100">
                <img src="https://img.freepik.com/foto-gratis/retrato-joven-tutora-gafas-sosteniendo-sus-cuadernos-documentos-sonriendo-camara_1258-218212.jpg" class="card-img-top img-promo" alt="Promoción gafas para estudiantes">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Promoción gafas para estudiantes</h3>
                        <p class="text-muted mb-4">
                            Montura + Cristales 139€ con tratamiento antirreflejante y filtro azul.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita óptica
                    </a>
                </div>
            </div>
        </div>

        <!-- Promoción 3: Gafas infantiles -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="card shadow-lg border-0 h-100">
                <img src="https://www.zamarripa.es/wp-content/uploads/2017/07/zamarripa-opticos-salud-visual-auditiva-vuelta-al-cole-resivion-vista-nin%CC%83os-nin%CC%83a-en-clase-1.jpg" class="card-img-top img-promo" alt="Promoción gafas infantiles">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Promoción gafas infantiles</h3>
                        <p class="text-muted mb-4">
                            Gafa completa (montura + cristales) por 119€.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>

        <!-- Promoción 4: Tapones baño -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="card shadow-lg border-0 h-100">
                <img src="{{ asset('img/baño.png') }}" class="card-img-top img-promo" alt="Tapones de baño a medida" onerror="this.src='https://audiocenter.es/wp-content/uploads/2024/02/tapones-oidos-piscina-a-medida-2.jpg'; this.onerror=null;">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Tapones de baño a medida</h3>
                        <p class="text-muted mb-4">
                            Protege tus oídos en la piscina o el mar por solo 40€/unidad.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>

        <!-- Promoción 5: Gafas luz azul -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="800">
            <div class="card shadow-lg border-0 h-100">
                <img src="https://img.freepik.com/fotos-premium/gafas-mujer-rojas-negras-trabajar-computadora-filtro-azul-teclado-portatil-anti-luz-azul-rayos-proteccion-ojos_407348-118.jpg" class="card-img-top img-promo" alt="Gafas con filtro luz azul">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Gafas con filtro luz azul</h3>
                        <p class="text-muted mb-4">
                            Protege tus ojos de las pantallas y luz azul dañina.<br>
                            Llévate 2 gafas con lentes sin graduación y filtro especial de luz azul por 80€.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>

        <!-- Promoción 6: Gafas + Lentillas -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="1000">
            <div class="card shadow-lg border-0 h-100">
                <img src="{{ asset('img/gafa+lentillas.png') }}" class="card-img-top img-promo" alt="Combo gafas + lentillas">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Combo perfecto: Gafas + Lentillas</h3>
                        <p class="text-muted mb-4">
                            El pack ideal para alternar entre gafas y lentillas con descuento especial.
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>

        <!-- Nueva Promoción 7: 2 Gafas de sol polarizadas -->
        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="1200">
            <div class="card shadow-lg border-0 h-100">
                <img src="{{ asset('img/combogafas.png') }}" class="card-img-top img-promo" alt="2 Gafas de sol con cristal polarizado">
                <div class="card-body text-center d-flex flex-column justify-content-between p-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-3">Promoción Sol</h3>
                        <p class="text-muted mb-4">
                            Llévate 2 gafas de sol con cristal polarizado por 79€ (1 por 49€).<br>
                            Promoción no aplicable a ciertas colecciones exclusivas.<br>
                            
                        </p>
                    </div>
                    <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow mt-auto">
                        Reserva tu cita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Imagen de promoción: completa y bien centrada */
    .img-promo {
        height: 350px;
        object-fit: cover;
        object-position: center;
    }

    /* Cards más anchas (2 por fila) */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px rgba(0,0,0,0.15);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
    }

    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        .img-promo {
            height: 250px;
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