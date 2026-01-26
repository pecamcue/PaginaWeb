@extends('layouts.app')
@section('title', 'Aviso Legal | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white min-vh-100">  <!-- Fondo blanco + altura mínima para separar del footer -->
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aviso Legal</li>
        </ol>
    </nav>

    <h1 class="text-center mb-5 fw-bold text-primary display-4">
        Aviso Legal
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold text-primary mb-3">1. Información Legal</h3>
            <p class="text-muted mb-4">
                <strong>www.conchacuevas.es</strong> (en adelante, el SITIO WEB) es un dominio registrado por <strong>CONCEPCIÓN CUEVAS MARTINEZ</strong> (en adelante, <<Óptica y Audiología Concha Cuevas>>), sociedad dedicada a la comercialización de productos y servicios del sector óptico y audiométrico.
            </p>
            <p class="text-muted mb-4">
                <strong>Óptica y Audiología Concha Cuevas</strong> con CIF número 73650045C, con domicilio social en Avenida Seminari 4, 46113, Moncada, y con teléfono y email de contacto: 96 139 26 96 / 644 100 773 y info@conchacuevas.es.
            </p>
            <p class="text-muted mb-5">
                <strong>Óptica y Audiología Concha Cuevas</strong> actúa como responsable de los contenidos del SITIO WEB www.conchacuevas.es y de la Política Comercial del Establecimiento.
            </p>

            <h3 class="fw-bold text-primary mb-3">2. Carácter de los Servicios</h3>
            <p class="text-muted mb-5">
                El acceso al SITIO WEB es de carácter gratuito, sin perjuicio de que la contratación de los productos o servicios a través del SITIO WEB esté sujeta a una contraprestación económica.
            </p>

            <h3 class="fw-bold text-primary mb-3">3. Responsabilidad del Usuario</h3>
            <p class="text-muted mb-4">
                El USUARIO se compromete a no utilizar el SITIO WEB ni la información ofrecida en el mismo para la realización de actividades contrarias a la Ley, la moral o el orden público y, en general, a hacer un uso conforme a las condiciones establecidas por «Óptica y Audiología Concha Cuevas».
            </p>
            <p class="text-muted mb-5">
                Las opiniones, contenidos y, en general, todas las actividades realizadas por el USUARIO, son de su exclusiva responsabilidad, sin que pueda responsabilizarse a «Óptica y Audiología Concha Cuevas» de los daños o perjuicios que pudieran derivarse de dichas actividades ajenas a su voluntad y sin que ésta tenga un conocimiento efectivo de las mismas.
            </p>

            <h3 class="fw-bold text-primary mb-3">4. Responsabilidad de «Óptica y Audiología Concha Cuevas»</h3>
            <p class="text-muted mb-4">
                «Óptica y Audiología Concha Cuevas» no será responsable de los errores en el acceso al SITIO WEB o en sus contenidos, aunque pondrá la mayor diligencia en que los mismos no se produzcan.
            </p>
            <p class="text-muted mb-5">
                «Óptica y Audiología Concha Cuevas» se reserva el derecho de suspender temporalmente, y sin necesidad de previo aviso, la accesibilidad del SITIO WEB con motivo de una eventual necesidad de efectuar operaciones de mantenimiento, reparación, actualización o mejora del mismo.
            </p>

            <h3 class="fw-bold text-primary mb-3">5. Propiedad Intelectual e Industrial</h3>
            <p class="text-muted mb-4">
                Todos los contenidos del SITIO WEB (incluyendo, sin carácter limitativo, bases de datos, imágenes, dibujos, gráficos, archivos de texto, audio, vídeo y software) son propiedad de «Óptica y Audiología Concha Cuevas» y están protegidos por las normas nacionales e internacionales de propiedad intelectual e industrial, quedando todos los derechos reservados.
            </p>
            <p class="text-muted mb-4">
                El nombre de dominio, las marcas, rótulos, signos distintivos o logos que aparecen en el SITIO WEB son titularidad de «Óptica y Audiología Concha Cuevas».
            </p>
            <p class="text-muted mb-4">
                Todos los textos, dibujos gráficos, vídeos o soportes de audio que pudieran encontrarse en este momento o en un futuro en este sitio de Internet, son propiedad de «Óptica y Audiología Concha Cuevas» y no podrán ser objeto de ulterior modificación, copia, alteración, reproducción total o parcial, adaptación o traducción por parte del USUARIO o de terceros sin la expresa autorización por parte de «Óptica y Audiología Concha Cuevas».
            </p>
            <p class="text-muted mb-5">
                El uso no autorizado de la información contenida en este SITIO WEB, así como la lesión de los derechos de propiedad intelectual o industrial dará lugar a las responsabilidades legalmente establecidas.
            </p>

            <h3 class="fw-bold text-primary mb-3">6. Hiperenlaces</h3>
            <p class="text-muted mb-4">
                El establecimiento de cualquier hiperenlace desde una página web ajena, a cualquiera de las páginas del SITIO WEB de «Óptica y Audiología Concha Cuevas» estará sometido a las siguientes condiciones:
            </p>
            <ul class="text-muted mb-5">
                <li>No se permite la reproducción ni total ni parcial de ninguno de los servicios contenidos en el SITIO WEB de «Óptica y Audiología Concha Cuevas».</li>
                <li>No se incluirá ninguna manifestación falsa, inexacta o incorrecta sobre las páginas del SITIO WEB de «Óptica y Audiología Concha Cuevas» y sus servicios.</li>
                <li>Bajo ninguna circunstancia, «Óptica y Audiología Concha Cuevas» será responsable de los contenidos, informaciones, manifestaciones, opiniones o servicios puestos a disposición del público en la página web desde la que se establezca un hiperenlace al presente SITIO WEB.</li>
                <li>Cualquier hiperenlace se efectuará a la página principal del SITIO WEB.</li>
                <li>Los hiperenlaces que se encuentran en el SITIO WEB han sido previamente consensuados con los titulares de las páginas webs enlazadas. «Óptica y Audiología Concha Cuevas» no será responsable del mal uso ni de las actividades contrarias a la ley, la moral o el orden público que realicen los usuarios en dichas páginas enlazadas.</li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">7. Vigencia de las Condiciones de Uso</h3>
            <p class="text-muted mb-5">
                Las condiciones de uso de este SITIO WEB tienen carácter indefinido. «Óptica y Audiología Concha Cuevas» se reserva en todo caso el derecho unilateral de modificar las condiciones de acceso a las mismas, así como su contenido.
            </p>

            <h3 class="fw-bold text-primary mb-3">8. Nulidad e Ineficacia de las Cláusulas</h3>
            <p class="text-muted mb-5">
                Si cualquier cláusula incluida en estas condiciones fuese declarada total o parcialmente nula o ineficaz, tal nulidad afectará tan sólo a dicha disposición o la parte de la misma que resulte nula o ineficaz, subsistiendo en todo lo demás las condiciones.
            </p>

            <h3 class="fw-bold text-primary mb-3">9. Legislación y Jurisdicción Aplicables</h3>
            <p class="text-muted mb-4">
                La prestación del servicio de este SITIO WEB y las presentes condiciones de uso se rigen por la ley española.
            </p>
            <p class="text-muted mb-5">
                Toda cuestión litigiosa que incumba a los servicios prestados a través de este SITIO WEB, será resuelta a través de los tribunales arbitrales de consumo, mediadores o semejantes a los que se encuentre adherida «Óptica y Audiología Concha Cuevas» en el momento de producirse la controversia, así como los juzgados y tribunales correspondientes de conformidad con la legislación española.
            </p>
        </div>
    </div>
</div>

<style>
    /* Fondo blanco uniforme en toda la página */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Título principal más grande y destacado */
    .display-4 {
        font-size: 3rem;
    }

    /* Texto más legible y con espacio */
    .text-muted {
        line-height: 1.8;
    }

    h3 {
        font-size: 1.5rem;
        margin-top: 2rem;
    }

    /* Empuja el footer abajo si el contenido es corto */
    .min-vh-100 {
        min-height: calc(100vh - 200px);  /* Ajusta según altura del header/footer */
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        h3 {
            font-size: 1.3rem;
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