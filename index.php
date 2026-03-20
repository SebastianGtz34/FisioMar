<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FISIOMAR - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<!-- Page Wrapper -->
<div id="wrapper" class="d-flex min-vh-100" style="height: 100vh;">
    <!-- Menú lateral -->
    <div class="bg-pink d-flex flex-column" style="min-width: 220px; height: 100vh; overflow-y: auto;">
        <?php include 'menu.php'; ?>
    </div>
    <!-- Área principal -->
    <div id="content-wrapper" class="flex-grow-1 d-flex flex-column" style="height: 100vh; overflow-y: auto;">
        <!-- Encabezado -->
        <?php include 'encabezado.php'; ?>
        <!-- Contenido principal -->
        <div id="content" class="container-fluid flex-grow-1">
            <div class="p-4">
                <!-- SECCIÓN INICIO -->
                <section id="section-inicio" class="page-section">
                    <!-- MÉTRICAS -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-primary h-100">
                                <div class="card-body">
                                    <small class="d-block">Pacientes Activos:</small>
                                    <h2 class="h3 mb-0" id="metricaPacientesActivos">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-warning h-100">
                                <div class="card-body">
                                    <small class="d-block">Citas del Día:</small>
                                    <h2 class="h3 mb-0" id="metricaCitasDia">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-success h-100">
                                <div class="card-body">
                                    <small class="d-block">Sesiones Realizadas:</small>
                                    <h2 class="h3 mb-0" id="metricaSesiones">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <!-- CITAS DE HOY -->
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h2 class="h5 mb-0">Citas de Hoy</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2" id="citasHoyCards">
                                        <!-- Aquí se mostrarán las citas de hoy -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal: confirmar cita finalizada y registrar bitácora -->
                            <div class="modal fade" id="modalBitacoraCita" tabindex="-1" aria-labelledby="modalBitacoraCitaLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title h5" id="modalBitacoraCitaLabel">Finalizar Cita y Registrar Bitácora</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <form id="formBitacoraCita">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Paciente</label>
                                                    <input type="text" class="form-control" id="bitacoraPaciente" disabled>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-12 col-md-6">
                                                        <label for="bitacoraDiagnostico" class="form-label">Diagnóstico</label>
                                                        <textarea class="form-control" id="bitacoraDiagnostico" rows="3" required></textarea>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="bitacoraAntecedentes" class="form-label">Antecedentes</label>
                                                        <textarea class="form-control" id="bitacoraAntecedentes" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="bitacoraExploracion" class="form-label">Exploración</label>
                                                        <textarea class="form-control" id="bitacoraExploracion" rows="3" required></textarea>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="bitacoraTratamiento" class="form-label">Tratamiento</label>
                                                        <textarea class="form-control" id="bitacoraTratamiento" rows="3" required></textarea>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="bitacoraIdCita">
                                                <input type="hidden" id="bitacoraIdPaciente">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-outline-success">Confirmar y Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- TABLA DE PACIENTES -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h2 class="h5 mb-0">Lista de Pacientes Activos</h2>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Prox. Cita</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id="rowSinPacientes">
                                            <td colspan="4" class="text-center text-muted">Sin pacientes activos.</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="funcionesJS.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>

<script>
    $(function () {
        var modalBitacoraEl = document.getElementById('modalBitacoraCita');
        var modalBitacora = new bootstrap.Modal(modalBitacoraEl);

        function recargarPanelInicio() {
            CargarCitasHoy(function(citasHoy) {
                pintarTarjetasCitasHoy(citasHoy);
                $('#metricaCitasDia').text(citasHoy.length);
            });

            CargarTotalSesionesRealizadas(function(total) {
                $('#metricaSesiones').text(total);
            });
        }

        // Cargar y mostrar pacientes reales al iniciar
        CargarPX(function(pacientes) {
            pintarTablaPacientes(pacientes);
            pintarMetricas(pacientes);
        });

        // Cargar y mostrar citas de hoy al iniciar
        recargarPanelInicio();

        function pintarTarjetasCitasHoy(citas) {
            var contenedor = $('#citasHoyCards');
            contenedor.empty();

            if (!citas.length) {
                contenedor.append(
                    '<div class="col-12">' +
                        '<div class="alert alert-light border text-muted mb-0">Sin citas registradas para hoy.</div>' +
                    '</div>'
                );
                return;
            }

            citas.slice(0, 5).forEach(function(cita) {
                var fecha = cita.fecha || '';
                var hora = cita.hora || '';
                var paciente = cita.paciente || '';
                var motivo = cita.motivo || 'Sin motivo';
                var idCita = Number(cita.id_cita || 0);
                var idPaciente = Number(cita.id_paciente || 0);

                var card =
                    '<div class="col-12 col-md-6 col-xl-4">' +
                        '<div class="card h-100 border-0 shadow-sm cita-hoy-click" role="button" style="cursor:pointer;" data-id-cita="' + idCita + '" data-id-paciente="' + idPaciente + '" data-paciente="' + escaparHtml(paciente) + '">' +
                            '<div class="card-body">' +
                                '<div class="d-flex justify-content-between align-items-start mb-2">' +
                                    '<h3 class="h6 mb-0">' + escaparHtml(paciente) + '</h3>' +
                                    '<span class="badge text-bg-info">' + escaparHtml(hora) + '</span>' +
                                '</div>' +
                                '<p class="mb-1 text-muted"><i class="bi bi-calendar-event me-1"></i>' + escaparHtml(fecha) + '</p>' +
                                '<p class="mb-1 small"><i class="bi bi-journal-text me-1"></i>' + escaparHtml(motivo) + '</p>' +
                                '<p class="mb-0 small text-primary"><i class="bi bi-check2-circle me-1"></i>Finalizar cita y registrar bitácora</p>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                contenedor.append(card);
            });
        }

        // Click en tarjeta de cita de hoy: abre modal para confirmar finalización y registrar bitácora
        $(document).on('click', '.cita-hoy-click', function () {
            var idCita = Number($(this).data('id-cita') || 0);
            var idPaciente = Number($(this).data('id-paciente') || 0);
            var paciente = String($(this).data('paciente') || '');

            if (!idCita || !idPaciente) {
                return;
            }

            $('#bitacoraIdCita').val(idCita);
            $('#bitacoraIdPaciente').val(idPaciente);
            $('#bitacoraPaciente').val(paciente);
            $('#formBitacoraCita')[0].reset();
            $('#bitacoraIdCita').val(idCita);
            $('#bitacoraIdPaciente').val(idPaciente);
            $('#bitacoraPaciente').val(paciente);
            modalBitacora.show();
        });

        // Guardar bitácora y marcar cita como realizada
        $('#formBitacoraCita').on('submit', function (e) {
            e.preventDefault();

            var idCita = Number($('#bitacoraIdCita').val() || 0);
            var idPaciente = Number($('#bitacoraIdPaciente').val() || 0);

            $.ajax({
                url: 'acciones_citas.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    accion: 'finalizarCitaConBitacora',
                    id_cita: idCita,
                    id_paciente: idPaciente,
                    diagnostico: $('#bitacoraDiagnostico').val(),
                    antecedentes: $('#bitacoraAntecedentes').val(),
                    exploracion: $('#bitacoraExploracion').val(),
                    tratamiento: $('#bitacoraTratamiento').val()
                }
            }).done(function (response) {
                if (!response || !response.success) {
                    iziToast.error({
                        title: 'Error',
                        message: (response && response.message) ? response.message : 'No se pudo finalizar la cita.',
                        position: 'topRight'
                    });
                    return;
                }

                modalBitacora.hide();
                recargarPanelInicio();
                iziToast.success({ title: 'Éxito', message: 'Cita finalizada y bitácora registrada correctamente.', position: 'topRight' });
            }).fail(function () {
                iziToast.error({ title: 'Error', message: 'Error de conexión al guardar la bitácora de la cita.', position: 'topRight' });
            });
        });

        function pintarTablaPacientes(pacientes) {
            var tbody = $('#rowSinPacientes').closest('tbody');
            tbody.empty();

            if (!pacientes.length) {
                tbody.append('<tr id="rowSinPacientes"><td colspan="4" class="text-center text-muted">Sin pacientes activos.</td></tr>');
                return;
            }

            pacientes.forEach(function (paciente) {
                var nombreCompleto = [paciente.nombre || '', paciente.apellido || ''].join(' ').trim();
                var edad = paciente.edad || '';
                var telefono = paciente.telefono || '';

                var row = '<tr>' +
                    '<td>' + escaparHtml(nombreCompleto) + '</td>' +
                    '<td>' + escaparHtml(telefono) + '</td>' +
                    '<td>' + escaparHtml(paciente.proximaCita || 'Sin cita') + '</td>' +
                '</tr>';

                tbody.append(row);
            });
        }

        function pintarMetricas(pacientes) {
            $('#metricaPacientesActivos').text(pacientes.length);
        }

        function escaparHtml(texto) {
            return String(texto)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }
    });
</script>
</body>
</html>
