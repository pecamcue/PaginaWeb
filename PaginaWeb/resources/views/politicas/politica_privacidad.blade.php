@extends('layouts.app')
@section('title', 'Política de Privacidad | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white min-vh-100">  <!-- Fondo blanco + separación del footer -->
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Política de Privacidad</li>
        </ol>
    </nav>

    <h1 class="text-center mb-5 fw-bold text-primary display-4">
        POLÍTICA DE PRIVACIDAD
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold text-primary mb-3">1. Identidad del responsable del tratamiento</h3>
            <p class="text-muted mb-4"><strong>Responsable:</strong> Óptica y Audiología Concha Cuevas</p>
            <p class="text-muted mb-4"><strong>Domicilio Social:</strong> Avenida Seminari 4, Moncada 46113 Valencia</p>
            <p class="text-muted mb-4"><strong>Contacto:</strong> info@conchacuevas.es</p>
            <p class="text-muted mb-4"><strong>Página web:</strong> <a href="https://www.conchacuevas.es/">www.conchacuevas.es</a></p>
            <p class="text-muted mb-5"><strong>Teléfono:</strong> 96 139 26 96 / 644 100 773</p>

            <h3 class="fw-bold text-primary mb-3">2. Finalidad del tratamiento</h3>
            <p class="text-muted mb-4">
                Óptica y Audiología Concha Cuevas tratará la información facilitada por el USUARIO con distintas finalidades, dependiendo de la vía de recogida de los datos:
            </p>
            <ul class="text-muted mb-5">
                <li>Gestionar la relación contractual o comercial establecida entre Óptica y Audiología Concha Cuevas y el USUARIO.</li>
                <li>Prestar los servicios solicitados por el USUARIO.</li>
                <li>Las candidaturas en los procesos de selección de personal si el USUARIO se inscribiese en ofertas de trabajo a través de este SITIO WEB.</li>
                <li>Gestionar, administrar, prestar, ampliar y mejorar los servicios a los que el USUARIO hubiese decidido suscribirse o darse de alta.</li>
                <li>Adecuar dichos servicios para mejorar su calidad de cara al USUARIO.</li>
                <li>Diseñar nuevos servicios relacionados con los anteriores.</li>
                <li>Realizar estudios estadísticos que permitan diseñar mejoras en los servicios prestados.</li>
                <li>Enviar información requerida por el USUARIO o a la que se hubiese suscrito (p.ej. Newsletter).</li>
                <li>Enviar información sobre modificaciones en los productos o servicios contratados por el USUARIO.</li>
                <li>Enviar información sobre nuevos productos o servicios del sector óptico y audiométrico, similares a los contratados originalmente o que pudieran ser de su interés por cualquier medio, incluido el electrónico, incluso cuando finalice la relación comercial establecida entre Óptica y Audiología Concha Cuevas y el USUARIO.</li>
            </ul>
            <p class="text-muted mb-5">
                El USUARIO consiente el tratamiento de sus datos con las finalidades descritas, sin perjuicio del derecho que le asiste de revocar dicho consentimiento a través de un correo electrónico a la dirección info@conchacuevas.es, identificándose como USUARIO del SITIO WEB y concretando su solicitud o, en su caso, a través de la marcación de la casilla dispuesta al efecto en el propio formulario.
            </p>

            <h3 class="fw-bold text-primary mb-3">3. Carácter Obligatorio o Facultativo de la Información Solicitada</h3>
            <p class="text-muted mb-4">Los datos obligatorios de cada formulario serán identificados como tales en el propio formulario.</p>
            <p class="text-muted mb-5">La negativa a suministrar dicha información impedirá hacer efectivo el servicio solicitado por el USUARIO.</p>

            <h3 class="fw-bold text-primary mb-3">Plazo de Conservación</h3>
            <p class="text-muted mb-5">
                Los datos personales proporcionados se conservarán el plazo necesario para gestionar su consulta, sugerencia, queja o reclamación, así como para la prestación del servicio solicitado o el desarrollo de la relación contractual establecida ente usted y Óptica y Audiología Concha Cuevas. Finalizada la misma, se conservarán durante el plazo correspondiente para cumplir con las obligaciones legales o durante el plazo que un juez o tribunal lo pueda requerir. En el caso de suscripciones a boletines electrónicos, los datos se tratarán mientras usted no revoque el consentimiento o se oponga al tratamiento. En relación con el envío de curriculum, se tratará durante dos años salvo que usted revoque el consentimiento o se oponga al tratamiento.
            </p>

            <h3 class="fw-bold text-primary mb-3">4. Legitimación del Tratamiento</h3>
            <p class="text-muted mb-5">
                La legitimación para el tratamiento de datos se basa en la ejecución de un contrato suscrito entre usted y Óptica y Audiología Concha Cuevas para la prestación del servicio solicitado y el consentimiento otorgado a través de la cumplimentación de los formularios habilitados en la web.
            </p>

            <h3 class="fw-bold text-primary mb-3">5. Destinatarios</h3>
            <p class="text-muted mb-5">
                Los datos personales recabados a través de los diferentes formularios de contacto o a través del correo electrónico, postal o teléfono, no serán cedidos o comunicados a terceros, salvo en los supuestos necesarios para el desarrollo, control y cumplimiento de la/s finalidad/es expresada/s, en los supuestos previstos según Ley, así como en los casos específicos, de los que se informe expresamente al Usuario.
            </p>

            <h3 class="fw-bold text-primary mb-3">6. Compromisos del USUARIO</h3>
            <ul class="text-muted mb-5">
                <li>El USUARIO garantiza que es mayor de 14 años y que la información facilitada es exacta y veraz.</li>
                <li>El USUARIO se compromete a informar a Óptica y Audiología Concha Cuevas de cualquier modificación que sufra la información facilitada a través de un correo electrónico a la dirección info@conchacuevas.es , identificándose como USUARIO del SITIO WEB y concretando la información que deba ser modificada.</li>
                <li>Asimismo, el USUARIO se compromete a guardar las claves y códigos de identificación en secreto y a informar en la mayor brevedad de tiempo a Óptica y Audiología Concha Cuevas en caso de pérdida, sustracción o acceso no autorizado. En tanto no se produzca esa comunicación, Óptica y Audiología Concha Cuevas quedará eximida de toda responsabilidad que pudiera derivarse del uso indebido por terceros no autorizados de tales contraseñas y códigos identificativos.</li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">7. Datos de Terceros Facilitados por el USUARIO</h3>
            <p class="text-muted mb-4">
                En caso de que el USUARIO facilite datos personales de terceras personas con cualquier finalidad, garantiza haber informado previamente a los afectados y haber obtenido su consentimiento para la comunicación de sus datos a Óptica y Audiología Concha Cuevas.
            </p>
            <p class="text-muted mb-4">
                El USUARIO garantiza que los afectados son mayores de 14 años y que la información facilitada es exacta y veraz.
            </p>
            <p class="text-muted mb-5">
                Óptica y Audiología Concha Cuevas contrastará el consentimiento de dichos afectados a través de un primer correo electrónico con contenido no comercial en el que se solicitará la verificación del consentimiento otorgado en su nombre por el USUARIO.
            </p>
            <p class="text-muted mb-5">
                En caso de que se deriven responsabilidades por un incumplimiento de estas condiciones por parte del USUARIO, deberá responder de las consecuencias de dicho incumplimiento.
            </p>

            <h3 class="fw-bold text-primary mb-3">8. Política de Cookies</h3>
            <p class="text-muted mb-4">
                La información sobre las cookies utilizadas por Óptica y Audiología Concha Cuevas en esta página web, queda recogida en nuestra Política de Cookies.
            </p>
            <p class="text-muted mb-5">
                Puede consultar la misma para conocer la información relacionada con las utilizadas en esta página web, tanto propias como de terceros.
            </p>

            <h3 class="fw-bold text-primary mb-3">9. Derechos del USUARIO</h3>
            <p class="text-muted mb-4">
                El interesado de los datos personales, en todo caso podrá ejercitar los derechos que le asisten, de acuerdo con el RGPD (Reglamento General de Protección de Datos), y que son:
            </p>
            <ul class="text-muted mb-5">
                <li>Derecho a solicitar el acceso a los datos personales relativos al interesado.</li>
                <li>Derecho a solicitar su rectificación o supresión.</li>
                <li>Derecho a solicitar la limitación de su tratamiento.</li>
                <li>Derecho a oponerse al tratamiento.</li>
                <li>Derecho a la portabilidad de los datos.</li>
            </ul>
            <p class="text-muted mb-4">
                El USUARIO deberá especificar cuál de estos derechos solicita sea satisfecho y, a su vez, deberá acompañarse de la fotocopia del DNI o documento identificativo equivalente. En caso de que actuara mediante representante, legal o voluntario, deberá aportar también documento que acredite la representación y documento identificativo del mismo.
            </p>
            <p class="text-muted mb-4">
                El interesado podrá ejercitar tales derechos mediante solicitud acompañada de una fotocopia de su D.N.I, y en la que especificará cuál de éstos solicita sea satisfecho, remitida Avenida Seminari 4, 46113 Moncada (Valencia).
            </p>
            <p class="text-muted mb-5">
                Asimismo, en caso de considerar vulnerado su derecho a la protección de datos personales, podrá interponer una reclamación ante la Agencia Española de Protección de Datos (www.agpd.es).
            </p>
            <p class="text-muted mb-5">
                Para ejercer sus derechos, puede enviar una solicitud a Avenida Seminari 4, 46113 Moncada (Valencia) o contactar con la Agencia Española de Protección de Datos.
            </p>

            <h3 class="fw-bold text-primary mb-3">10. Medidas de Seguridad</h3>
            <p class="text-muted mb-4">
                Óptica y Audiología Concha Cuevas ha adoptado las medidas de índole técnica y organizativas necesarias que garanticen la seguridad de los datos de carácter personal y eviten su alteración, pérdida, tratamiento o acceso no autorizado, habida cuenta del estado de la tecnología, la naturaleza de los datos almacenados y los riesgos a que estén expuestos, ya provengan de la acción humana o del medio físico o natural.
            </p>
            <p class="text-muted mb-5">
                No obstante, el USUARIO debe ser consciente de que las medidas de seguridad en Internet no son inexpugnables.
            </p>
        </div>
    </div>
</div>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Título principal más grande y destacado */
    .display-4 {
        font-size: 3rem;
    }

    /* Texto más legible */
    .text-muted {
        line-height: 1.8;
    }

    h3 {
        font-size: 1.5rem;
        margin-top: 2.5rem;
    }

    /* Empuja el footer abajo */
    .min-vh-100 {
        min-height: calc(100vh - 200px);  /* Ajusta según tu header/footer */
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