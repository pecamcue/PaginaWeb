<!-- Footer -->
<footer class="bg-white text-dark pt-5" style="border-top: 1px solid #e0e0e0;">
    <div class="container">
        <div class="row align-items-center social-row">
            <!-- Social Media Links -->
            <div class="col-md-6 d-flex justify-content-start mb-3 mb-md-0 social-links">
                <a href="https://www.facebook.com/conchacuevasoptica" target="_blank" class="text-primary me-3" aria-label="Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="https://www.instagram.com/conchacuevas_optica.audiologia/" target="_blank" class="text-primary me-3" aria-label="Instagram"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        
            <!-- Button Cita Previa -->
            <div class="col-md-6 d-flex justify-content-end mb-3 mb-md-0 cita-previa">
                <a href="{{ route('appointment.create') }}" class="btn btn-primary rounded-pill px-4 py-2 d-inline-flex align-items-center" aria-label="Pedir cita">
                    <i class="far fa-calendar-alt me-2"></i>
                    Pedir cita
                </a>
            </div>
        </div>

        <div class="row text-center text-md-start mt-4 footer-columns">
            <!-- Columna Sobre Nosotros -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Sobre Nosotros</h5>
                <ul class="list-unstyled">
                    <li><a class="nav-link p-0 text-dark" href="{{ route('nosotros') }}">Nuestra historia</a></li>
                    <li><a class="nav-link p-0 text-dark" href="{{ route('politicas.politica_calidad') }}">Política Calidad</a></li>
                </ul>
            </div>
        
            <!-- Columna Ayuda -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Ayuda</h5>
                <ul class="list-unstyled">
                    <li><a class="nav-link p-0 text-dark" href="{{ route('preguntas_frec') }}">Preguntas Frecuentes</a></li>
                    <li><a class="nav-link p-0 text-dark" href="{{ route('contacto') }}">Contacto</a></li>
                    <li><a class="nav-link p-0 text-dark" href="{{ route('promociones') }}">Promociones</a></li>
                </ul>
            </div>
        
            <!-- Columna Productos -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Productos</h5>
                <ul class="list-unstyled">
                    <li><a href="{{config('app.front_url')}}/productos/categoria/lentes-de-contacto" class="nav-link p-0 text-dark">Lentillas</a></li>
                    <li><a href="{{config('app.front_url')}}/productos/categoria/gafas-de-sol" class="nav-link p-0 text-dark">Gafas de sol</a></li>
                    <li><a href="{{config('app.front_url')}}/productos/categoria/gafas-graduadas" class="nav-link p-0 text-dark">Gafas graduadas</a></li>
                    <li><a href="{{config('app.front_url')}}/productos/categoria/liquidos" class="nav-link p-0 text-dark">Líquidos</a></li>
                    <li><a href="{{config('app.front_url')}}/productos/categoria/pilas" class="nav-link p-0 text-dark">Pilas</a></li>
                    <li><a href="{{config('app.front_url')}}/productos/categoria/accesorios" class="nav-link p-0 text-dark">Accesorios</a></li>
                </ul>
            </div>
        </div>

        <div class="row align-items-center mt-4 pb-4 legal-row">
            <!-- Links Legales -->
            <div class="col-md-6 text-center text-md-start legal-text">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('politicas.aviso_legal') }}" class="text-dark text-decoration-none">Aviso legal</a></li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item"><a href="{{ route('politicas.politica_privacidad') }}" class="text-dark text-decoration-none">Política de privacidad</a></li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item"><a href="{{ route('politicas.terminos_condiciones') }}" class="text-dark text-decoration-none">Términos y condiciones</a></li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item"><a href="{{ route('politicas.politica_cookies') }}" class="text-dark text-decoration-none">Política de cookies</a></li>
                </ul>
            </div>
        
            <!-- Copyright -->
            <div class="col-md-6 text-center text-md-end copyright-text">
                <p class="mb-0">&copy; {{ date('Y') }} Óptica y Audiología Concha Cuevas</p>
            </div>
        </div>
    </div>

    <!-- Botón de flecha para subir al inicio -->
    <button id="scrollToTopBtn" class="btn btn-primary" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; padding: 10px 15px;">
        <i class="fas fa-chevron-up" style="font-size: 20px;"></i>
    </button>
</footer>

<!-- Script del Chat -->
<script src="//code.tidio.co/zzhkhpj09oakawmezlx7zexduln07dc0.js" async></script>

<!-- Script para el botón de subir -->
<script>
    document.getElementById('scrollToTopBtn').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

<style>
    /* Footer general: fondo blanco uniforme con línea superior sutil */
    footer {
        background-color: white !important;
    }

    footer .nav-link {
        color: var(--text-dark) !important;
        padding: 0.2rem 0 !important;
    }

    footer .nav-link:hover {
        color: var(--primary-color) !important;
    }

    /* Responsive: columnas apiladas en móvil */
    @media (max-width: 1056px) {
        .footer-columns {
            flex-direction: column !important;
        }

        .legal-row {
            margin-bottom: 100px;
        }

        #scrollToTopBtn {
            display: none;
        }

        #tidio-chat iframe {
            bottom: 40px !important;
            right: -10px !important;
        }

        #tidio-chat.tidio-chat-opened iframe {
            left: 50% !important;
            transform: translateX(-50%) !important;
            right: auto !important;
            width: 90vw !important;
            max-width: 400px !important;
            height: 500px !important;
            bottom: 100px !important;
        }
    }
</style>