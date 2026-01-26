@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center mb-4">Mis <span class="text-primary">Graduaciones</span></h2>

                <!-- Mostrar mensajes de sesión con SweetAlert2 -->
                @if (session('status') || session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @if (session('status'))
                                Swal.fire({
                                    title: 'Éxito',
                                    text: '{{ session('status') }}',
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
                                    confirmButtonColor: '#d33',
                                    customClass: {
                                        popup: 'swal2-custom swal2-custom-error'
                                    }
                                });
                            @endif
                        });
                    </script>
                @endif

                <!-- Botón para crear graduación -->
                <div class="mb-4 text-start">
                    <button type="button" class="btn btn-primary btn-lg rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#graduacionModal" data-action="crear">
                        <i class="fas fa-plus me-2"></i> Añadir graduación
                    </button>
                </div>

                <!-- Lista de graduaciones -->
                @if ($graduaciones->isEmpty())
                    <p class="text-center text-muted fs-5">No tienes graduaciones registradas.</p>
                @else
                    <div class="row">
                        @foreach ($graduaciones as $graduacion)
                            <div class="col-md-5 mb-4">
                                <div class="card h-100 border-0 shadow-lg rounded-3">
                                    <div class="card-header bg-primary text-white d-flex align-items-center py-3">
                                        <i class="fas {{ $graduacion->nombre === 'Lentillas' ? 'fa-eye' : ($graduacion->nombre === 'Gafa progresiva' ? 'fa-glasses' : ($graduacion->nombre === 'Gafa de lejos' ? 'fa-binoculars' : 'fa-book-reader')) }} fs-4 me-2"></i>
                                        <h5 class="card-title mb-0">{{ $graduacion->nombre ?? 'Graduación #' . $graduacion->id }}</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless align-middle">
                                                <thead>
                                                    <tr class="text-muted">
                                                        <th style="width: 30%;"></th>
                                                        <th class="text-center" style="width: 35%;">Ojo Derecho (O.D)</th>
                                                        <th class="text-center" style="width: 35%;">Ojo Izquierdo (O.I)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Esfera</td>
                                                        <td class="text-center">{{ $graduacion->od_esfera ?? '–' }}</td>
                                                        <td class="text-center">{{ $graduacion->os_esfera ?? '–' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cilindro</td>
                                                        <td class="text-center">{{ $graduacion->od_cilindro ?? '–' }}</td>
                                                        <td class="text-center">{{ $graduacion->os_cilindro ?? '–' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Eje</td>
                                                        <td class="text-center">{{ $graduacion->od_eje ?? '–' }}</td>
                                                        <td class="text-center">{{ $graduacion->os_eje ?? '–' }}</td>
                                                    </tr>
                                                    @if ($graduacion->nombre !== 'Gafa de lejos' && $graduacion->nombre !== 'Gafa de cerca')
                                                        <tr>
                                                            <td>Adición</td>
                                                            <td class="text-center">{{ $graduacion->od_adicion ?? '–' }}</td>
                                                            <td class="text-center">{{ $graduacion->os_adicion ?? '–' }}</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 text-end py-3">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2" data-bs-toggle="modal" data-bs-target="#graduacionModal"
                                                data-action="editar" data-graduacion='{{ json_encode($graduacion) }}'>
                                            <i class="fas fa-edit me-1"></i> Editar
                                        </button>
                                        <form action="{{ route('graduacion.eliminar', $graduacion) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                <i class="fas fa-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Modal para crear/editar -->
    <div class="modal fade" id="graduacionModal" tabindex="-1" aria-labelledby="graduacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="graduacionModalLabel">Nueva Graduación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="graduacionForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Tipo de graduación (opcional)</label>
                            <select class="form-select" id="nombre" name="nombre">
                                <option value="">Seleccionar tipo</option>
                                <option value="Gafa progresiva">Gafa progresiva</option>
                                <option value="Lentillas">Lentillas</option>
                                <option value="Gafa de lejos">Gafa de lejos</option>
                                <option value="Gafa de cerca">Gafa de cerca</option>
                            </select>
                        </div>
                        <h6 class="mb-3">Ojo Derecho (O.D)</h6>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="od_esfera" class="form-label">Esfera</label>
                                <input type="number" class="form-control" id="od_esfera" name="od_esfera" step="0.25" min="-20" max="20" value="0.00" placeholder="0.00" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="od_cilindro" class="form-label">Cilindro</label>
                                <input type="number" class="form-control" id="od_cilindro" name="od_cilindro" step="0.25" min="-20" max="20" value="0.00" placeholder="0.00" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="od_eje" class="form-label">Eje</label>
                                <input type="number" class="form-control" id="od_eje" name="od_eje" step="10" min="0" max="180" value="0" placeholder="0" disabled>
                            </div>
                            <div class="col-md-3" id="od_adicion_container">
                                <label for="od_adicion" class="form-label">Adición</label>
                                <input type="number" class="form-control" id="od_adicion" name="od_adicion" step="0.5" min="-4" max="4" value="0.00" placeholder="0.00" disabled>
                            </div>
                        </div>
                        <h6 class="mb-3">Ojo Izquierdo (O.I)</h6>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="os_esfera" class="form-label">Esfera</label>
                                <input type="number" class="form-control" id="os_esfera" name="os_esfera" step="0.25" min="-20" max="20" value="0.00" placeholder="0.00" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="os_cilindro" class="form-label">Cilindro</label>
                                <input type="number" class="form-control" id="os_cilindro" name="os_cilindro" step="0.25" min="-20" max="20" value="0.00" placeholder="0.00" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="os_eje" class="form-label">Eje</label>
                                <input type="number" class="form-control" id="os_eje" name="os_eje" step="10" min="0" max="180" value="0" placeholder="0" disabled>
                            </div>
                            <div class="col-md-3" id="os_adicion_container">
                                <label for="os_adicion" class="form-label">Adición</label>
                                <input type="number" class="form-control" id="os_adicion" name="os_adicion" step="0.5" min="-4" max="4" value="0.00" placeholder="0.00" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .text-primary {
            color: #2CA1B5 !important;
        }
        .btn-primary {
            background-color: #2CA1B5;
            border-color: #2CA1B5;
        }
        .btn-primary:hover {
            background-color: #1e8291;
            border-color: #1e8291;
        }
        .btn-outline-primary {
            color: #2CA1B5;
            border-color: #2CA1B5;
        }
        .btn-outline-primary:hover {
            background-color: #2CA1B5;
            color: white;
        }
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .card-header {
            background-color: #2CA1B5 !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .card {
            border-radius: 0.5rem !important;
            overflow: hidden;
            width: 100%;
        }
        .table th, .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }
        .btn-sm {
            padding: 0.35rem 1rem;
            font-size: 0.9rem;
        }

          /* Ajustes para centrar y hacer más estrecha la tabla en responsivo vertical (< 1056px) */
        @media (max-width: 1056px) {
            .col-md-5 {
                width: 100%; /* Ancho completo en responsivo */
                padding: 0 15px; /* Márgenes simétricos en los lados */
                box-sizing: border-box; /* Incluir padding en el ancho */
            }
            .card {
                margin: 0 auto; /* Centrar la card horizontalmente */
                max-width: 95%; /* Reducir ancho para centrar con bordes visibles */
                overflow: visible; /* Asegurar que no se corte */
            }
            .table-responsive {
                overflow-x: auto; /* Permitir scroll horizontal si la tabla es ancha */
            }
            .table {
                width: 95%; /* Hacer la tabla más estrecha para centrado */
                margin: 0 auto; /* Centrar la tabla dentro de la card */
                font-size: 0.9rem; /* Reducir tamaño de fuente para ajuste */
            }
        }

        /* Ajustes responsive para pantallas menores a 768px (vertical, ~11 pulgadas) */
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5rem; /* Tamaño de fuente igual al de Historial de Pedidos */
            }

            .btn-primary {
                font-size: 0.85rem; /* Tamaño de fuente más pequeño */
                padding: 6px 12px; /* Padding ajustado */
                width: 100%; /* Botón ocupa todo el ancho */
                margin-bottom: 10px; /* Espacio inferior */
                text-align: center; /* Asegurar texto centrado */
            }

            .text-center.py-5 {
                padding: 20px; /* Padding consistente con el mensaje de no pedidos */
                font-size: 1rem; /* Tamaño de fuente ajustado */
            }
        }

    </style>
    <script>
        $(document).ready(function() {
            // Función para obtener valores válidos de cilindro para lentillas
            function getValidCilLentillas() {
                let vals = [0];
                for (let i = 0.75; i <= 20; i += 0.5) {
                    vals.push(-i);
                }
                return vals;
            }

            // Habilitar/deshabilitar inputs según selección de tipo
            function toggleInputs(tipoGraduacion) {
                const inputs = ['od_esfera', 'os_esfera', 'od_cilindro', 'os_cilindro', 'od_eje', 'os_eje', 'od_adicion', 'os_adicion'];
                if (!tipoGraduacion) {
                    inputs.forEach(id => $(`#${id}`).prop('disabled', true));
                } else {
                    inputs.forEach(id => $(`#${id}`).prop('disabled', false));
                    // Ajustar cilindro para lentillas
                    ['od', 'os'].forEach(function(eye) {
                        var cilInput = $(`#${eye}_cilindro`);
                        if (tipoGraduacion === 'Lentillas') {
                            cilInput.attr('step', '0.01');
                            cilInput.attr('max', '0');
                            cilInput.on('input', function() {
                                let cil = this;
                                let newVal = parseFloat(cil.value) || 0;
                                let prevVal = parseFloat(cil.dataset.prevValue) || 0;
                                let direction = newVal - prevVal;
                                let validVals = getValidCilLentillas();
                                let setVal = function(val) {
                                    cil.value = val.toFixed(2);
                                    cil.dataset.prevValue = val;
                                };
                                if (Math.abs(direction) <= 0.01 + Number.EPSILON) { // arrow click
                                    if (direction > 0) {
                                        let next = validVals.filter(v => v > prevVal).sort((a, b) => a - b)[0];
                                        if (next !== undefined) {
                                            setVal(next);
                                        } else {
                                            setVal(prevVal);
                                        }
                                    } else if (direction < 0) {
                                        let next = validVals.filter(v => v < prevVal).sort((a, b) => b - a)[0];
                                        if (next !== undefined) {
                                            setVal(next);
                                        } else {
                                            setVal(prevVal);
                                        }
                                    } else {
                                        setVal(prevVal);
                                    }
                                } else { // manual entry
                                    let closest = validVals.reduce((prev, curr) => Math.abs(curr - newVal) < Math.abs(prev - newVal) ? curr : prev);
                                    setVal(closest);
                                }
                            });
                            cilInput[0].dataset.prevValue = parseFloat(cilInput.val()) || 0;
                        } else {
                            cilInput.attr('step', '0.25');
                            cilInput.attr('max', '20');
                            cilInput.off('input');
                        }
                    });
                    // Mostrar/ocultar adición
                    if (tipoGraduacion === 'Gafa de lejos' || tipoGraduacion === 'Gafa de cerca') {
                        $('#od_adicion_container, #os_adicion_container').hide();
                        $('#od_adicion, #os_adicion').val('');
                    } else {
                        $('#od_adicion_container, #os_adicion_container').show();
                    }
                }
            }

            // Bloquear inputs al intentar interactuar sin tipo seleccionado
            $('#od_esfera, #os_esfera, #od_cilindro, #os_cilindro, #od_eje, #os_eje, #od_adicion, #os_adicion').on('focus', function() {
                if (!$('#nombre').val()) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'Por favor, selecciona primero el tipo de graduación.',
                        icon: 'warning',
                        confirmButtonColor: '#2CA1B5',
                        customClass: {
                            popup: 'swal2-custom'
                        }
                    });
                    $('#nombre').addClass('error-border');
                    setTimeout(() => $('#nombre').removeClass('error-border'), 2000);
                    $(this).blur();
                }
            });

            // Manejar modal para crear/editar
            $('#graduacionModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var action = button.data('action');
                var modal = $(this);
                var form = modal.find('#graduacionForm');
                var methodField = form.find('#formMethod');

                if (action === 'crear') {
                    modal.find('.modal-title').text('Nueva Graduación');
                    form.attr('action', '{{ route('graduacion.guardar') }}');
                    methodField.val('POST');
                    form.find('input:not([type=hidden])').val('');
                    form.find('#nombre').val('');
                    form.find('#od_esfera').val('0.00');
                    form.find('#os_esfera').val('0.00');
                    form.find('#od_cilindro').val('0.00');
                    form.find('#os_cilindro').val('0.00');
                    form.find('#od_eje').val('0');
                    form.find('#os_eje').val('0');
                    form.find('#od_adicion').val('0.00');
                    form.find('#os_adicion').val('0.00');
                    toggleInputs('');
                } else if (action === 'editar') {
                    var graduacion = button.data('graduacion');
                    modal.find('.modal-title').text('Editar Graduación');
                    form.attr('action', '{{ url('graduacion') }}/' + graduacion.id);
                    methodField.val('PUT');
                    form.find('#nombre').val(graduacion.nombre || '');
                    form.find('#od_esfera').val(graduacion.od_esfera || '0.00');
                    form.find('#od_cilindro').val(graduacion.od_cilindro || '0.00');
                    form.find('#od_eje').val(graduacion.od_eje || '0');
                    form.find('#od_adicion').val(graduacion.od_adicion || '0.00');
                    form.find('#os_esfera').val(graduacion.os_esfera || '0.00');
                    form.find('#os_cilindro').val(graduacion.os_cilindro || '0.00');
                    form.find('#os_eje').val(graduacion.os_eje || '0');
                    form.find('#os_adicion').val(graduacion.os_adicion || '0.00');
                    toggleInputs(graduacion.nombre || '');
                }
            });

            // Limpiar modal al cerrar
            $('#graduacionModal').on('hidden.bs.modal', function () {
                var form = $(this).find('#graduacionForm');
                form.find('input:not([type=hidden])').val('');
                form.find('#nombre').val('');
                form.find('#od_esfera').val('0.00');
                form.find('#os_esfera').val('0.00');
                form.find('#od_cilindro').val('0.00');
                form.find('#os_cilindro').val('0.00');
                form.find('#od_eje').val('0');
                form.find('#os_eje').val('0');
                form.find('#od_adicion').val('0.00');
                form.find('#os_adicion').val('0.00');
                form.find('#formMethod').val('POST');
                $('#od_adicion_container, #os_adicion_container').show();
                toggleInputs('');
                $('#nombre').removeClass('error-border');
            });

            // Manejar cambio en el desplegable de tipo
            $('#nombre').on('change', function () {
                toggleInputs($(this).val());
            });

            // Mostrar confirmación antes de guardar
            $('#graduacionForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Confirmar?',
                    text: '¿Estás seguro de guardar esta graduación?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2CA1B5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        popup: 'swal2-custom'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var method = form.find('input[name="_method"]').val() || 'POST';
                        $.ajax({
                            url: form.attr('action'),
                            method: method,
                            data: form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: response.message || 'Graduación guardada correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal2-custom'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                                $('#graduacionModal').modal('hide');
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Error al guardar la graduación.',
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    customClass: {
                                        popup: 'swal2-custom-error'
                                    }
                                });
                            }
                        });
                    }
                });
            });

            // Manejar eliminación con SweetAlert2
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres eliminar esta graduación?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2CA1B5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        popup: 'swal2-custom'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'DELETE',
                            data: {
                                _token: form.find('input[name="_token"]').val()
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: response.message || 'Graduación eliminada correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal2-custom'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Error al eliminar la graduación.',
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    customClass: {
                                        popup: 'swal2-custom-error'
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection