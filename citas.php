<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Citas - FISIOMAR</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div id="wrapper" class="d-flex min-vh-100">
        <!-- Modal Reprogramar Cita -->
        <div class="modal fade" id="modalReprogramar" tabindex="-1" aria-labelledby="modalReprogramarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReprogramarLabel">Reprogramar cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formReprogramar">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="reproPaciente" class="form-label">Paciente</label>
                                <input type="text" class="form-control" id="reproPaciente" name="reproPacienteNombre" disabled>
                                <input type="hidden" id="reproPacienteHidden" name="reproPaciente">
                            </div>
                            <div class="mb-3">
                                <label for="reproFecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="reproFecha" name="reproFecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="reproHora" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="reproHora" name="reproHora" required>
                            </div>
                            <div class="mb-3">
                                <label for="reproMotivo" class="form-label">Motivo</label>
                                <textarea class="form-control" id="reproMotivo" name="reproMotivo" rows="2" required></textarea>
                            </div>
                            <input type="hidden" id="reproIdCita" name="reproIdCita">
                            <input type="hidden" id="id_paciente" name="id_paciente" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success">Guardar cambios</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-pink text-white d-flex flex-column h-auto flex-shrink-0" style="overflow-y: auto; min-width: 220px;">
                <?php include 'menu.php'; ?>
        </div>
        <div id="content-wrapper" class="flex-grow-1 d-flex flex-column" style="overflow-y: auto;">
                <?php include 'encabezado.php'; ?>
                <div id="content" class="container-fluid flex-grow-1">
                        <div class="p-4">
                                <!-- Encabezado principal -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h1 class="h3 mb-0">Citas</h1>
                                        <button id="btnNuevaCita" class="btn btn-outline-primary btn-lg"><i class="bi bi-calendar-plus me-2"></i>Registrar nueva cita</button>
                                </div>

                                <!-- Formulario de nueva cita (modal) -->
                                <div class="modal fade" id="modalCita" tabindex="-1" aria-labelledby="modalCitaLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCitaLabel">Registrar nueva cita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <form id="formCita">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="citaPaciente" class="form-label">Paciente</label>
                                                        <select class="form-select" id="citaPaciente" name="citaPaciente" required>
                                                            <option value="">Seleccione un paciente...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="citaFecha" class="form-label">Fecha</label>
                                                        <input type="date" class="form-control" id="citaFecha" name="citaFecha" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="citaHora" class="form-label">Hora</label>
                                                        <input type="time" class="form-control" id="citaHora" name="citaHora" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="citaMotivo" class="form-label">Motivo</label>
                                                        <textarea class="form-control" id="citaMotivo" name="citaMotivo" rows="2" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="citaEstado" class="form-label">Estado</label>
                                                        <select class="form-select" id="citaEstado" name="citaEstado" required>
                                                            <option value="Programada" selected>Programada</option>
                                                            <option value="Reprogramada">Reprogramada</option>
                                                            <option value="Cancelada">Cancelada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-success">Confirmar</button>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selector de tabla por estado -->
                                <div class="card mb-3">
                                    <div class="card-body py-3">
                                        <div class="btn-group" role="group" aria-label="Selector de tablas de citas">
                                            <button type="button" class="btn btn-outline-primary btn-tabla-citas active" data-tabla="programadas">Programadas</button>
                                            <button type="button" class="btn btn-outline-success btn-tabla-citas" data-tabla="realizadas">Realizadas</button>
                                            <button type="button" class="btn btn-outline-warning btn-tabla-citas" data-tabla="reprogramadas">Reprogramadas</button>
                                            <button type="button" class="btn btn-outline-danger btn-tabla-citas" data-tabla="canceladas">Canceladas</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de citas programadas -->
                                <div class="card mb-4" id="cardTablaProgramadas">
                                    <div class="card-header bg-white">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h2 class="h5 mb-0 me-2">Citas Programadas</h2>
                                            <input type="text" class="form-control form-control-sm filtro-paciente" placeholder="Buscar paciente..." style="max-width:220px;">
                                            <input type="date" class="form-control form-control-sm filtro-fecha" style="max-width:170px;">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="tablaCitas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Motivo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="5" class="text-center text-muted">Sin citas registradas.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabla de citas realizadas -->
                                <div class="card mb-4 d-none" id="cardTablaRealizadas">
                                    <div class="card-header bg-white">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h2 class="h5 mb-0 me-2">Citas Realizadas</h2>
                                            <input type="text" class="form-control form-control-sm filtro-paciente" placeholder="Buscar paciente..." style="max-width:220px;">
                                            <input type="date" class="form-control form-control-sm filtro-fecha" style="max-width:170px;">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="tablaCitasRealizadas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="3" class="text-center text-muted">Sin citas realizadas.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabla de citas reprogramadas -->
                                <div class="card mb-4 d-none" id="cardTablaReprogramadas">
                                    <div class="card-header bg-white">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h2 class="h5 mb-0 me-2">Citas Reprogramadas</h2>
                                            <input type="text" class="form-control form-control-sm filtro-paciente" placeholder="Buscar paciente..." style="max-width:220px;">
                                            <input type="date" class="form-control form-control-sm filtro-fecha" style="max-width:170px;">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="tablaCitasReprogramadas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="3" class="text-center text-muted">Sin citas reprogramadas.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabla de citas canceladas -->
                                <div class="card mb-4 d-none" id="cardTablaCanceladas">
                                    <div class="card-header bg-white">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h2 class="h5 mb-0 me-2">Citas Canceladas</h2>
                                            <input type="text" class="form-control form-control-sm filtro-paciente" placeholder="Buscar paciente..." style="max-width:220px;">
                                            <input type="date" class="form-control form-control-sm filtro-fecha" style="max-width:170px;">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="tablaCitasCanceladas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="3" class="text-center text-muted">Sin citas canceladas.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                </div>
        </div>
</div>

<!-- JS y lógica -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="funcionesJS.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
                function mostrarTablaCitas(tablaSeleccionada) {
                    var mapaTarjetas = {
                        programadas: '#cardTablaProgramadas',
                        realizadas: '#cardTablaRealizadas',
                        reprogramadas: '#cardTablaReprogramadas',
                        canceladas: '#cardTablaCanceladas'
                    };

                    Object.keys(mapaTarjetas).forEach(function (clave) {
                        if (clave === tablaSeleccionada) {
                            $(mapaTarjetas[clave]).removeClass('d-none');
                        } else {
                            $(mapaTarjetas[clave]).addClass('d-none');
                        }
                    });

                    $('.btn-tabla-citas').removeClass('active');
                    $('.btn-tabla-citas[data-tabla="' + tablaSeleccionada + '"]').addClass('active');
                }

                $(document).off('click', '.btn-tabla-citas').on('click', '.btn-tabla-citas', function () {
                    var tabla = String($(this).data('tabla') || 'programadas');
                    mostrarTablaCitas(tabla);
                });

                // Estado inicial: mostrar solo Programadas
                mostrarTablaCitas('programadas');

                // Handler para eliminar cita
                $(document).off('click', '.btn-eliminar-cita').on('click', '.btn-eliminar-cita', function() {
                    var idCita = Number($(this).data('id') || 0);
                    if (!idCita) {
                        iziToast.error({ title: 'Error', message: 'No se pudo identificar la cita.', position: 'topRight' });
                        return;
                    }
                    iziToast.question({
                        title: 'Eliminar cita',
                        message: '¿Estás seguro de eliminar esta cita?',
                        position: 'center',
                        timeout: false,
                        overlay: true,
                        closeOnOverlayClick: false,
                        buttons: [
                            ['<button>Sí, eliminar</button>', function (instance, toast) {
                                instance.hide({}, toast);
                                $.ajax({
                                    url: 'acciones_citas.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: { accion: 'eliminarCita', id_cita: idCita },
                                    success: function(response) {
                                        if (response && response.success) {
                                            obtenerCitas();
                                            iziToast.success({ title: 'Eliminada', message: response.message || 'Cita eliminada correctamente.', position: 'topRight' });
                                        } else {
                                            iziToast.error({ title: 'Error', message: response.message || 'Error al eliminar la cita.', position: 'topRight' });
                                        }
                                    },
                                    error: function() {
                                        iziToast.error({ title: 'Error', message: 'Error de conexión al eliminar la cita.', position: 'topRight' });
                                    }
                                });
                            }],
                            ['<button>Cancelar</button>', function (instance, toast) {
                                instance.hide({}, toast);
                            }]
                        ]
                    });
                });
        poblarSelectPacientes();
        obtenerCitas();
        $('#btnNuevaCita').off('click').on('click', function () {
            $('#formCita')[0].reset();
            $('#modalCita').modal('show');
        });
        // Handler para guardar cita
        $('#formCita').off('submit').on('submit', function(e) {
            e.preventDefault();
            guardarCita();
        });
        // Handler para reprogramar cita
        $(document).off('click', '.btn-reprogramar').on('click', '.btn-reprogramar', function() {
            var idCita = $(this).data('id');
            cargarDatosCita(idCita, function(cita) {
                if (!cita) {
                    iziToast.error({ title: 'Error', message: 'No se pudo cargar la cita.', position: 'topRight' });
                    return;
                }
                $('#reproIdCita').val(cita.id_cita);
                $('#reproPaciente').val(cita.paciente);
                $('#reproPacienteHidden').val(cita.id_paciente);
                $('#reproFecha').val(cita.fecha);
                $('#reproHora').val(cita.hora);
                $('#reproMotivo').val(cita.motivo);
                $('#modalReprogramar').modal('show');
            });
        });
        // Handler para guardar reprogramación
        $('#formReprogramar').off('submit').on('submit', function(e) {
            e.preventDefault();
            var datos = {
                accion: 'editarCita',
                id_cita: $('#reproIdCita').val(),
                id_paciente: $('#reproPacienteHidden').val(),
                fecha: $('#reproFecha').val(),
                hora: $('#reproHora').val(),
                estado: 'Reprogramada'
            };
            $.ajax({
                url: 'acciones_citas.php',
                method: 'POST',
                dataType: 'json',
                data: datos,
                success: function(response) {
                    if (response && response.success) {
                        $('#modalReprogramar').modal('hide');
                        obtenerCitas();
                        iziToast.success({ title: 'Éxito', message: response.message || 'Cita reprogramada correctamente.', position: 'topRight' });
                    } else {
                        iziToast.error({ title: 'Error', message: response.message || 'Error al reprogramar la cita.', position: 'topRight' });
                    }
                },
                error: function() {
                    iziToast.error({ title: 'Error', message: 'Error de conexión al reprogramar la cita.', position: 'topRight' });
                }
            });
        });

        // Filtrar al escribir/cambiar los inputs de paciente y fecha
        $(document).on('input change', '.filtro-paciente, .filtro-fecha', function() {
            var cardId = '#' + $(this).closest('.card').attr('id');
            filtrarTablaCitas(cardId);
        });
    });

        // Poblar select de pacientes al cargar la página
        function poblarSelectPacientes() {
            CargarPX(function(pacientes) {
                var $select = $('#citaPaciente');
                $select.empty();
                $select.append('<option value="">Seleccione un paciente...</option>');
                pacientes.forEach(function(px) {
                    var nombreCompleto = [px.nombre || '', px.apellido || ''].join(' ').trim();
                    $select.append('<option value="' + px.id_paciente + '">' + nombreCompleto + '</option>');
                });
            });
        } 

        // Guardar cita (conexión backend)
        function guardarCita() {
            $.ajax({
                url: 'acciones_citas.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    id_paciente: $('#citaPaciente').val(),
                    fecha: $('#citaFecha').val(),
                    hora: $('#citaHora').val(),
                    motivo: $('#citaMotivo').val(),
                    estado: $('#citaEstado').val(),
                    accion: 'crearCita'
                },
                success: function(response) {
                    if (response && response.success) {
                        $('#formCita')[0].reset();
                        $('#modalCita').modal('hide');
                        obtenerCitas();
                        iziToast.success({ title: 'Éxito', message: response.message || 'Cita registrada correctamente.', position: 'topRight' });
                    } else {
                        iziToast.error({ title: 'Error', message: response.message || 'Error al guardar la cita.', position: 'topRight' });
                    }
                },
            });     
        }

        // Función para formatear fecha dd/mm/yyyy
        function formatearFecha(fechaISO) {
            if (!fechaISO) return '';
            var partes = fechaISO.split('-');
            if (partes.length === 3) {
                return partes[2] + '/' + partes[1] + '/' + partes[0];
            }
            return fechaISO;
        }

        // Funcion Obtener citas 
        function obtenerCitas() {
            $.ajax({
                url: 'acciones_citas.php',
                method: 'POST',
                dataType: 'json',
                data: { accion: 'obtenerCitasPorEstado' }
            }).done(function (response) {
                if (response && response.success && response.data) {
                    var programadas = Array.isArray(response.data.Programada) ? response.data.Programada : [];
                    var realizadas = Array.isArray(response.data.Realizada) ? response.data.Realizada : [];
                    var reprogramadas = Array.isArray(response.data.Reprogramada) ? response.data.Reprogramada : [];
                    var canceladas = Array.isArray(response.data.Cancelada) ? response.data.Cancelada : [];

                    // Carga global de las 4 tablas por estado
                    pintarTablaCitas(programadas);
                    filtrarTablaCitas('#cardTablaProgramadas');
                    pintarTablaCitasRealizadas(realizadas);
                    filtrarTablaCitas('#cardTablaRealizadas');
                    pintarTablaCitasReprogramadas(reprogramadas);
                    filtrarTablaCitas('#cardTablaReprogramadas');
                    pintarTablaCitasCanceladas(canceladas);
                    filtrarTablaCitas('#cardTablaCanceladas');
                    pintarCalendarioCitas(programadas);
                } else {
                    pintarTablaCitas([]);
                    pintarTablaCitasRealizadas([]);
                    pintarTablaCitasReprogramadas([]);
                    pintarTablaCitasCanceladas([]);
                    pintarCalendarioCitas([]);
                }
            }).fail(function () {
                pintarTablaCitas([]);
                pintarTablaCitasRealizadas([]);
                pintarTablaCitasReprogramadas([]);
                pintarTablaCitasCanceladas([]);
                pintarCalendarioCitas([]);
            });
        }

        // Función global para pintar una tabla de citas por estado
        function pintarTablaEstado(selectorTabla, citas, mensajeVacio, incluirAcciones) {
            var tbody = $(selectorTabla + ' tbody');
            tbody.empty();

            if (!citas.length) {
                tbody.append('<tr><td colspan="' + (incluirAcciones ? 6 : 3) + '" class="text-center text-muted">' + mensajeVacio + '</td></tr>');
                return;
            }

            citas.forEach(function(cita) {
                var fechaFormateada = formatearFecha(cita.fecha);
                var row = '<tr data-paciente="' + (cita.paciente || '') + '" data-fecha="' + (cita.fecha || '') + '">' +
                    '<td>' + cita.paciente + '</td>' +
                    '<td>' + fechaFormateada + '</td>' +
                    '<td>' + cita.hora + '</td>';

                if (incluirAcciones) {
                    row += '<td>' + (cita.motivo || '') + '</td>' +
                        '<td>' +
                            '<button class="btn btn-sm btn-outline-warning me-1 btn-reprogramar" data-id="' + cita.id_cita + '" title="Reprogramar"><i class="bi bi-calendar-event"></i></button>' +
                            '<button class="btn btn-sm btn-outline-danger btn-eliminar-cita" data-id="' + cita.id_cita + '" title="Eliminar"><i class="bi bi-trash"></i></button>' +
                        '</td>';
                }

                row += '</tr>';
                tbody.append(row);
            });
        }

        // Función para pintar la tabla de citas
        function pintarTablaCitas(citas) {
            pintarTablaEstado('#tablaCitas', citas, 'Sin citas registradas.', true);
        }

        function pintarTablaCitasRealizadas(citas) {
            pintarTablaEstado('#tablaCitasRealizadas', citas, 'Sin citas realizadas.', false);
        }

        function pintarTablaCitasReprogramadas(citas) {
            pintarTablaEstado('#tablaCitasReprogramadas', citas, 'Sin citas reprogramadas.', false);
        }

        function pintarTablaCitasCanceladas(citas) {
            pintarTablaEstado('#tablaCitasCanceladas', citas, 'Sin citas canceladas.', false);
        }

        // Filtra las filas visibles de una tarjeta por paciente y/o fecha
        function filtrarTablaCitas(cardSelector) {
            var $card = $(cardSelector);
            var textoPaciente = ($card.find('.filtro-paciente').val() || '').toLowerCase().trim();
            var fechaFiltro = $card.find('.filtro-fecha').val() || '';
            $card.find('tbody tr').each(function() {
                var $tr = $(this);
                // Fila de estado vacío (colspan): siempre visible
                if ($tr.find('td[colspan]').length) { $tr.show(); return; }
                var paciente = ($tr.data('paciente') || '').toString().toLowerCase();
                var fecha    = ($tr.data('fecha')    || '').toString();
                var coincidePaciente = !textoPaciente || paciente.indexOf(textoPaciente) !== -1;
                var coincideFecha    = !fechaFiltro   || fecha === fechaFiltro;
                $tr.toggle(coincidePaciente && coincideFecha);
            });
        }

        // Función global para cargar datos de cita por id
        function cargarDatosCita(idCita, callback) {
            $.ajax({
                url: 'acciones_citas.php',
                method: 'POST',
                dataType: 'json',
                data: { accion: 'obtenerCitas', id_cita: idCita },
                success: function(response) {
                    if (response && response.success && Array.isArray(response.data)) {
                        var cita = response.data.find(function(c) { return c.id_cita == idCita; });
                        if (typeof callback === 'function') callback(cita);
                    } else {
                        if (typeof callback === 'function') callback(null);
                    }
                },
                error: function() {
                    if (typeof callback === 'function') callback(null);
                }
            });
        }

        // Función para pintar el calendario/próximas citas
        function pintarCalendarioCitas(citas) {
            var cont = $('#proximasCitas');
            cont.empty();
            if (!citas.length) return;
            citas.forEach(function(cita) {
                var fechaFormateada = formatearFecha(cita.fecha);
                var card = '<div class="col-12 col-md-6 col-lg-4">' +
                    '<div class="card border-primary mb-2">' +
                        '<div class="card-body p-2">' +
                            '<div class="fw-bold">' + cita.paciente + '</div>' +
                            '<div><i class="bi bi-calendar-event me-1"></i>' + fechaFormateada + ' ' + cita.hora + '</div>' +
                            '<div class="small text-muted">' + cita.motivo + '</div>' +
                            '<span class="badge bg-' + (cita.estado === 'Programada' ? 'primary' : cita.estado === 'Realizada' ? 'success' : 'warning') + ' float-end">' + cita.estado + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>';
                cont.append(card);
            });
        }

</script>
</body>
</html>
