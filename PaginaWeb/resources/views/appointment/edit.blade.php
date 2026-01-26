@extends('layouts.app')
@section('content')

<!-- Estilos personalizados para SweetAlert y formulario -->
<style>
    .swal2-custom {
        background-color: #ffffff !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb !important;
        border-radius: 8px !important;
        max-width: 300px !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
    }
    .swal2-custom-error {
        background-color: #ffffff !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb !important;
        border-radius: 8px !important;
        max-width: 300px !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
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
    .service-card.selected p {
        color: white !important;
        font-weight: 500;
    }
    .flatpickr-calendar {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 8px;
    }
    .flatpickr-day.weekend:not(.prevMonthDay):not(.nextMonthDay):not(.disabled),
    .flatpickr-day.holiday:not(.prevMonthDay):not(.nextMonthDay):not(.disabled) {
        color: red !important;
        background: none !important;
        border-color: transparent !important;
    }
    .flatpickr-day.disabled,
    .flatpickr-day.disabled:hover {
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
        background-color: #2CA1B5 !important;
        color: white !important;
        border-color: #2CA1B5 !important;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .current-value {
        background-color: #e6f4f6;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    @media (max-width: 768px) {
        .service-card {
            width: 100%;
            max-width: 280px;
            margin: 0 auto 10px;
        }
        .row {
            justify-content: center;
        }
        .col-md-4 {
            display: flex;
            justify-content: center;
        }
        .flatpickr-calendar {
            max-width: 300px;
            margin: 0 auto 10px;
        }
        .time-option {
            margin: 5px 10px;
        }
        #time-options {
            margin-bottom: 10px;
        }
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center"></i>Modificar Cita</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="edit-form" action="{{ $from_portal ? route('user.appointment.update', $appointment->id) : route('appointment.update', $appointment->id) }}" method="POST">
        @csrf
        <input type="hidden" name="from_portal" value="{{ $from_portal ? 'true' : 'false' }}">

        @php
            $servicios = [
                ['value' => 'Examen_Visual', 'label' => 'Revisión optométrica', 'icon' => 'eye'],
                ['value' => 'Examen_Audiologico', 'label' => 'Revisión audiológica', 'icon' => 'ear'],
                ['value' => 'Revision_Lentillas', 'label' => 'Revisión lentillas', 'icon' => 'circle'],
            ];
            $currentServiceLabel = collect($servicios)->firstWhere('value', $appointment->service_type)['label'] ?? 'Desconocido';
        @endphp

        <div class="form-group">
            <label>Servicio Actual:</label>
            <div class="current-value">{{ $currentServiceLabel }}</div>
            <label>Cambiar Servicio (Opcional):</label>
            <div class="row">
                @foreach ($servicios as $servicio)
                    <div class="col-md-4 mb-3">
                        <div class="service-card card p-3 text-center selectable {{ $appointment->service_type === $servicio['value'] ? 'selected' : '' }}" data-value="{{ $servicio['value'] }}">
                            <i data-lucide="{{ $servicio['icon'] }}" class="mb-2" style="width: 32px; height: 32px;"></i>
                            <p>{{ $servicio['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="service" id="service" value="{{ $appointment->service_type }}">
        </div>

        <div class="form-group">
            <label>Fecha Actual:</label>
            <div class="current-value">{{ $appointment->appointment_date->format('d/m/Y') }}</div>
            <label>Cambiar Fecha (Opcional):</label>
            <input type="hidden" name="date" id="date" value="{{ $appointment->appointment_date->format('Y-m-d') }}">
            <div id="calendar" style="max-width: 400px; margin: 0 auto;"></div>
        </div>

        <div class="form-group">
            <label>Hora Actual:</label>
            <div class="current-value">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</div>
            <label>Cambiar Hora (Opcional):</label>
            <div id="time-options" class="row justify-content-center"></div>
            <input type="hidden" name="time" id="time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}">
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ $from_portal ? route('user.appointments') : route('appointment.manage', $appointment->confirmation_token) }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<!-- Librerías -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    let selectedDate = '{{ $appointment->appointment_date->format('Y-m-d') }}';
    let selectedTime = '{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}';

    function showAlert(message, type = "success") {
        Swal.fire({
            text: message,
            icon: type,
            timer: 3000,
            showConfirmButton: false,
            customClass: {
                popup: type === "success" ? 'swal2-custom' : 'swal2-custom-error'
            }
        }).then(() => {
            if (type === "success") {
                window.location.href = "{{ $from_portal ? route('user.appointments') : url('/') }}";
            }
        });
    }

    // Selección de servicio
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('service').value = card.dataset.value;
        });
    });

    // Calendario con flatpickr
    function getEasterSunday(year) {
        const a = year % 19, b = Math.floor(year / 100), c = year % 100;
        const d = Math.floor(b / 4), e = b % 4, f = Math.floor((b + 8) / 25);
        const g = Math.floor((b - f + 1) / 3), h = (19 * a + b - d - g + 15) % 30;
        const i = Math.floor(c / 4), k = c % 4;
        const l = (32 + 2 * e + 2 * i - h - k) % 7;
        const m = Math.floor((a + 11 * h + 22 * l) / 451);
        const month = Math.floor((h + l - 7 * m + 114) / 31);
        const day = ((h + l - 7 * m + 114) % 31) + 1;
        return new Date(year, month - 1, day);
    }

    function getVariableHolidays(year) {
        const easterSunday = getEasterSunday(year);
        return [
            new Date(year, easterSunday.getMonth(), easterSunday.getDate() - 2),
            new Date(year, easterSunday.getMonth(), easterSunday.getDate() + 1),
        ];
    }

    function getFixedHolidays(year) {
        return [
            new Date(year, 0, 1), new Date(year, 0, 6), new Date(year, 2, 19),
            new Date(year, 4, 1), new Date(year, 5, 24), new Date(year, 7, 15),
            new Date(year, 9, 9), new Date(year, 8, 10), new Date(year, 10, 1),
            new Date(year, 11, 4), new Date(year, 11, 6), new Date(year, 11, 8),
            new Date(year, 11, 25),
        ];
    }

    function getAllHolidays(year) {
        return [...getFixedHolidays(year), ...getVariableHolidays(year)];
    }

    flatpickr('#calendar', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        inline: true,
        locale: 'es',
        firstDayOfWeek: 1,
        defaultDate: selectedDate,
        onReady: function() {
            const year = new Date().getFullYear();
            const allHolidays = getAllHolidays(year);
            this.calendarContainer.querySelectorAll('.flatpickr-day').forEach(day => {
                const date = new Date(day.dateObj);
                const dateStr = date.toISOString().split('T')[0];
                if ([0,6].includes(date.getDay()) || allHolidays.some(h => h.toISOString().split('T')[0] === dateStr)) {
                    day.classList.add('weekend','holiday');
                }
            });
            loadAvailableHours(selectedDate);
        },
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length > 0) {
                document.getElementById('date').value = dateStr;
                selectedDate = dateStr;
                loadAvailableHours(dateStr);
            }
        }
    });

    function loadAvailableHours(date) {
        const timeOptions = document.getElementById('time-options');
        timeOptions.innerHTML = '';

        fetch(`{{ route('appointment.available_hours') }}?date=${encodeURIComponent(date)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                showAlert("No hay horas disponibles para esta fecha", "error");
            } else {
                data.forEach(hour => {
                    const button = document.createElement('button');
                    button.classList.add('btn','btn-outline-primary','time-option');
                    button.type = 'button';
                    button.textContent = hour;
                    if (hour === selectedTime) {
                        button.classList.add('active');
                        document.getElementById('time').value = hour;
                    }
                    button.addEventListener('click', () => {
                        document.getElementById('time').value = hour;
                        selectedTime = hour;
                        timeOptions.querySelectorAll('.time-option').forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');
                    });
                    timeOptions.appendChild(button);
                });
            }
        })
        .catch(error => showAlert(`Error al cargar horas: ${error.message}`, "error"));
    }

    // Submit vía AJAX
    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    text: data.message,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: { popup: 'swal2-custom' }
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    text: data.error || 'Ha ocurrido un error',
                    icon: 'error',
                    customClass: { popup: 'swal2-custom-error' }
                });
            }
        })
        .catch(error => {
            Swal.fire({
                text: 'Error en la solicitud: ' + error.message,
                icon: 'error',
                customClass: { popup: 'swal2-custom-error' }
            });
        });
    });

});
</script>

@endsection