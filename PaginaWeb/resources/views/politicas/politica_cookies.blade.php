@extends('layouts.app')
@section('title', 'Política de Cookies | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white min-vh-100">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Política de Cookies</li>
        </ol>
    </nav>

    <h1 class="text-center mb-5 fw-bold text-primary display-4">
        POLÍTICA DE COOKIES
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <p class="text-muted mb-4">
                La página web <strong>www.conchacuevas.es</strong> utiliza cookies propias y de terceros para mejorar la experiencia del usuario, analizar el uso del sitio y ofrecer publicidad personalizada.
            </p>
            <p class="text-muted mb-5">
                A continuación, detallamos el tipo de cookies que utilizamos y cómo gestionarlas.
            </p>

            <h3 class="fw-bold text-primary mb-3">1. ¿Qué son las cookies?</h3>
            <p class="text-muted mb-5">
                Las cookies son pequeños archivos de texto que se almacenan en el dispositivo del usuario (ordenador, tablet, smartphone) cuando accede a determinadas páginas web. Las cookies permiten, entre otras cosas, recordar la actividad previa del usuario, personalizar la experiencia y ofrecer anuncios relevantes según sus intereses.
            </p>

            <h3 class="fw-bold text-primary mb-3">2. Uso de cookies con consentimiento del usuario</h3>
            <p class="text-muted mb-4">
                <strong>www.conchacuevas.es</strong> informa, de manera previa a su utilización, de la posibilidad de uso de cookies de preferencias, analíticas y de publicidad, que deben ser autorizadas por el usuario, a través de su consentimiento, a través de nuestra página web antes de su utilización o instalación en el dispositivo del usuario.
            </p>
            <p class="text-muted mb-5">
                El configurador de cookies permite que el usuario de nuestra página web pueda "Aceptar todas las Cookies", "Configurarlas" (aceptando y/o rechazando de manera automática todas o bien personalizando la aceptación y/o rechazo de manera individual) o "Rechazar todas las cookies", tal y como ha establecido la Agencia Española de Protección de Datos en su Guía para el Uso de Cookies de Julio de 2023.
            </p>

            <h3 class="fw-bold text-primary mb-3">3. Tipos de Cookies</h3>
            <p class="text-muted mb-4">
                El usuario que navega por la página web <strong>www.conchacuevas.es</strong> puede encontrar cookies insertadas directamente:
            </p>
            <ul class="text-muted mb-5">
                <li><strong>Por parte de ConchaCuevas S.L.</strong> (cookies propias)</li>
                <li><strong>Cookies insertadas por Terceras Entidades</strong> (cookies de terceros).</li>
            </ul>
            <p class="text-muted mb-5">
                Las cookies pueden tener una duración o vigencia variable:
            </p>
            <ul class="text-muted mb-5">
                <li><strong>Cookies de sesión:</strong> Son aquellas que se diseñan para recabar y almacenar datos mientras el usuario accede a nuestra página web. Estas cookies no quedan almacenadas en el dispositivo del usuario al cerrar el navegador o la sesión.</li>
                <li><strong>Cookies persistentes:</strong> Son aquellas en las que los datos siguen almacenados en el dispositivo del usuario cuando abandona la página web <strong>www.conchacuevas.es</strong>. Pueden ser accedidas y tratadas durante un periodo definido, que puede ir desde unos minutos hasta varios años.</li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">4. Finalidades de las Cookies</h3>
            <p class="text-muted mb-4">
                Las cookies pueden ser utilizadas para distintas finalidades. A continuación, te explicamos las finalidades más comunes:
            </p>
            <ul class="text-muted mb-5">
                <li><strong>Cookies técnicas:</strong> Permiten al usuario la navegación a través de la página web y la utilización de las diferentes opciones o servicios que en ella existen. Incluyen aquellas que se utilizan para controlar el tráfico y la comunicación de datos, identificar la sesión, acceder a partes de acceso restringido, recordar los elementos que integran un pedido, realizar el proceso de compra de un pedido, gestionar el pago, controlar el fraude vinculado a la seguridad del servicio, y otros elementos necesarios para el funcionamiento básico del sitio.</li>
                <li><strong>Cookies de preferencia o personalización:</strong> Permiten recordar información para que el usuario acceda al servicio con características que pueden diferenciar su experiencia, como el idioma o el número de resultados a mostrar en una búsqueda, entre otros.</li>
                <li><strong>Cookies de análisis o medición:</strong> Permiten el seguimiento y análisis del comportamiento de los usuarios de la página web. Sirven para medir la efectividad y eficacia de los anuncios, el rendimiento del contenido o el impacto de las campañas de marketing, y para introducir mejoras en función del análisis de los datos de uso.</li>
                <li><strong>Cookies de publicidad comportamental:</strong> Estas cookies almacenan información sobre el comportamiento de los usuarios, obtenida mediante la observación continuada de sus hábitos de navegación, lo que permite desarrollar un perfil específico para mostrar publicidad personalizada en función de los intereses del usuario.</li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">5. Concretas finalidades para las cuales solicitamos el consentimiento de las cookies:</h3>
            <ul class="text-muted mb-5">
                <li><strong>Medir el rendimiento del contenido:</strong> Si el usuario presta su consentimiento, <strong>Óptica y Audiología Concha Cuevas</strong> y otros terceros podrán examinar la efectividad y eficacia del contenido con el que interactúa el usuario.</li>
                <li><strong>Medir el rendimiento de los anuncios:</strong> Si el usuario lo autoriza, <strong>Óptica y Audiología Concha Cuevas.</strong> y otros terceros podrán analizar la efectividad y eficacia de los anuncios que se le muestran al usuario.</li>
                <li><strong>Realizar estudios de mercado:</strong> Si el usuario consiente, <strong>Óptica y Audiología Concha Cuevas</strong> y otros terceros podrán obtener más información sobre el público que visita el sitio web y que visualiza los anuncios mostrados.</li>
                <li><strong>Desarrollar y mejorar productos:</strong> Si el usuario presta su consentimiento, la información recopilada de su navegación podrá ser utilizada para mejorar productos existentes o crear nuevos modelos analíticos mediante machine learning.</li>
                <li><strong>Publicidad personalizada:</strong> Si el usuario autoriza, <strong>Óptica y Audiología Concha Cuevas</strong> podrá elaborar perfiles publicitarios personalizados basados en el comportamiento de navegación y otros datos, para mostrar anuncios específicos basados en esos perfiles.</li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">6. Almacenamiento y acceso a información de geolocalización con fines publicitarios</h3>
            <p class="text-muted mb-5">
                En caso de que el usuario lo consienta, nuestros socios de geomarketing podrán recabar datos agregados y anónimos de geolocalización, con el fin de realizar estudios de mercado que ayuden a comprender mejor el rendimiento de tiendas y competidores.
            </p>

            <h3 class="fw-bold text-primary mb-3">7. Lista de Cookies</h3>
            <p class="text-muted mb-4">
                Una cookie es un fragmento pequeño de datos (archivos de texto) que un sitio web, cuando es visitado por un usuario, le pregunta a su navegador para almacenarse en su dispositivo. Estas cookies sirven para recordar información sobre el usuario, como sus preferencias de idioma o información de inicio de sesión.
            </p>
            <p class="text-muted mb-4">
                En <strong>Óptica y Audiología Concha Cuevas</strong> usamos cookies de <strong>primeras partes</strong> y <strong>terceras partes</strong> para propósitos de análisis, marketing y personalización. Las cookies dirigidas por terceros pueden ser utilizadas para crear un perfil de sus intereses y mostrarle anuncios relevantes en otros sitios.
            </p>

            <h4 class="fw-bold text-primary mb-3">7.1.- Cookies dirigidas</h4>
            <p class="text-muted mb-5">
                Estas cookies pueden estar distribuidas en todo el sitio web y colocadas por nuestros socios publicitarios. Estos socios las utilizan para crear un perfil de los intereses del usuario y mostrar anuncios relevantes basados en dicho perfil. No almacenan información personal directamente, sino que dependen de la identificación única del navegador y dispositivo utilizado para acceder a Internet. Si no permite estas cookies, verá menos publicidad dirigida.
            </p>

            <h4 class="fw-bold text-primary mb-3">7.2.- Cookies de funcionalidad</h4>
            <p class="text-muted mb-5">
                Estas cookies permiten que el sitio ofrezca una mejor funcionalidad y personalización. Pueden ser establecidas por nosotros o por terceras partes cuyos servicios hemos agregado a nuestras páginas. Si no permite estas cookies algunos de nuestros servicios no funcionarán correctamente.
            </p>

            <h4 class="fw-bold text-primary mb-3">7.3.- Cookies de rendimiento</h4>
            <p class="text-muted mb-5">
                Estas cookies nos permiten contar las visitas y fuentes de circulación para poder medir y mejorar el desempeño de nuestro sitio. Nos ayudan a saber qué páginas son las más o menos populares, y ver cuántas personas visitan el sitio. Toda la información que recogen estas cookies es agregada y, por lo tanto, anónima. Si no permite estas cookies no sabremos cuándo visitó nuestro sitio, y por lo tanto no podremos saber cuándo lo visitó.
            </p>

            <h4 class="fw-bold text-primary mb-3">7.4.- Cookies estrictamente necesarias</h4>
            <p class="text-muted mb-5">
                Estas cookies son necesarias para que el sitio web funcione y no se pueden desactivar en nuestros sistemas. Usualmente están configuradas para responder a acciones hechas por usted para recibir servicios, tales como ajustar sus preferencias de privacidad, iniciar sesión en el sitio, o llenar formularios. Usted puede configurar su navegador para bloquear o alertar la presencia de estas cookies, pero algunas partes del sitio web no funcionarán. Estas cookies no guardan ninguna información personal identificable.
            </p>

            <h3 class="fw-bold text-primary mb-3">8. Almacenar la información en un dispositivo y/o acceder a ella</h3>
            <p class="text-muted mb-5">
                Las cookies, los identificadores de dispositivos o los identificadores online de similares características (p. ej., los identificadores basados en inicio de sesión, los identificadores asignados aleatoriamente, los identificadores basados en la red), junto con otra información (p. ej., la información y el tipo del navegador, el idioma, el tamaño de la pantalla, las tecnologías compatibles, etc.), pueden almacenarse o leerse en tu dispositivo a fin de reconocerlo siempre que se conecte a una aplicación o a una página web para una o varias de las finalidades que se recogen en el presente texto.
            </p>

            <h3 class="fw-bold text-primary mb-3">9. Publicidad y contenido personalizados, medición de publicidad y contenido, investigación de audiencia y desarrollo de servicios</h3>
            <p class="text-muted mb-5">
                La publicidad y el contenido pueden personalizarse basándose en tu perfil. Tu actividad en este servicio puede utilizarse para crear o mejorar un perfil sobre tu persona para recibir publicidad o contenido personalizados. El rendimiento de la publicidad y del contenido puede medirse. Los informes pueden generarse en función de tu actividad y la de otros usuarios. Tu actividad en este servicio puede ayudar a desarrollar y mejorar productos y servicios.
            </p>

            <h3 class="fw-bold text-primary mb-3">10. Uso de datos limitados para seleccionar anuncios básicos</h3>
            <p class="text-muted mb-5">
                La publicidad que se presenta en este servicio puede basarse en datos limitados, tales como la página web o la aplicación que esté utilizando, tu ubicación no precisa, el tipo de dispositivo o el contenido con el que estás interactuando (o con el que has interactuado) (por ejemplo, para limitar el número de veces que se presenta un anuncio concreto).
            </p>

            <h3 class="fw-bold text-primary mb-3">11. Crear perfiles para publicidad personalizada</h3>
            <p class="text-muted mb-5">
                La información sobre tu actividad en este servicio (por ejemplo, los formularios que rellenes, el contenido que estás consumiendo) puede almacenarse y combinarse con otra información que se tenga sobre tu persona o sobre usuarios similares (por ejemplo, información sobre tu actividad previa en este servicio y en otras páginas web o aplicaciones). Posteriormente, esto se utilizará para crear o mejorar un perfil sobre tu persona (que podría incluir posibles intereses y aspectos personales). Tu perfil puede utilizarse (también en un momento posterior) para mostrarte publicidad que pueda parecerte más relevante en función de tus posibles intereses, ya sea por parte nuestra o de terceros.
            </p>

            <h3 class="fw-bold text-primary mb-3">12. Utilizar perfiles para seleccionar la publicidad personalizada</h3>
            <p class="text-muted mb-5">
                La publicidad presentada en este servicio puede basarse en tus perfiles publicitarios, que pueden reflejar tu actividad en este servicio, en otras páginas web o aplicaciones (tales como los formularios con los que interactúas o el contenido que visualizas), tus posibles intereses y los aspectos personales.
            </p>

            <h3 class="fw-bold text-primary mb-3">13. Crear un perfil para personalizar el contenido</h3>
            <p class="text-muted mb-5">
                La información sobre tu actividad en este servicio (por ejemplo, los formularios con los que interactúas o el contenido no publicitario que visualizas) puede almacenarse y combinarse con otra información relativa a tu persona (por ejemplo, tu actividad pasada en este servicio o en otras páginas web o aplicaciones) o sobre otros usuarios de similares características. Posteriormente, esto se utiliza para la creación o la mejora de tu perfil (que podría incluir, por ejemplo, tus posibles intereses y aspectos personales). Tu perfil se puede utilizar (también en el futuro) para presentar aquel contenido que parezca más relevante en función de tus posibles intereses; por ejemplo, adaptando el orden en el que se muestra el contenido para que sea aún más sencillo encontrar el que coincida con tus intereses.
            </p>

            <h3 class="fw-bold text-primary mb-3">14. Uso de perfiles para la selección de contenido personalizado</h3>
            <p class="text-muted mb-5">
                El contenido que se te presenta en este servicio puede basarse en un perfil de personalización de contenido, lo que puede reflejar tu actividad en este u otros servicios (por ejemplo, los formularios que envías o el contenido que visualizas), tus posibles intereses y aspectos personales. Un ejemplo de lo anterior sería la adaptación del orden en el que se te presenta el contenido, para que así te resulte más sencillo encontrar el contenido (no publicitario) que coincida con tus intereses.
            </p>

            <h3 class="fw-bold text-primary mb-3">15. Medir el rendimiento de la publicidad</h3>
            <p class="text-muted mb-5">
                La información sobre qué publicidad se te presenta y sobre la forma en que interactúas con ella puede utilizarse para determinar lo bien que ha funcionado un anuncio en tu caso o en el de otros usuarios y si se han alcanzado los objetivos publicitarios. Por ejemplo, si has visualizado un anuncio, si has hecho clic sobre el mismo, si eso te ha llevado posteriormente a comprar un producto o a visitar una página web, etc. Esto resulta muy útil para comprender la relevancia de las campañas publicitarias.
            </p>

            <h3 class="fw-bold text-primary mb-3">16. Medir el rendimiento del contenido</h3>
            <p class="text-muted mb-5">
                La información sobre qué contenido se te presenta y sobre la forma en que interactúas con él puede utilizarse para determinar, por ejemplo, si el contenido (no publicitario) ha llegado a su público previsto y ha coincidido con sus intereses. Por ejemplo, si has leído un artículo, si has visualizado un vídeo, si has escuchado un “pódcast” o si has consultado la descripción de un producto, cuánto tiempo has pasado en esos servicios y en las páginas web que has visitado, etc. Esto resulta muy útil para comprender la relevancia del contenido (no publicitario) que se te muestra.
            </p>

            <h3 class="fw-bold text-primary mb-3">17. Comprender al público a través de estadísticas o a través de la combinación de datos procedentes de diferentes fuentes</h3>
            <p class="text-muted mb-5">
                Se pueden generar informes basados en la combinación de conjuntos de datos (como perfiles de usuario, estadísticas, estudios de mercado, datos analíticos) respecto a tus interacciones y las de otros usuarios con el contenido publicitario (o no publicitario) para identificar las características comunes (por ejemplo, para determinar qué público objetivo es más receptivo a una campaña publicitaria o a ciertos contenidos).
            </p>

            <h3 class="fw-bold text-primary mb-3">18. Desarrollo y mejora de los servicios</h3>
            <p class="text-muted mb-5">
                La información sobre tu actividad en este servicio, como tu interacción con los anuncios o con el contenido, puede resultar muy útil para mejorar productos y servicios, así como para crear otros nuevos en base a las interacciones de los usuarios, el tipo de audiencia, etc. Esta finalidad específica no incluye el desarrollo ni la mejora de los perfiles de usuario y de identificadores.
            </p>

            <h3 class="fw-bold text-primary mb-3">19. Uso de datos limitados con el objetivo de seleccionar el contenido</h3>
            <p class="text-muted mb-5">
                El contenido que se presenta en este servicio puede basarse en datos limitados, como por ejemplo la página web o la aplicación que esté utilizando, tu ubicación no precisa, el tipo de dispositivo o el contenido con el que estás interactuando (o con el que has interactuado) (por ejemplo, para limitar el número de veces que se te presenta un vídeo o un artículo en concreto).
            </p>

            <h3 class="fw-bold text-primary mb-3">20. Utilizar datos de localización geográfica precisa</h3>
            <p class="text-muted mb-5">
                Al contar con tu aprobación, tu ubicación exacta (dentro de un radio inferior a 500 metros) podrá utilizarse para apoyar las finalidades que se explican en este documento.
            </p>

            <h3 class="fw-bold text-primary mb-3">21. Analizar activamente las características del dispositivo para su identificación</h3>
            <p class="text-muted mb-5">
                Con tu aceptación, se pueden solicitar y utilizar ciertas características específicas de tu dispositivo para distinguirlo de otros (por ejemplo, las fuentes o complementos instalados y la resolución de su pantalla) en apoyo de las finalidades que se explican en este documento.
            </p>

            <h3 class="fw-bold text-primary mb-3">22. Garantizar la seguridad, evitar y detectar fraudes, y eliminar fallos</h3>
            <p class="text-muted mb-5">
                Tus datos pueden utilizarse para supervisar y evitar las actividades inusuales y potencialmente fraudulentas (por ejemplo, en relación con la publicidad, o con actividad realizada por bots), así como para asegurar que los sistemas y los procesos funcionen de forma correcta y segura. Asimismo, se puede utilizar para corregir cualquier problema que tú, el editor/medio de comunicación o el anunciante podáis encontraros a la hora de la entrega del contenido y los anuncios, así como en tu interacción con ellos.
            </p>

            <h3 class="fw-bold text-primary mb-3">23. Ofrecer y presentar publicidad y contenido</h3>
            <p class="text-muted mb-5">
                Cierta información (como una dirección IP o las capacidades del dispositivo) se utiliza para garantizar la compatibilidad técnica del contenido o de la publicidad, así como para facilitar la transmisión del contenido o del anuncio a tu dispositivo.
            </p>
            <p class="text-muted mb-5">
                La información (como una dirección IP o las capacidades del dispositivo) se utiliza para garantizar la compatibilidad técnica del contenido o de la publicidad, así como para facilitar la transmisión del contenido o del anuncio a tu dispositivo.
            </p>

            <h3 class="fw-bold text-primary mb-3">24. Cotejo y combinación de datos procedentes de otras fuentes de información</h3>
            <p class="text-muted mb-5">
                La información en relación con tu actividad en este servicio puede cotejarse y combinarse con otra información (como la obtenida de otros sitios web, aplicaciones o servicios) a fin de crear un perfil integral de tu persona.
            </p>

            <h3 class="fw-bold text-primary mb-3">25. Información relativa al tratamiento de datos personales realizado a través de las cookies</h3>

            <h3 class="fw-bold text-primary mb-3">26. Responsable</h3>
            <p class="text-muted mb-5"><strong>Óptica y Audiología Concha Cuevas</strong></p>

            <h3 class="fw-bold text-primary mb-3">27. Información captada</h3>
            <p class="text-muted mb-5">
                Dirección IP, fecha y hora de conexión; dispositivo, navegador, preferencias, personalización.
            </p>

            <h3 class="fw-bold text-primary mb-3">28. Finalidad</h3>
            <p class="text-muted mb-4">
                Identifica al usuario en la sesión del servidor, identifica al usuario permitiéndole la navegación por la página.
            </p>
            <p class="text-muted mb-5">
                Con consentimiento del usuario, la información será tratada para generación de perfil del usuario en base a su navegación a fines publicitarios, uso de herramientas de análisis y analítica web, personalización de la página.
            </p>

            <h3 class="fw-bold text-primary mb-3">29. Base legitimadora</h3>
            <p class="text-muted mb-4">
                Interés legítimo del responsable para cookies funcionales y/o técnicas.
            </p>
            <p class="text-muted mb-5">
                Consentimiento del interesado para cookies analíticas, personalización y publicitarias.
            </p>

            <h3 class="fw-bold text-primary mb-3">30. Plazo de retención</h3>
            <p class="text-muted mb-5">
                Los plazos de conservación de las cookies varían en cuanto a su finalidad y uso. En todo caso, el usuario puede eliminarlas de su dispositivo en cualquier momento.
            </p>

            <h3 class="fw-bold text-primary mb-3">31. Destinatarios de los datos</h3>
            <p class="text-muted mb-5">
                La información recabada en la configuración de consentimientos, será remitida a través de API de IAB Europe a terceras partes adheridas a dicho sistema.
            </p>

            <h3 class="fw-bold text-primary mb-3">32. Transferencias Internacionales de Datos</h3>
            <p class="text-muted mb-4">
                Al utilizar herramientas de Google Analytics (herramienta de analítica web) que permite Óptica y Audiología Concha Cuevas saber los hábitos de navegación de los usuarios en su sitio web. Óptica y Audiología Concha Cuevas puede consultar varios informes en los que se describe cómo interactúan los usuarios que visitan su sitio web con el propósito de mejorarlos. Google Analytics informa de las tendencias del sitio sin identificar a sus usuarios.
            </p>
            <p class="text-muted mb-5">
                Estas cookies de terceros utilizadas pertenecen a Google Analytics, situado en Estados Unidos, fuera del Espacio Económico Europeo.
            </p>

            <h3 class="fw-bold text-primary mb-3">33. Derechos</h3>
            <p class="text-muted mb-4">
                Puede el usuario solicitar el ejercicio de sus derechos de acceso, rectificación, supresión, oposición, limitación del tratamiento y portabilidad, cuando correspondan, así como revocar su consentimiento, respecto del tratamiento del que es responsable Óptica y Audiología Concha Cuevas mediante escrito dirigido a la dirección <strong>Avda. Seminari 4 - Moncada</strong>, o bien a la dirección de nuestro Delegado de Protección de Datos (DPD): <a href="mailto:info@conchacuevas.es">info@conchacuevas.es</a>.
            </p>
            <p class="text-muted mb-5">
                Asimismo, el usuario tiene derecho a presentar una reclamación ante una autoridad de control competente. En España, la Autoridad Competente es la Agencia Española de Protección de Datos, accesible desde <a href="https://www.aepd.es/" target="_blank">https://www.aepd.es/</a>.
            </p>

            <h3 class="fw-bold text-primary mb-3">34. Cómo gestionar las cookies</h3>
            <p class="text-muted mb-4">
                Puede desactivar las cookies de preferencias, de análisis y de publicidad comportamental sin que afecte al funcionamiento del sitio web; sin embargo, la información captada por estas cookies sobre el uso de nuestra web y sobre el éxito de los anuncios mostrados en ella permite mejorar nuestros servicios y obtener ingresos que nos permiten ofrecerle de forma gratuita muchos contenidos.
            </p>
            <p class="text-muted mb-4">
                Además, en cualquier momento el usuario puede bloquear las Cookies a través de las herramientas de configuración del navegador, o bien, puede configurar su navegador para que le avise cuando un Servidor Web quiera guardar una Cookie.
            </p>
            <ul class="text-muted mb-5">
                <li><strong>Microsoft Internet Explorer:</strong> En el menú Herramientas > Opciones de Internet > Privacidad > Configuración. <a href="http://windows.microsoft.com/es-es/" target="_blank">Más información</a></li>
                <li><strong>Firefox:</strong> En el menú Herramientas > Opciones > Privacidad > Cookies. <a href="http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-Cookies-que-los-sitios-we" target="_blank">Más información</a></li>
                <li><strong>Chrome:</strong> En la sección de Opciones > Opciones avanzadas > Privacidad. <a href="https://support.google.com/accounts/answer/61416?hl=es" target="_blank">Más información</a></li>
                <li><strong>Opera:</strong> En la opción de Seguridad y Privacidad, podrá configurar el navegador. <a href="http://help.opera.com/Windows/11.50/es-ES/cookies.html" target="_blank">Más información</a></li>
                <li><strong>Safari:</strong> En el menú Preferencias/Privacidad. <a href="http://support.apple.com/kb/HT1677?viewlocale=es_ES" target="_blank">Más información</a></li>
            </ul>

            <h3 class="fw-bold text-primary mb-3">35. Fecha de Vigencia de la Política:</h3>
            <p class="text-muted mb-5">
                La presente política fue modificada por última vez el <strong>03 de octubre de 2023</strong>, y podrá ser objeto de ulteriores modificaciones cuando así lo exija la legislación vigente en cada momento, o cuando hubiera alguna variación en el uso de cookies que se utilizan en el sitio, en cuyo caso y si fuera necesario, volveremos a solicitarle consentimiento para su uso.
            </p>
            <p class="text-muted mb-5">
                Con el objetivo de que esté informado en todo momento sobre las cookies que utilizamos y sus finalidades, le recomendamos que acceda al contenido de esta política cuando visite nuestra página web.
            </p>
        </div>
    </div>
</div>

<style>
    /* Fondo blanco uniforme */
    .bg-white {
        background-color: #ffffff !important;
    }

    /* Título principal más grande */
    .display-4 {
        font-size: 3rem;
    }

    /* Texto legible */
    .text-muted {
        line-height: 1.8;
    }

    h3 {
        font-size: 1.5rem;
        margin-top: 2.5rem;
    }

    /* Separación del footer */
    .min-vh-100 {
        min-height: calc(100vh - 200px);
    }

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