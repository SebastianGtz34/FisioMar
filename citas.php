<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Citas - FISIOMAR</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body class="bg-light">
<div id="wrapper" class="d-flex min-vh-100">
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
                                        <button id="btnNuevaCita" class="btn btn-primary btn-lg"><i class="bi bi-calendar-plus me-2"></i>Registrar nueva cita</button>
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
                                                            <option value="Programada">Programada</option>
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

                                <!-- Calendario/Próximas citas -->
                                <div class="card">
                                    <div class="card-header bg-white">
                                        <h2 class="h5 mb-0">Próximas Citas</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2" id="proximasCitas">
                                            <!-- Aquí se mostrarán las próximas citas -->
                                        </div>
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
        poblarSelectPacientes();
        obtenerCitas();
        document.getElementById('btnNuevaCita').addEventListener('click', function () {
            document.getElementById('formCita').reset();
            $('#modalCita').modal('show');
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
                        //$('#modalCita').modal('hide');
                        //obtenerCitas();
                        
                    } else {
                        swalalert('Error', response.message || 'Error al guardar la cita.', 'error');

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
                        '<button class="btn btn-sm btn-info me-1">Ver</button>' +
                        '<button class="btn btn-sm btn-warning me-1">Editar</button>' +
                        '<button class="btn btn-sm btn-danger">Eliminar</button>' +
                    '</td>' +
                '</tr>';
                tbody.append(row);
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
                            '<span class="badge bg-' + (cita.estado === 'Programada' ? 'primary' : cita.estado === 'Realizada' ? 'success' : 'danger') + ' float-end">' + cita.estado + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>';
                cont.append(card);
            });
        }
</script>
</body>
</html>
