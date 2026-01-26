@extends('layouts.app')
@section('content')
    <!-- Header -->
    <header class="text-white text-center py-5">
        <div class="container">
           <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" role="region" aria-live="polite" aria-label="Carrusel de imágenes de Óptica y Audiología Concha Cuevas">
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                    <img src="{{ asset('img/navidad.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Óptica y Audiología Concha Cuevas">
                </div>
                <div class="carousel-item active">
                    <img src="{{ asset('img/PlanVeo.png') }}" class="d-block w-100 img-carrusel-fija" alt="Óptica y Audiología Concha Cuevas">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_1.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Óptica y Audiología Concha Cuevas">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_2.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Servicios de óptica">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_3.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Consulta auditiva">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_4.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Productos de óptica">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_5.jpg') }}" class="d-block w-100 img-carrusel-fija" alt="Tienda y equipo profesional">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image_6.png') }}" class="d-block w-100 img-carrusel-fija" alt="Salud auditiva">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" aria-label="Slide anterior">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" aria-label="Slide siguiente">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    <!-- Newsletter Section -->
    <section class="py-5 bg-white">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="text-center mb-4 font-heading text-dark">
                Suscríbete a nuestra 
                <span class="fw-bold text-primary">Newsletter</span>
            </h2>

            <form class="d-flex flex-column align-items-center"
                  action="{{ route('newsletter.subscribe') }}"
                  method="POST">
                @csrf    

                <div class="input-group mb-3 w-100">
                    <input type="email"
                           name="email"
                           class="form-control rounded-start"
                           placeholder="Tu e-mail"
                           required>

                    <button class="btn btn-primary rounded-end" type="submit">
                        Suscríbete
                    </button>
                </div>

                <div class="form-check text-center text-secondary">
                    <input class="form-check-input"
                           type="checkbox"
                           id="acceptTerms"
                           name="accept_terms"
                           required>

                    <label class="form-check-label" for="acceptTerms">
                        Acepto los 
                        <a href="{{ route('politicas.terminos_condiciones') }}"
                           class="text-primary text-decoration-underline">
                            términos y condiciones
                        </a>
                        y la
                        <a href="{{ route('politicas.politica_privacidad') }}"
                           class="text-primary text-decoration-underline">
                            política de privacidad
                        </a>
                    </label>
                </div>

            </form>
        </div>
    </div>
</section>

    <!-- Mostrar mensajes de sesión con SweetAlert2 -->
    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                    Swal.fire({
                        title: 'Éxito',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-custom'
                        }
                    });
                @endif
                @if (session('error'))
                    Swal.fire({
                        title: 'Error',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-custom-error'
                        }
                    });
                @endif
            });
        </script>
    @endif
    <!-- Features Section -->
    <section class="py-5 bg-white">  <!-- Fondo blanco puro -->
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-dark">Envío gratuito</h5>
                <p class="text-dark fw-bold">A partir de 50€</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-dark">Pago seguro</h5>
                <p class="text-dark fw-bold">Con tarjeta, bizum,...</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-dark">Garantía de devolución</h5>
                <p class="text-dark fw-bold">7 días</p>
            </div>
        </div>
    </div>
</section>
        <main class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="card-container row g-3">
                       
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="{{ config('app.front_url') }}/productos/categoria/gafas-de-sol" class="card-link" aria-label="Ver Gafas de Sol">
                                <div class="card h-100">
                                    <img src="{{ asset('img/Ray-Ban_Icons.webp') }}" class="card-img-top img-tarjeta-cuadrada" alt="Gafas Ray Ban Icon">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <h5 class="card-title font-heading mb-0">Ver gafas de sol</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="{{ config('app.front_url') }}/productos/categoria/gafas-graduadas" class="card-link" aria-label="Ver Gafas Graduadas">
                                <div class="card h-100">
                                    <img src="{{ asset('img/Tous.jpg') }}" class="card-img-top img-tarjeta-cuadrada" alt="Gafas Tous">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <h5 class="card-title font-heading mb-0">Ver gafas graduadas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="{{ config('app.front_url') }}/productos/categoria/lentes-de-contacto" class="card-link" aria-label="Ver Lentillas">
                                <div class="card h-100">
                                    <img src="{{ asset('img/lentill.jpg') }}" class="card-img-top img-tarjeta-cuadrada" alt="Lentes de Contacto">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <h5 class="card-title font-heading mb-0">Lentillas / Otros</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="https://search.google.com/local/writereview?placeid=ChIJPwAg8T1EYA0Ro5x6JU9XsRY" class="card-link" target="_blank" rel="noopener noreferrer" aria-label="Deja tu Reseña en Google">
                                <div class="card h-100">
                                    <img src="{{ asset('img/reseña.png') }}" class="card-img-top img-tarjeta-cuadrada" alt="Deja tu reseña">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <h5 class="card-title font-heading mb-0">Deja tu Reseña</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
              
    <!-- Opiniones (Slick Slider Carousel) -->
    <section id="opiniones" class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4 font-heading">Reseñas de Nuestros Clientes en Google</h2>
            <div class="reviews-carousel">
                @forelse ($reviews as $review)
                    <div class="px-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; min-height: 400px;">
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                @if (!empty($review->profile_photo_url))
                                    <img src="{{ $review->profile_photo_url }}" class="rounded-circle mb-3 mx-auto" width="80" height="80" alt="Foto de {{ $review->author_name }}" style="object-fit: cover;">
                                @else
                                    <i class="fas fa-user-circle fa-4x text-primary mb-3 mx-auto"></i>
                                @endif
                                <div class="d-flex justify-content-center mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} me-1" style="font-size: 1.2rem;"></i>
                                    @endfor
                                </div>
                                <div class="review-text-container" style="max-height: 200px; overflow-y: auto; font-size: 1.2rem; line-height: 1.5;">
                                    <p class="card-text text-muted mb-0">"{{ $review->text }}"</p>
                                </div>
                                <h6 class="fw-bold text-primary mt-3">{{ $review->author_name }}</h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; min-height: 400px;">
                            <div class="card-body p-4 d-flex flex-column justify-content-center">
                                <p class="card-text text-muted" style="font-size: 1.2rem;">No hay reseñas disponibles en este momento.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
        <style>
            .font-heading {
                font-family: 'Roboto', sans-serif;
            }
            .reviews-carousel .slick-slide {
                transition: all 0.3s ease;
                opacity: 0.8;
            }
            .reviews-carousel .slick-slide.slick-active {
                opacity: 1;
            }
            .reviews-carousel .card {
                margin: 0 auto;
                max-width: 350px;
                background-color: #fff;
            }
            .reviews-carousel .review-text-container::-webkit-scrollbar {
                width: 8px;
            }
            .reviews-carousel .review-text-container::-webkit-scrollbar-thumb {
                background-color: #2CA1B5;
                border-radius: 4px;
            }
            .reviews-carousel .review-text-container::-webkit-scrollbar-track {
                background-color: #f1f1f1;
            }
            .reviews-carousel .slick-dots li button:before {
                font-size: 12px;
                color: #2CA1B5;
            }
            .reviews-carousel .slick-dots li.slick-active button:before {
                color: #2CA1B5;
            }
            @media (max-width: 991px) {
                .features-mobile {
                    display: flex;
                    flex-direction: row; /* Disposición horizontal */
                    flex-wrap: nowrap; /* Evitar que los elementos se envuelvan */
                    overflow-x: auto; /* Permitir desplazamiento horizontal */
                    scroll-snap-type: x mandatory; /* Desplazamiento suave */
                    -webkit-overflow-scrolling: touch; /* Mejor experiencia en dispositivos móviles */
                    padding-bottom: 10px; /* Espacio para el scroll */
                    justify-content: flex-start; /* Alinear al inicio */
                }
                .feature-item {
                    flex: 0 0 calc((100vw - 40px) / 3); /* Ajuste dinámico al ancho de la pantalla (3 items) */
                    min-width: 120px; /* Ancho mínimo para legibilidad */
                    margin-right: 10px; /* Espacio reducido entre elementos */
                    scroll-snap-align: start; /* Alinear elementos al inicio del scroll */
                    padding: 10px; /* Padding interno para mejor visualización */
                    box-sizing: border-box; /* Incluir padding en el ancho */
                }
                .feature-item:last-child {
                    margin-right: 0; /* Eliminar margen del último elemento */
                }
                .feature-item h5, .feature-item p {
                    font-size: 0.9rem; /* Reducir tamaño de texto para ajuste */
                }
                .feature-item i {
                    font-size: 1.5rem; /* Reducir tamaño de iconos */
                }
            }
            @media (max-width: 768px) {
                .reviews-carousel .card {
                    max-width: 90%;
                }
            }
            /* Centrar imágenes en las tarjetas y ajustar espaciado en modo responsivo vertical (< 1056px) */
            @media (max-width: 1056px) {
                .card-container {
                    display: flex;
                    flex-direction: column; /* Mantener disposición vertical */
                    align-items: center; /* Centrar tarjetas horizontalmente */
                    padding: 0; /* Eliminar padding adicional */
                }
                .card-container .col-12 {
                    padding-left: 0; /* Eliminar padding de Bootstrap */
                    padding-right: 0;
                }
                .card {
                    width: 100%;
                    max-width: 300px; /* Ancho máximo para tarjetas */
                    margin: 10px auto; /* Centrar tarjeta horizontalmente */
                    box-sizing: border-box;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Mantener sombra */
                }
                .card-img-top {
                    display: block;
                    margin: 0 auto; /* Centrar imagen horizontalmente */
                    object-fit: contain; /* Mostrar imagen completa */
                    width: 100%;
                    max-width: 280px; /* Ajustar ancho máximo para padding simétrico */
                    height: auto;
                    padding: 10px; /* Espacio uniforme dentro del recuadro */
                    box-sizing: border-box;
                }
                .card-body {
                    text-align: center; /* Centrar texto de la tarjeta */
                }
                /* Ajustes para carrusel y newsletter en modo responsivo vertical */
                header {
                    padding: 0; /* Eliminar todo padding */
                    margin: 0; /* Eliminar todo margen */
                }
                .carousel {
                    margin: 0; /* Eliminar márgenes */
                    padding: 0; /* Eliminar padding */
                }
                .carousel-inner {
                    padding: 0; /* Eliminar padding */
                    margin: 0; /* Eliminar margen */
                    overflow: hidden; /* Evitar desbordamiento */
                }
                .carousel-item {
                    width: 100%; /* Ocupar todo el ancho */
                }
                .carousel-item img {
                    width: 100%; /* Ancho completo */
                    height: auto; /* Altura automática para adaptación */
                    object-fit: contain; /* Adaptar imagen completa sin recortes */
                    object-position: center; /* Centrar la imagen */
                }
                .py-5 {
                    padding-top: 0 !important; /* Eliminar padding superior de newsletter */
                    margin-top: 0 !important; /* Eliminar margen superior de newsletter */
                }
                main {
                    margin-bottom: 20px !important; /* Aumentar espacio entre Product Cards y Opiniones */
                }
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.reviews-carousel').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 10000,
                    arrows: false,
                    dots: true,
                    infinite: true,
                    centerMode: false,
                    variableWidth: false,
                    speed: 500,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
@endsection