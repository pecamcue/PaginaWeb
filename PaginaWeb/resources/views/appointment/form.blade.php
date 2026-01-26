@extends('layouts.app')

@section('content')
<style>
    .progressbar {
        margin-bottom: 30px;
        overflow: hidden;
    }
    .progressbar li {
        flex: 1;
        text-align: center;
        position: relative;
        color: #6c757d;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    .progressbar .selection-text {
        font-size: 12px;
        margin-top: 5px;
        color: #2CA1B5;
        word-wrap: break-word;
        max-width: 100%;
    }
    .service-card {
        cursor: pointer;
        transition: background-color 0.2s;
        border-radius: 8px;
    }
    .service-card:hover {
        background-color: #f8f9fa;
    }
    .service-card.selected {
        background-color: #2CA1B5 !important;
        color: white !important;
    }
    .btn-primary:disabled, .btn-success:disabled {
        opacity: 0.6;
    }
    .flatpickr-calendar {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 8px;
    }
    .flatpickr-day.disabled,
    .flatpickr-day.disabled:hover {
        color: red !important;
        background: none !important;
        border-color: transparent !important;
        cursor: not-allowed !important;
    }
    .flatpickr-day.selected {
        background-color: #2CA1B5 !important;
        color: white !important;
        border-color: #2CA1B5 !important;
    }
    .time-option {
        margin: 5px;
        padding: 10px;
        width: 100px;
        text-align: center;
        background-color: white;
        border: 2px solid #2CA1B5;
        color: #2CA1B5;
        transition: all 0.3s ease;
        border-radius: 5px;
    }
    .time-option.active {
        background-color: #2CA1B5;
        color: white !important;
        border-color: #2CA1B5;
    }
    .option-card {
        cursor: pointer;
        transition: background-color 0.2s;
        border: 2px solid #ddd;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
    }
    .option-card:hover {
        background-color: #f8f9fa;
    }
    .option-card.selected {
        border-color: #2CA1B5;
        background-color: #e6f4f6;
    }
    .modal-content {
        border-radius: 10px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        margin-bottom: 5px;
        font-weight: 500;
    }
    .alert {
        border-radius: 8px;
    }
    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
    .swal2-custom {
        background-color: white !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb !important;
        border-radius: 8px !important;
        max-width: 300px !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
    }
    .swal2-custom-error {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb !important;
    }
    @media (max-width: 768px) {
        fieldset[data-step="1"] .row {
            justify-content: center;
        }
        fieldset[data-step="1"] .col-md-4 {
            display: flex;
            justify-content: center;
        }
        fieldset[data-step="1"] .service-card {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
        }
        fieldset[data-step="2"] .card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center"></i>Reserva tu cita</h2>

    <!-- Barra de progreso -->
    <div class="mb-5">
        <ul id="progressbar" class="progressbar d-flex justify-content-between list-unstyled">
            <li class="active" data-step="1"><i data-lucide="clipboard-list"></i><br>Servicio<br><span class="selection-text" data-step="1"></span></li>
            <li data-step="2"><i data-lucide="map-pin"></i><br>Dirección<br><span class="selection-text" data-step="2"></span></li>
            <li data-step="3"><i data-lucide="calendar"></i><br>Fecha<br><span class="selection-text" data-step="3"></span></li>
            <li data-step="4"><i data-lucide="clock"></i><br>Hora<br><span class="selection-text" data-step="4"></span></li>
            <li data-step="5"><i data-lucide="user"></i><br>Usuario<br><span class="selection-text" data-step="5"></span></li>
            <li data-step="6"><i data-lucide="check-circle"></i><br>Resumen<br><span class="selection-text" data-step="6"></span></li>
        </ul>
    </div>

    <!-- Formulario multistep -->
    <form id="appointment-form" action="{{ route('appointment.store') }}">
        @php
        $servicios = [
            ['value' => 'Examen_Visual', 'label' => 'Revisión optométrica', 'icon' => 'eye'],
            ['value' => 'Examen_Audiologico', 'label' => 'Revisión audiológica', 'icon' => 'ear'],
            ['value' => 'Revision_Lentillas', 'label' => 'Revisión lentillas', 'icon' => 'circle'],
        ];
        $userData = Auth::check() ? Auth::user() : null;
        @endphp

        <!-- Paso 1: Selección de servicio -->
        <fieldset data-step="1">
            <h4>Selecciona un servicio</h4>
            <div class="row">
                @foreach ($servicios as $servicio)
                    <div class="col-md-4 mb-3">
                        <div class="service-card card p-3 text-center selectable" data-value="{{ $servicio['value'] }}">
                            <i data-lucide="{{ $servicio['icon'] }}" class="mb-2" style="width: 32px; height: 32px;"></i>
                            <p>{{ $servicio['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="service" id="service">
            <div class="text-end mt-4">
                <button type="button" class="btn btn-primary next-step" disabled>Continuar</button>
            </div>
        </fieldset>

        <!-- Paso 2: Dirección -->
        <fieldset data-step="2" style="display:none;">
            <h4>Dirección del centro</h4>
            <div class="card p-3">
                <p><i data-lucide="map-pin" class="me-2"></i> Av. Seminari 4, Moncada - Valencia</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step">Continuar</button>
            </div>
        </fieldset>

        <!-- Paso 3: Selección de fecha -->
        <fieldset data-step="3" style="display:none;">
            <h4>Selecciona una fecha</h4>
            <div id="calendar-error" class="alert alert-danger d-none" role="alert">
                Error: No se pudo cargar el calendario. Por favor, recarga la página.
            </div>
            <input type="hidden" name="date" id="date">
            <div id="calendar" style="max-width: 400px; margin: 0 auto;"></div>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">Atrás</button>
            </div>
        </fieldset>

        <!-- Paso 4: Selección de hora -->
        <fieldset data-step="4" style="display:none;">
            <h4>Selecciona una hora</h4>
            <div id="time-options" class="row justify-content-center"></div>
            <div id="time-error" class="alert alert-danger mt-3 d-none" role="alert">
                Error: No se pudieron cargar las horas. Verifica la conexión o intenta de nuevo. Detalle: <span id="error-detail"></span>
            </div>
            <input type="hidden" name="time" id="time">
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step" disabled>Continuar</button>
            </div>
        </fieldset>

        <!-- Paso 5: Selección de tipo de usuario -->
        <fieldset data-step="5" style="display:none;">
            <h4>¿Cómo deseas continuar?</h4>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="option-card" data-option="guest">
                        <i data-lucide="user" class="mb-2" style="width: 32px; height: 32px;"></i>
                        <p>Continuar como invitado</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="option-card" data-option="login">
                        <i data-lucide="log-in" class="mb-2" style="width: 32px; height: 32px;"></i>
                        <p>Iniciar sesión</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="option-card" data-option="register">
                        <i data-lucide="user-plus" class="mb-2" style="width: 32px; height: 32px;"></i>
                        <p>Registrarse</p>
                    </div>
                </div>
            </div>

            <!-- Formulario para invitados -->
            <div id="guest-form" class="mt-4" style="display: none;">
                <h5>Datos de invitado</h5>
                <div class="form-group">
                    <label for="guest_name" class="required">Nombre completo</label>
                    <input type="text" name="guest_name" id="guest_name" class="form-control @error('guest_name') is-invalid @enderror" value="{{ old('guest_name') }}">
                    @error('guest_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="guest_email" class="required">Correo electrónico</label>
                    <input type="email" name="guest_email" id="guest_email" class="form-control @error('guest_email') is-invalid @enderror" value="{{ old('guest_email') }}">
                    @error('guest_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="guest_phone" class="required">Teléfono</label>
                    <input type="text" name="guest_phone" id="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror" pattern="\+?[0-9]{9,15}" value="{{ old('guest_phone') }}">
                    @error('guest_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="user_type" id="user_type" value="">
            <input type="hidden" name="user_id" id="user_id">

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step" disabled>Continuar</button>
            </div>
        </fieldset>

        <!-- Paso 6: Resumen -->
        <fieldset data-step="6" style="display:none;">
            <h4>Resumen de la cita</h4>
            <ul id="summary" class="list-group mb-3"></ul>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary prev-step">Atrás</button>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="check-circle-2" class="me-1"></i> Confirmar cita
                </button>
            </div>
        </fieldset>
    </form>

    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="login-form">
                        <div class="form-group">
                            <label for="login_email" class="required">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="login_email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="login_password" class="required">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="login_password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="login-error" class="alert alert-danger d-none" role="alert"></div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registrarse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="register-form">
                        <div class="form-group">
                            <label for="register_name" class="required">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="register_name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_apellidos" class="required">Apellidos</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="register_apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_email" class="required">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="register_email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_phone" class="required">Teléfono (Ej: +34123456789)</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="register_phone" name="telefono" pattern="\+?[0-9]{9,15}" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_calle" class="required">Calle</label>
                            <input type="text" class="form-control @error('calle') is-invalid @enderror" id="register_calle" name="calle" value="{{ old('calle') }}" required>
                            @error('calle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_numero" class="required">Número</label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror" id="register_numero" name="numero" value="{{ old('numero') }}" required>
                            @error('numero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_piso">Piso (Opcional)</label>
                            <input type="text" class="form-control @error('piso') is-invalid @enderror" id="register_piso" name="piso" value="{{ old('piso') }}">
                            @error('piso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_codigo_postal" class="required">Código Postal</label>
                            <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" id="register_codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" required>
                            @error('codigo_postal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_ciudad" class="required">Ciudad</label>
                            <input type="text" class="form-control @error('ciudad') is-invalid @enderror" id="register_ciudad" name="ciudad" value="{{ old('ciudad') }}" required>
                            @error('ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_pais" class="required">País</label>
                            <input type="text" class="form-control @error('pais') is-invalid @enderror" id="register_pais" name="pais" value="{{ old('pais') }}" required>
                            @error('pais')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_password" class="required">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="register_password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_password_confirm" class="required">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="register_password_confirm" name="password_confirmation" required>
                        </div>
                        <div id="register-error" class="alert alert-danger d-none" role="alert"></div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencias -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/lucide@0.441.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

    <!-- JavaScript para manejar el flujo del formulario de citas -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();

        let currentStep = 1;
        const steps = document.querySelectorAll('fieldset');
        const progressItems = document.querySelectorAll('#progressbar li');
        let userData = @json($userData);
        let isAuthenticated = !!userData;

        if (isAuthenticated) {
            document.getElementById('user_id').value = userData.id;
            document.getElementById('user_type').value = 'registered';
            document.getElementById('guest_name').removeAttribute('required');
            document.getElementById('guest_email').removeAttribute('required');
            document.getElementById('guest_phone').removeAttribute('required');
        }

        function updateProgressBar(step, value) {
            const progressItem = document.querySelector(`#progressbar li[data-step="${step}"] .selection-text`);
            if (progressItem) {
                progressItem.textContent = value || '';
            }
        }

        function goToStep(step) {
            steps.forEach(fieldset => fieldset.style.display = 'none');
            const targetFieldset = document.querySelector(`fieldset[data-step="${step}"]`);
            if (targetFieldset) targetFieldset.style.display = 'block';
            progressItems.forEach(li => li.classList.toggle('active', parseInt(li.dataset.step) <= step));
            currentStep = step;

            if (step === 2) {
                updateProgressBar(2, 'Av. Seminari 4, Moncada - Valencia');
            }

            if (step === 3) {
                initializeCalendar();
            }

            if (step === 6) {
                updateSummary();
                document.querySelector('fieldset[data-step="6"] .btn-success').disabled = false;
            }
        }

        function updateSummary() {
            const summary = document.getElementById('summary');
            const service = document.getElementById('service').value;
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const userType = document.getElementById('user_type').value;
            let name, email, phone;

            if (userType === 'guest') {
                name = document.getElementById('guest_name').value || 'No disponible';
                email = document.getElementById('guest_email').value || 'No disponible';
                phone = document.getElementById('guest_phone').value || 'No disponible';
            } else {
                name = userData && userData.name ? userData.name : 'No disponible';
                email = userData && userData.email ? userData.email : 'No disponible';
                phone = userData && userData.telefono ? userData.telefono : 'No disponible';
            }

            const serviceLabels = {
                'Examen_Visual': 'Revisión optométrica',
                'Examen_Audiologico': 'Revisión audiológica',
                'Revision_Lentillas': 'Revisión lentillas'
            };

            summary.innerHTML = `
                <li class="list-group-item"><strong>Servicio:</strong> ${serviceLabels[service] || 'No seleccionado'}</li>
                <li class="list-group-item"><strong>Dirección:</strong> Av. Seminari 4, Moncada - Valencia</li>
                <li class="list-group-item"><strong>Fecha:</strong> ${date ? new Date(date).toLocaleDateString('es-ES') : 'No seleccionada'}</li>
                <li class="list-group-item"><strong>Hora:</strong> ${time || 'No seleccionada'}</li>
                <li class="list-group-item"><strong>Nombre:</strong> ${name}</li>
                <li class="list-group-item"><strong>Email:</strong> ${email}</li>
                <li class="list-group-item"><strong>Teléfono:</strong> ${phone}</li>
            `;
            updateProgressBar(6, 'Confirmar cita');
        }

        function getEasterSunday(year) {
            const a = year % 19;
            const b = Math.floor(year / 100);
            const c = year % 100;
            const d = Math.floor(b / 4);
            const e = b % 4;
            const f = Math.floor((b + 8) / 25);
            const g = Math.floor((b - f + 1) / 3);
            const h = (19 * a + b - d - g + 15) % 30;
            const i = Math.floor(c / 4);
            const k = c % 4;
            const l = (32 + 2 * e + 2 * i - h - k) % 7;
            const m = Math.floor((a + 11 * h + 22 * l) / 451);
            const month = Math.floor((h + l - 7 * m + 114) / 31);
            const day = ((h + l - 7 * m + 114) % 31) + 1;
            return new Date(year, month - 1, day);
        }

        function getVariableHolidays(year) {
            const easterSunday = getEasterSunday(year);
            return [
                new Date(easterSunday.getFullYear(), easterSunday.getMonth(), easterSunday.getDate() - 2),
                new Date(easterSunday.getFullYear(), easterSunday.getMonth(), easterSunday.getDate() + 1),
            ];
        }

        function getFixedHolidays(year) {
            return [
                new Date(year, 0, 1),
                new Date(year, 0, 6),
                new Date(year, 2, 19),
                new Date(year, 4, 1),
                new Date(year, 5, 24),
                new Date(year, 7, 15),
                new Date(year, 9, 9),
                new Date(year, 8, 10),
                new Date(year, 10, 1),
                new Date(year, 11, 4),
                new Date(year, 11, 6),
                new Date(year, 11, 8),
                new Date(year, 11, 25),
            ];
        }

        function getAllHolidays(year) {
            return [...getFixedHolidays(year), ...getVariableHolidays(year)];
        }

        function initializeCalendar() {
            const calendarContainer = document.getElementById('calendar');
            const dateInput = document.getElementById('date');
            const timeOptions = document.getElementById('time-options');
            if (calendarContainer.flatpickrInstance) {
                calendarContainer.flatpickrInstance.destroy();
            }

            flatpickr(calendarContainer, {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                inline: true,
                locale: 'es',
                firstDayOfWeek: 1,
                disable: [
                    function(date) {
                        const isWeekend = date.getDay() === 6 || date.getDay() === 0;
                        if (isWeekend) return true;
                        const year = date.getFullYear();
                        const allHolidays = getAllHolidays(year);
                        const dateStr = date.toISOString().split('T')[0];
                        return allHolidays.some(holiday => holiday.toISOString().split('T')[0] === dateStr);
                    }
                ],
                onReady: function() {
                    updateDisabledDays(this);
                    if (dateInput.value) {
                        loadAvailableHours(dateInput.value);
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        dateInput.value = dateStr;
                        updateProgressBar(3, new Date(dateStr).toLocaleDateString('es-ES'));
                        document.querySelector('fieldset[data-step="4"]').style.display = 'block';
                        document.querySelector('fieldset[data-step="3"]').style.display = 'none';
                        goToStep(4);
                        loadAvailableHours(dateStr);
                    }
                }
            });
        }

        function updateDisabledDays(instance) {
            instance.calendarContainer.querySelectorAll('.flatpickr-day').forEach(day => {
                const date = new Date(day.dateObj);
                const year = date.getFullYear();
                const allHolidays = getAllHolidays(year);
                const dateStr = date.toISOString().split('T')[0];
                const isDisabled = (date.getDay() === 6 || date.getDay() === 0) || 
                                  allHolidays.some(holiday => holiday.toISOString().split('T')[0] === dateStr);
                if (isDisabled) {
                    day.classList.add('disabled');
                }
            });
        }

        function loadAvailableHours(date) {
            const timeOptions = document.getElementById('time-options');
            const timeError = document.getElementById('time-error');
            const errorDetail = document.getElementById('error-detail');
            timeOptions.innerHTML = '';
            timeError.classList.add('d-none');

            console.log('Solicitando horas disponibles para fecha:', date);

            fetch(`{{ url('cita/horas-disponibles') }}?date=${encodeURIComponent(date)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Cache-Control': 'no-cache'
                },
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
                return response.json();
            })
            .then(data => {
                console.log('Horas recibidas del servidor:', data);
                if (data.length === 0) {
                    timeOptions.innerHTML = '<div class="col-12 text-center">No hay horas disponibles para esta fecha.</div>';
                    document.querySelector('fieldset[data-step="4"] .next-step').disabled = true;
                } else {
                    data.forEach(hour => {
                        const button = document.createElement('button');
                        button.classList.add('btn', 'btn-outline-primary', 'time-option');
                        button.type = 'button';
                        button.textContent = hour;
                        button.addEventListener('click', () => {
                            document.getElementById('time').value = hour;
                            updateProgressBar(4, hour);
                            document.querySelector('fieldset[data-step="4"] .next-step').disabled = false;
                            timeOptions.querySelectorAll('.time-option').forEach(btn => btn.classList.remove('active'));
                            button.classList.add('active');
                            button.focus();
                        });
                        timeOptions.appendChild(button);
                    });
                }
            })
            .catch(error => {
                console.error('Error al cargar horas:', error);
                timeError.classList.remove('d-none');
                errorDetail.textContent = error.message;
                document.querySelector('fieldset[data-step="4"] .next-step').disabled = true;
            });
        }

        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', () => {
                console.log('Servicio seleccionado:', card.dataset.value);
                document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                document.getElementById('service').value = card.dataset.value;
                updateProgressBar(1, card.querySelector('p').textContent);
                document.querySelector('fieldset[data-step="1"] .next-step').disabled = false;
            });
        });

        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep === 4 && !document.getElementById('time').value) {
                    alert('Por favor, selecciona una hora.');
                    return;
                }

                if (currentStep === 4 && isAuthenticated) {
                    goToStep(6);
                } else {
                    goToStep(currentStep + 1);
                }
            });
        });

        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', () => goToStep(currentStep - 1));
        });

        const optionCards = document.querySelectorAll('.option-card');
        const guestForm = document.getElementById('guest-form');
        const userTypeInput = document.getElementById('user_type');
        const userIdInput = document.getElementById('user_id');
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));

        optionCards.forEach(card => {
            card.addEventListener('click', () => {
                if (isAuthenticated) return;
                optionCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const option = card.dataset.option;
                userTypeInput.value = option;

                if (option === 'guest') {
                    guestForm.style.display = 'block';
                    userIdInput.value = '';
                    document.getElementById('guest_name').setAttribute('required', 'required');
                    document.getElementById('guest_email').setAttribute('required', 'required');
                    document.getElementById('guest_phone').setAttribute('required', 'required');
                    validateGuestForm();
                    updateProgressBar(5, 'Invitado');
                } else {
                    guestForm.style.display = 'none';
                    userIdInput.value = '';
                    document.querySelector('fieldset[data-step="5"] .next-step').disabled = true;
                    document.getElementById('guest_name').removeAttribute('required');
                    document.getElementById('guest_email').removeAttribute('required');
                    document.getElementById('guest_phone').removeAttribute('required');
                    if (option === 'login') {
                        loginModal.show();
                        updateProgressBar(5, 'Iniciar sesión');
                    } else if (option === 'register') {
                        registerModal.show();
                        updateProgressBar(5, 'Registrarse');
                    }
                }
            });
        });

        function validateGuestForm() {
            const name = document.getElementById('guest_name').value.trim();
            const email = document.getElementById('guest_email').value.trim();
            const phone = document.getElementById('guest_phone').value.trim();
            const nextButton = document.querySelector('fieldset[data-step="5"] .next-step');
            const emailValid = email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
            const phoneValid = phone.match(/\+?[0-9]{9,15}/);
            const isValid = name && emailValid && phoneValid;

            nextButton.disabled = !isValid;
            if (isValid) {
                userData = { name, email, telefono: phone, apellidos: '' };
                updateProgressBar(5, name);
            }
        }

        document.querySelectorAll('#guest-form input').forEach(input => {
            input.addEventListener('input', validateGuestForm);
        });

        async function refreshCsrfToken() {
            try {
                const response = await fetch('{{ url('sanctum/csrf-cookie') }}', {
                    method: 'GET',
                    credentials: 'include'
                });
                if (!response.ok) {
                    throw new Error(`No se pudo refrescar el token CSRF: ${response.status} ${response.statusText}`);
                }
                console.log('Token CSRF refrescado con éxito');
                const tokenResponse = await fetch('{{ url('csrf-token') }}');
                if (!tokenResponse.ok) {
                    throw new Error('No se pudo obtener el nuevo token CSRF');
                }
                const data = await tokenResponse.json();
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (csrfTokenMeta) {
                    csrfTokenMeta.setAttribute('content', data.csrf_token);
                    console.log('Meta tag CSRF actualizado:', data.csrf_token);
                }
            } catch (error) {
                console.error('Error al actualizar el token CSRF:', error);
                throw error;
            }
        }

        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const loginError = document.getElementById('login-error');
            loginError.classList.add('d-none');

            formData.append('in_reservation_flow', 'true');

            try {
                await refreshCsrfToken();
                const response = await fetch('{{ url('login') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData,
                    credentials: 'include'
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Credenciales inválidas: ${errorText}`);
                }

                const data = await response.json();
                console.log('Datos del usuario tras login:', data);
                userData = {
                    id: data.id,
                    name: data.name,
                    apellidos: data.apellidos || '',
                    email: data.email,
                    telefono: data.telefono || 'No disponible'
                };
                userIdInput.value = data.id;
                userTypeInput.value = 'registered';
                isAuthenticated = true;
                loginModal.hide();
                await refreshCsrfToken();
                updateProgressBar(5, data.name);
                goToStep(6);
                updateSummary();
                document.querySelector('fieldset[data-step="6"] .btn-success').disabled = false;
            } catch (error) {
                loginError.classList.remove('d-none');
                loginError.textContent = error.message;
                console.error('Error en login:', error);
            }
        });

        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const password = document.getElementById('register_password').value;
            const passwordConfirm = document.getElementById('register_password_confirm').value;
            const registerError = document.getElementById('register-error');
            const formData = new FormData(this);
            const telefono = document.getElementById('register_phone').value.trim();

            if (password !== passwordConfirm) {
                registerError.classList.remove('d-none');
                registerError.textContent = 'Las contraseñas no coinciden';
                return;
            }

            formData.append('in_reservation_flow', 'true');

            try {
                await refreshCsrfToken();
                const response = await fetch('{{ url('register') }}', {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'include'
                });

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const errorText = await response.text();
                    console.error('Respuesta no JSON del servidor:', errorText);
                    throw new Error(`Respuesta no JSON del servidor: ${response.status} ${response.statusText}`);
                }

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`Error al registrarse: ${errorData.message || response.statusText}`);
                }

                const data = await response.json();
                console.log('Datos del usuario tras registro:', data);
                userData = {
                    id: data.id,
                    name: data.name,
                    apellidos: data.apellidos || '',
                    email: data.email,
                    telefono: telefono || data.telefono || 'No disponible'
                };
                userIdInput.value = data.id;
                userTypeInput.value = 'registered';
                isAuthenticated = true;
                registerModal.hide();
                await refreshCsrfToken();
                updateProgressBar(5, data.name);
                goToStep(6);
                updateSummary();
                document.querySelector('fieldset[data-step="6"] .btn-success').disabled = false;
            } catch (error) {
                console.error('Error en registro:', error);
                registerError.classList.remove('d-none');
                registerError.textContent = error.message;
            }
        });

        document.getElementById('appointment-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Procesando',
                text: 'Confirmando tu cita...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(this);
            const userType = document.getElementById('user_type').value;
            formData.append('user_type', userType);

            if (userType === 'registered') {
                formData.delete('guest_name');
                formData.delete('guest_email');
                formData.delete('guest_phone');
            }

            if (userType === 'guest') {
                formData.append('guest_name', userData.name);
                formData.append('guest_email', userData.email);
                formData.append('guest_phone', userData.telefono);
                formData.delete('user_id');
            } else {
                formData.append('user_id', userData.id);
            }

            try {
                await refreshCsrfToken();

                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'include'
                });

                console.log('Respuesta del servidor (estado):', response.status);
                console.log('Respuesta del servidor texto:', response.statusText);

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Error HTTP: ${response.status} - ${errorText}`);
                }

                const data = await response.json();
                console.log('Datos devueltos por el servidor:', data);
                Swal.fire({
                    title: 'Éxito',
                    text: data.message || '¡Cita confirmada!',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-custom'
                    }
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } catch (error) {
                console.error('Error al guardar la cita:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al guardar la cita: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    customClass: {
                        popup: 'swal2-custom swal2-custom-error'
                    }
                });
            }
        });

        if (isAuthenticated) {
            document.querySelector('fieldset[data-step="5"]').style.display = 'none';
            document.querySelector('fieldset[data-step="1"]').style.display = 'block';
            goToStep(1);
        } else {
            goToStep(1);
        }
    });
    </script>
@endsection