<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Citas - FISIOMAR</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                                    <div hidden id="accion" value="crearCita"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-success">Confirmar</button>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de citas -->
                                <div class="card mb-4">
                                    <div class="card-header bg-white">
                                        <h2 class="h5 mb-0">Listado de Citas</h2>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="tablaCitas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Motivo</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="6" class="text-center text-muted">Sin citas registradas.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabla de citas realizadas -->
                                <div class="card mb-4">
                                    <div class="card-header bg-white">
                                        <h2 class="h5 mb-0">Citas Realizadas</h2>
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
                        </div>
                </div>
        </div>
</div>

<!-- JS y lógica -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="funcionesJS.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
                        // Cargar citas realizadas al iniciar
                        cargarCitasRealizadas();

                        function cargarCitasRealizadas() {
                            $.ajax({
                                url: 'acciones_citas.php',
                                method: 'POST',
                                dataType: 'json',
                                data: { accion: 'obtenerCitasRealizadas' },
                                success: function(response) {
                                    if (response && response.success && Array.isArray(response.data)) {
                                        pintarTablaCitasRealizadas(response.data);
                                    } else {
                                        pintarTablaCitasRealizadas([]);
                                    }
                                },
                                error: function() {
                                    pintarTablaCitasRealizadas([]);
                                }
                            });
                        }

                        function pintarTablaCitasRealizadas(citas) {
                            var tbody = $('#tablaCitasRealizadas tbody');
                            tbody.empty();
                            if (!citas.length) {
                                tbody.append('<tr><td colspan="3" class="text-center text-muted">Sin citas realizadas.</td></tr>');
                                return;
                            }
                            citas.forEach(function(cita) {
                                var fechaFormateada = formatearFecha(cita.fecha);
                                var row = '<tr>' +
                                    '<td>' + cita.paciente + '</td>' +
                                    '<td>' + fechaFormateada + '</td>' +
                                    '<td>' + cita.hora + '</td>' +
                                '</tr>';
                                tbody.append(row);
                            });
                        }
                // Handler para eliminar cita
                $(document).off('click', '.btn-outline-danger').on('click', '.btn-outline-danger', function() {
                    var row = $(this).closest('tr');
                    var idCita = row.find('.btn-reprogramar').data('id');
                    if (!idCita) {
                        Swal.fire('Error', 'No se pudo identificar la cita.', 'error');
                        return;
                    }
                    Swal.fire({
                        title: '¿Eliminar cita?',
                        text: '¿Estás seguro de eliminar esta cita?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'acciones_citas.php',
                                method: 'POST',
                                dataType: 'json',
                                data: { accion: 'eliminarCita', id_cita: idCita },
                                success: function(response) {
                                    if (response && response.success) {
                                        obtenerCitas();
                                        Swal.fire('Eliminada', response.message || 'Cita eliminada correctamente.', 'success');
                                    } else {
                                        Swal.fire('Error', response.message || 'Error al eliminar la cita.', 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error', 'Error de conexión al eliminar la cita.', 'error');
                                }
                            });
                        }
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
                    Swal.fire('Error', 'No se pudo cargar la cita.', 'error');
                    return;
                }
                $('#reproIdCita').val(cita.id_cita);
                $('#reproPaciente').val(cita.id_paciente);
                $('#id_paciente').val(cita.id_paciente);
                $('#reproPacienteNombre').val(cita.paciente);
                $('#reproFecha').val(cita.fecha);
                $('#reproHora').val(cita.hora);
                $('#reproMotivo').val(cita.motivo);
                $('#reproEstado').val('Reprogramada'); 
                $('#id_usuario').val(getCookie('id_usuario'));
                $('#modalReprogramar').modal('show');
            });
        });
        // Handler para guardar reprogramación
        $('#formReprogramar').off('submit').on('submit', function(e) {
            e.preventDefault();
            var datos = {
                accion: 'editarCita',
                id_cita: $('#reproIdCita').val(),
                id_paciente: $('#reproPaciente').val(),
                fecha: $('#reproFecha').val(),
                hora: $('#reproHora').val(),
                motivo: $('#reproMotivo').val(),
                estado: 'Reprogramada',
                id_usuario: $('#id_usuario').val()
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
                        Swal.fire('Éxito', response.message || 'Cita reprogramada correctamente.', 'success');
                    } else {
                        Swal.fire('Error', response.message || 'Error al reprogramar la cita.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error de conexión al reprogramar la cita.', 'error');
                }
            });
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
                        Swal.fire('Éxito', response.message || 'Cita registrada correctamente.', 'success');
                    } else {
                        Swal.fire('Error', response.message || 'Error al guardar la cita.', 'error');
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
                data: { accion: 'obtenerCitas' }
            }).done(function (response) {
                if (response && response.success && Array.isArray(response.data)) {
                    pintarTablaCitas(response.data);
                    pintarCalendarioCitas(response.data);
                } else {
                    pintarTablaCitas([]);
                    pintarCalendarioCitas([]);
                }
            }).fail(function () {
                pintarTablaCitas([]);
                pintarCalendarioCitas([]);
            });
        }

        // Función para pintar la tabla de citas
        function pintarTablaCitas(citas) {
            var tbody = $('#tablaCitas tbody');
            tbody.empty();
            if (!citas.length) {
                tbody.append('<tr><td colspan="6" class="text-center text-muted">Sin citas registradas.</td></tr>');
                return;
            }
            citas.forEach(function(cita) {
                var fechaFormateada = formatearFecha(cita.fecha);
                var row = '<tr>' +
                    '<td>' + cita.paciente + '</td>' +
                    '<td>' + fechaFormateada + '</td>' +
                    '<td>' + cita.hora + '</td>' +
                    '<td>' + cita.motivo + '</td>' +
                    '<td>' + cita.estado + '</td>' +
                    '<td>' +
                        '<button class="btn btn-sm btn-outline-warning me-1 btn-reprogramar" data-id="' + cita.id_cita + '">Reprogramar</button>' +
                        '<button class="btn btn-sm btn-outline-danger">Eliminar</button>' +
                    '</td>' +
                '</tr>';
                tbody.append(row);
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

        // Función para obtener el valor de una cookie
        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
            return '';
        }
</script>
</body>
</html>
