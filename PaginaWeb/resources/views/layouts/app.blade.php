<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta etiquetas -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Óptica y Audiología Concha Cuevas'))</title>

    <meta name="description" content="Óptica y Audiología Concha Cuevas, ofreciendo servicios de calidad en el cuidado visual y auditivo.">
    <meta name="keywords" content="óptica, audiología, gafas, audífonos, salud visual, salud auditiva">
    <meta name="author" content="Pedro Campos">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/1-660ba003.ico') }}" type="image/x-icon">

    <!--     ESTILOS Y FUENTES    -->

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- AOS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/style_indice.css') }}">

    <!-- Vite (para compilar CSS y JS en Laravel) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 CSS -->
    @stack('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Incluir jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Incluir libreria stripe (pagos)-->
    <script src="https://js.stripe.com/v3/"></script>
    
     {{-- REGLA GLOBAL DE FONDO BLANCO --}}
    <style>
        html, body, #app {
            background-color: #ffffff !important;
            color: inherit;
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        /* Si alguna sección, card o contenedor tiene fondo diferente,
           se fuerza también a blanco */
        section, .section, .container, .card, .card-body,
        header, footer, main {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="min-h-screen bg-gray-100">
        
        <!--       ENCABEZADO        -->
        
        @include('partials.header')

       
        <!--       TITULAR PAGINA     -->
       
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!--    CONTENIDO PRINCIPAL   -->
     
        <main>
            @yield('content')
        </main>

     
        <!--        FOOTER           -->
     
        @include('partials.footer')
    </div>

    <!--         SCRIPTS          -->
   
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts') <!-- Para agregar scripts adicionales en vistas específicas -->

    <!-- AOS (Animate On Scroll) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Duración de la animación en milisegundos
            once: true,     // Solo anima una vez al hacer scroll
        });
    </script>
    
</body>
</html>