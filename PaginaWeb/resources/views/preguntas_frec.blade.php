@extends('layouts.app')
@section('title', 'Preguntas Frecuentes | Óptica Concha Cuevas')
@section('content')
<div class="container py-5 bg-white min-vh-100">
    <!-- Miga de Pan -->
    <nav aria-label="breadcrumb" class="mb-5" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" style="color: #2CA1B5">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preguntas Frecuentes</li>
        </ol>
    </nav>

    <h1 class="text-center mb-5 fw-bold text-primary display-4">
        Preguntas Frecuentes
    </h1>

    <!-- Pedidos y Compras -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Pedidos y Compras</h2>
            <div class="accordion" id="faqAccordionPedidos">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedido1">
                            ¿Cómo realizo un pedido?
                        </button>
                    </h2>
                    <div id="collapsePedido1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Para realizar un pedido, navega por nuestra tienda online, selecciona los productos que deseas y agrégalos al carrito. Luego, procede al pago ingresando tus datos y seleccionando el método de pago preferido.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedido2">
                            ¿Puedo modificar o cancelar mi pedido después de realizarlo?
                        </button>
                    </h2>
                    <div id="collapsePedido2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Una vez confirmado el pedido, no es posible modificarlo. Sin embargo, puedes cancelarlo dentro de las primeras 24 horas contactando con nuestro servicio de atención al cliente.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedido3">
                            ¿Qué hago si no recibo el correo de confirmación de mi pedido?
                        </button>
                    </h2>
                    <div id="collapsePedido3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Si no recibes el correo de confirmación en unos minutos, revisa tu carpeta de spam. Si aún no lo encuentras, contáctanos para verificar el estado de tu pedido.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedido4">
                            ¿Puedo hacer un pedido sin registrarme en la web?
                        </button>
                    </h2>
                    <div id="collapsePedido4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            No, actualmente debes registrarte, además te permite hacer un seguimiento más fácil de tus pedidos y acceder a promociones exclusivas.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedido5">
                            ¿Cómo puedo aplicar un código de descuento?
                        </button>
                    </h2>
                    <div id="collapsePedido5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            En la página de pago, encontrarás un campo para introducir tu código de descuento. Una vez ingresado, el descuento se aplicará automáticamente al total de tu compra.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Envíos y Entrega -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Envíos y Entrega</h2>
            <div class="accordion" id="faqAccordionEnvios">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnvio1">
                            ¿Cuáles son los métodos de envío disponibles?
                        </button>
                    </h2>
                    <div id="collapseEnvio1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Ofrecemos envíos estándar y exprés a nivel nacional. También tenemos la opción de recogida en tienda sin costo adicional.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnvio2">
                            ¿Cuánto tarda en llegar mi pedido?
                        </button>
                    </h2>
                    <div id="collapseEnvio2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            El tiempo de entrega varía según el método de envío seleccionado. El envío estándar suele tardar entre 3 y 5 días hábiles, mientras que el exprés llega en 24-48 horas.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnvio3">
                            ¿Cómo puedo rastrear mi pedido?
                        </button>
                    </h2>
                    <div id="collapseEnvio3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Una vez enviado tu pedido, recibirás un correo con un enlace para rastrear tu paquete en tiempo real.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnvio4">
                            ¿Qué sucede si no estoy en casa cuando intentan entregar mi pedido?
                        </button>
                    </h2>
                    <div id="collapseEnvio4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Si no estás en casa, la empresa de mensajería intentará la entrega en otro momento o dejará un aviso con instrucciones para coordinar una nueva entrega o recogerlo en una oficina cercana.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnvio5">
                            ¿Realizan envíos internacionales?
                        </button>
                    </h2>
                    <div id="collapseEnvio5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Actualmente solo realizamos envíos dentro del país. Esperamos ampliar nuestra cobertura internacional en el futuro.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pagos y Facturación -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Pagos y Facturación</h2>
            <div class="accordion" id="faqAccordionPagos">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePago1">
                            ¿Qué métodos de pago aceptan?
                        </button>
                    </h2>
                    <div id="collapsePago1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Aceptamos pagos con tarjeta de crédito, débito, PayPal y transferencia bancaria.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePago2">
                            ¿Es seguro comprar en su tienda online?
                        </button>
                    </h2>
                    <div id="collapsePago2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Sí, utilizamos protocolos de seguridad avanzados para garantizar que tu información esté protegida.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePago3">
                            ¿Puedo pagar contra reembolso?
                        </button>
                    </h2>
                    <div id="collapsePago3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Actualmente no ofrecemos pago contra reembolso. Recomendamos utilizar nuestras opciones de pago seguras disponibles.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePago4">
                            ¿Cómo puedo solicitar una factura?
                        </button>
                    </h2>
                    <div id="collapsePago4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes solicitar tu factura durante el proceso de compra o contactando con nuestro servicio de atención al cliente después de realizar el pedido.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePago5">
                            ¿Por qué ha sido rechazado mi pago?
                        </button>
                    </h2>
                    <div id="collapsePago5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Tu pago puede haber sido rechazado por varias razones, como fondos insuficientes, datos incorrectos o restricciones del banco emisor. Te recomendamos contactar con tu banco para más información.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cambios y Devoluciones -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Cambios y Devoluciones</h2>
            <div class="accordion" id="faqAccordionDevoluciones">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevolucion1">
                            ¿Cuál es su política de devoluciones?
                        </button>
                    </h2>
                    <div id="collapseDevolucion1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Aceptamos devoluciones dentro de los 7 días posteriores a la compra, siempre que el producto esté en su estado original y con el empaque intacto.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevolucion2">
                            ¿Cómo puedo devolver un producto?
                        </button>
                    </h2>
                    <div id="collapseDevolucion2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Para devolver un producto, contáctanos a través de nuestro servicio de atención al cliente y te proporcionaremos las instrucciones para el envío.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevolucion3">
                            ¿Cuánto tiempo tengo para realizar una devolución?
                        </button>
                    </h2>
                    <div id="collapseDevolucion3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Dispones de 10 días naturales desde la fecha de compra para solicitar una devolución.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevolucion4">
                            ¿Cuánto tiempo tardan en procesar un reembolso?
                        </button>
                    </h2>
                    <div id="collapseDevolucion4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Los reembolsos se procesan en un plazo de 5 a 10 días hábiles después de recibir el producto devuelto y verificar su estado.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevolucion5">
                            ¿Puedo cambiar un producto por otro?
                        </button>
                    </h2>
                    <div id="collapseDevolucion5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Sí, puedes cambiar un producto por otro del mismo valor o superior dentro de los 7 días posteriores a la compra. Contáctanos para gestionar el cambio.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Garantía y Soporte -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Garantía y Soporte</h2>
            <div class="accordion" id="faqAccordionGarantia">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGarantia1">
                            ¿Los productos tienen garantía?
                        </button>
                    </h2>
                    <div id="collapseGarantia1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Sí, todos nuestros productos cuentan con una garantía de 2 años contra defectos de fabricación.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGarantia2">
                            ¿Qué debo hacer si mi producto llega defectuoso o dañado?
                        </button>
                    </h2>
                    <div id="collapseGarantia2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Si recibes un producto defectuoso o dañado, contáctanos de inmediato con fotos del problema y te indicaremos cómo proceder para su reemplazo o reembolso.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGarantia3">
                            ¿Cómo puedo contactar con atención al cliente?
                        </button>
                    </h2>
                    <div id="collapseGarantia3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes contactar con nuestro equipo de atención al cliente a través de nuestro formulario de contacto en la web, por correo electrónico o llamándonos al número indicado en la sección de contacto.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGarantia4">
                            ¿Tienen tienda física donde pueda ver los productos?
                        </button>
                    </h2>
                    <div id="collapseGarantia4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Sí, contamos con una tienda física donde puedes ver y probar nuestros productos. Consulta nuestra sección de contacto para conocer la ubicación y horarios.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGarantia5">
                            ¿Cómo puedo dejar una reseña sobre un producto?
                        </button>
                    </h2>
                    <div id="collapseGarantia5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes dejar una reseña sobre un producto accediendo a la página del producto en nuestra web y seleccionando la opción "Escribir una reseña".
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cuenta y Seguridad -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4 text-primary">Cuenta y Seguridad</h2>
            <div class="accordion" id="faqAccordionCuenta">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta1">
                            ¿Cómo creo una cuenta en la tienda?
                        </button>
                    </h2>
                    <div id="collapseCuenta1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes crear una cuenta haciendo clic en "Registrarse" en la parte superior de la página e ingresando tus datos personales.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta2">
                            ¿Qué hago si olvidé mi contraseña?
                        </button>
                    </h2>
                    <div id="collapseCuenta2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes restablecer tu contraseña haciendo clic en "¿Olvidaste tu contraseña?" en la página de inicio de sesión.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta3">
                            ¿Cómo puedo cambiar mis datos personales?
                        </button>
                    </h2>
                    <div id="collapseCuenta3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Para cambiar tus datos personales, inicia sesión en tu cuenta y accede a la sección "Mi Cuenta", donde podrás actualizar tu información.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta4">
                            ¿Mis datos personales están seguros en su tienda?
                        </button>
                    </h2>
                    <div id="collapseCuenta4" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Sí, protegemos tu información utilizando medidas de seguridad avanzadas y cumpliendo con las normativas de protección de datos vigentes.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta5">
                            ¿Cómo puedo darme de baja de su newsletter?
                        </button>
                    </h2>
                    <div id="collapseCuenta5" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted">
                            Puedes darte de baja de nuestro newsletter haciendo clic en el enlace de "Darse de baja" al final de cualquiera de nuestros correos electrónicos promocionales o desde tu cuenta.
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

    /* Acordeón limpio y elegante con tu color */
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
        line-height: 1.8;
    }

    /* Títulos grandes */
    .display-4 {
        font-size: 3rem;
    }

    /* Separación del footer */
    .min-vh-100 {
        min-height: calc(100vh - 200px);
    }

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