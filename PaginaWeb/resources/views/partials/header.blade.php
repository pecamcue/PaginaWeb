<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('inicio') }}">
            <img src="{{ asset('img/Logo2.jpg') }}" alt="Logo de Óptica y Audiología Concha Cuevas"
                 class="d-inline-block align-text-top img-fluid logo-mobile" style="max-width: 300px;">
        </a>

        <!-- Menú de navegación (visible en escritorio, oculto en móvil) -->
        <div class="navbar-collapse d-none d-lg-flex" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <!-- Servicios -->
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownServicios" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Servicios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownServicios">
                        <li><a class="dropdown-item" href="{{ route('servicio.optica') }}">Óptica</a></li>
                        <li><a class="dropdown-item" href="{{ route('servicio.audiologia') }}">Audiología</a></li>
                        <li><a class="dropdown-item" href="{{ route('servicio.lentes_contacto') }}">Lentes de Contacto</a></li>
                        <li><a class="dropdown-item" href="{{ route('servicio.taller') }}">Taller</a></li>
                    </ul>
                </li>

                <!-- Tienda -->
                <li class="nav-item mx-3">
                    <a class="nav-link" href="{{ route('redirect.to.angular') }}">Tienda Online</a>
                </li>

                <!-- Contacto -->
                <li class="nav-item mx-3">
                    <a class="nav-link" href="{{ route('contacto') }}">Contacto</a></li>
            </ul>

            <!-- Área de usuario -->
            <div class="d-flex align-items-center gap-3 flex-wrap justify-content-end">
                @guest
                    <!-- Si el usuario no está autenticado -->
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
                @endguest

                @auth
                    <!-- Si el usuario está autenticado -->
                    <span id="welcome-message" class="fw-bold" style="color: var(--primary-color);">
                        Bienvenido, {{ auth()->user()->name }}
                    </span>

                    @if (auth()->user()->is_admin)
                        <!-- Panel Admin (solo para administradores) -->
                        <div class="dropdown">
                            <button class="btn-menu dropdown-toggle" type="button" id="dropdownAdmin" data-bs-toggle="dropdown" aria-expanded="false">
                                🛠️ Panel Admin
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAdmin">
                                <!-- Productos - Submenú por click -->
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item submenu-toggle" href="#" data-target="#admin-submenu-productos">
                                        📦 Productos <i class="fas fa-chevron-right ms-auto"></i>
                                    </a>
                                    <ul class="dropdown-menu submenu" id="admin-submenu-productos">
                                        <li><a class="dropdown-item" href="{{ route('admin.producto.crear') }}">➕ Crear producto</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.panel') }}">📋 Listar / Editar / Eliminar productos</a></li>
                                    </ul>
                                </li>
                                
                                <!-- Pedidos - Submenú por click -->
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item submenu-toggle" href="#" data-target="#admin-submenu-pedidos">
                                        📋 Pedidos <i class="fas fa-chevron-right ms-auto"></i>
                                    </a>
                                    <ul class="dropdown-menu submenu" id="admin-submenu-pedidos">
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">📋 Listar pedidos</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}?status=pendiente">⏳ Pendientes</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}?status=enviado">🚚 Enviados</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}?status=completado">✅ Completados</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}?status=cancelado">❌ Cancelados</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Menú Mi cuenta para usuarios normales -->
                        <div class="dropdown">
                            <button class="btn-menu dropdown-toggle" type="button" id="dropdownCuenta" data-bs-toggle="dropdown" aria-expanded="false">
                                Mi cuenta <i class="fas fa-chevron-down ms-1"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownCuenta">
                                <!-- Perfil - Submenú por click -->
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item submenu-toggle" href="#" data-target="#user-submenu-perfil">
                                        👤 Perfil <i class="fas fa-chevron-right ms-auto"></i>
                                    </a>
                                    <ul class="dropdown-menu submenu" id="user-submenu-perfil">
                                        <li><a class="dropdown-item" href="{{ route('perfil.edit') }}">Editar perfil</a></li>
                                        <li><a class="dropdown-item" href="{{ route('perfil.changePassword') }}">Cambiar contraseña</a></li>
                                        <li>
                                            <form action="{{ route('perfil.deleteAccount') }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Cerrar cuenta</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Pedidos -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.orders') }}">📦 Pedidos</a>
                                </li>

                                <!-- Citas -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.appointments') }}">📅 Citas</a>
                                </li>

                                <!-- Formas de pago -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.payment-methods') }}">💳 Formas de Pago</a>
                                </li>

                                <!-- Newsletter -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('newsletter.manage') }}">📧 Newsletter</a>
                                </li>
                                
                                <!-- Graduación -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('graduacion.gestionar') }}">👓 Graduación</a>
                                </li>
                            </ul>
                        </div>
                    @endif

                    <!-- Botón logout (solo en escritorio) -->
                    <form action="{{ route('logout') }}" method="POST" class="ms-2 d-inline d-lg-block d-none">
                        @csrf
                        <button type="submit" class="btn-logout">LogOut</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Bottom Navigation Bar (visible solo en móvil < 992px) -->
<nav class="navbar fixed-bottom navbar-light bg-white d-lg-none bottom-nav">
    <div class="container-fluid d-flex justify-content-around">
        <!-- Inicio -->
        <div class="text-center">
            <a class="nav-link" href="{{ route('inicio') }}">
                <i class="fas fa-home fa-lg text-primary"></i><br>
                <small>Inicio</small>
            </a>
        </div>

        <!-- Servicios -->
        <div class="text-center">
            <a class="nav-link dropdown-toggle" href="#" id="bottomDropdownServicios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tools fa-lg text-primary"></i><br>
                <small>Servicios</small>
            </a>
            <ul class="dropdown-menu dropdown-menu-up" aria-labelledby="bottomDropdownServicios">
                <li><a class="dropdown-item" href="{{ route('servicio.optica') }}">Óptica</a></li>
                <li><a class="dropdown-item" href="{{ route('servicio.audiologia') }}">Audiología</a></li>
                <li><a class="dropdown-item" href="{{ route('servicio.lentes_contacto') }}">Lentes de Contacto</a></li>
                <li><a class="dropdown-item" href="{{ route('servicio.taller') }}">Taller</a></li>
            </ul>
        </div>

        <!-- Tienda Online -->
        <div class="text-center">
            <a class="nav-link" href="{{ route('redirect.to.angular') }}">
                <i class="fas fa-shopping-cart fa-lg text-primary"></i><br>
                <small>Tienda</small>
            </a>
        </div>

        <!-- Contacto -->
        <div class="text-center">
            <a class="nav-link" href="{{ route('contacto') }}">
                <i class="fas fa-envelope fa-lg text-primary"></i><br>
                <small>Contacto</small>
            </a>
        </div>

        <!-- Login/Register o Logout -->
        <div class="text-center">
            @guest
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-user fa-lg text-primary"></i><br>
                    <small>Login/Register</small>
                </a>
            @endguest
            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link text-center bg-transparent border-0">
                        <i class="fas fa-sign-out-alt fa-lg text-primary"></i><br>
                        <small>Logout</small>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<!-- Estilos -->
<style>
    :root {
        --primary-color: #2CA1B5;
        --primary-hover: #228a9b;
        --secondary-hover: #0e7a84;
        --text-dark: black;
        --text-light: white;
        --border-color: #ccc;
        --background-light: #f8f9fa;
        --background-dark: #adaeae;
        --danger-color: #dc3545; 
        --danger-hover: #bb2d3b;
    }

    .btn-login {
        background-color: var(--text-light);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 6px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-login:hover {
        background-color: var(--primary-color);
        color: var(--text-light);
    }

    .btn-register {
        background-color: var(--primary-color);
        color: var(--text-light);
        border: 2px solid var(--primary-color);
        padding: 6px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-register:hover {
        background-color: var(--text-light);
        color: var(--primary-color);
    }

    .btn-logout {
        background-color: transparent;
        color: var(--danger-color);
        border: 2px solid var(--danger-color);
        padding: 6px 16px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .btn-logout:hover {
        background-color: var(--danger-color);
        color: var(--text-light);
    }

    .btn-menu {
        background-color: transparent;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        padding: 6px 14px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .btn-menu:hover {
        background-color: var(--primary-color);
        color: var(--text-light);
    }

    .dropdown-submenu {
        position: relative;
    }

    .submenu {
        display: none;
        position: absolute;
        top: 0;
        left: 100%;
        min-width: 200px;
        margin: 0;
        padding: 0;
        list-style: none;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        z-index: 1001;
    }
    .submenu.show {
        display: block;
    }

    .submenu-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        width: 100%;
    }
    .submenu-toggle i {
        font-size: 0.8em;
        color: #6c757d;
        transition: transform 0.2s ease;
    }
    .submenu-toggle.active i {
        transform: rotate(90deg);
        color: var(--primary-color);
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .bottom-nav {
        border-top: 1px solid var(--border-color);
        padding: 6px 0;
    }
    .bottom-nav .nav-link {
        color: var(--text-dark);
        font-size: 0.9rem;
    }
    .bottom-nav .nav-link:hover {
        color: var(--primary-color);
    }
    .bottom-nav .fa-lg {
        font-size: 1.3rem;
    }
    .bottom-nav small {
        font-size: 0.8rem;
    }
    .bottom-nav .dropdown-toggle::after {
        display: none !important;
    }
    .dropdown-menu-up {
        bottom: 100% !important; 
        top: auto !important;
    }

    @media (max-width: 1056px) {
        .btn-login, .btn-register {
            display: none;
        }
        .navbar-brand img {
            max-width: 200px; 
        }
        .navbar-collapse {
            display: flex !important; 
            justify-content: flex-end;
        }
        .navbar-nav {
            display: none;
        }
        .dropdown-menu {
            right: 0 !important;
            left: auto !important;
            max-width: 200px; 
            font-size: 0.9rem; 
        }
        .dropdown-menu .dropdown-item {
            white-space: normal;
            padding: 5px 10px;
        }
        .submenu {
            display: none !important;
        }
        .submenu-toggle i {
            display: none !important;
        }
        .dropdown-submenu .dropdown-item {
            display: block !important;
        }
    }

    @media (min-width: 1057px) {
        .btn-login, .btn-register {
            display: inline-block;
        }
        .navbar-brand img {
            max-width: 300px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Submenús (Admin y Usuario)
    document.querySelectorAll('.submenu-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const targetId = this.getAttribute('data-target');
            const parentDropdown = this.closest('.dropdown-menu'); // Menú padre
            const targetSubmenu = document.querySelector(targetId);
            const isActive = this.classList.contains('active');

            // 1. Cerrar todos los submenús dentro del mismo dropdown
            parentDropdown.querySelectorAll('.submenu').forEach(function(submenu) {
                submenu.classList.remove('show');
            });
            parentDropdown.querySelectorAll('.submenu-toggle').forEach(function(btn) {
                btn.classList.remove('active');
            });

            // 2. Si no estaba abierto, abrir solo el clicado
            if (!isActive) {
                targetSubmenu.classList.add('show');
                this.classList.add('active');
            }
        });
    });

    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.submenu').forEach(function(submenu) {
                submenu.classList.remove('show');
            });
            document.querySelectorAll('.submenu-toggle').forEach(function(toggle) {
                toggle.classList.remove('active');
            });
        }
    });

    // Cerrar submenús al cerrar dropdown principal
    document.querySelectorAll('.dropdown').forEach(function(dropdown) {
        dropdown.addEventListener('hide.bs.dropdown', function() {
            this.querySelectorAll('.submenu').forEach(function(submenu) {
                submenu.classList.remove('show');
            });
            this.querySelectorAll('.submenu-toggle').forEach(function(toggle) {
                toggle.classList.remove('active');
            });
        });
    });
});
</script>

