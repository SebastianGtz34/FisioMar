<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FISIOMAR - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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

                            <!-- TABLA DE PACIENTES -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h2 class="h5 mb-0">Lista de Pacientes</h2>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Edad</th>
                                            <th>Teléfono</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id="rowSinPacientes">
                                            <td colspan="4" class="text-center text-muted">Sin pacientes registrados.</td>
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

<script>
    $(function () {
        // Cargar y mostrar pacientes reales al iniciar
        CargarPX(function(pacientes) {
            pintarTablaPacientes(pacientes);
            pintarMetricas(pacientes);
        });

        // Cargar y mostrar citas de hoy al iniciar
        CargarCitasHoy(function(citasHoy) {
            pintarTarjetasCitasHoy(citasHoy);
            $('#metricaCitasDia').text(citasHoy.length);
        });

        // Cargar total de sesiones realizadas
        CargarTotalSesionesRealizadas(function(total) {
            $('#metricaSesiones').text(total);
        });

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

                var card =
                    '<div class="col-12 col-md-6 col-xl-4">' +
                        '<div class="card h-100 border-0 shadow-sm">' +
                            '<div class="card-body">' +
                                '<div class="d-flex justify-content-between align-items-start mb-2">' +
                                    '<h3 class="h6 mb-0">' + escaparHtml(paciente) + '</h3>' +
                                    '<span class="badge text-bg-info">' + escaparHtml(hora) + '</span>' +
                                '</div>' +
                                '<p class="mb-1 text-muted"><i class="bi bi-calendar-event me-1"></i>' + escaparHtml(fecha) + '</p>' +
                                '<p class="mb-0 small"><i class="bi bi-journal-text me-1"></i>' + escaparHtml(motivo) + '</p>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                contenedor.append(card);
            });
        }

        function pintarTablaPacientes(pacientes) {
            var tbody = $('#rowSinPacientes').closest('tbody');
            tbody.empty();

            if (!pacientes.length) {
                tbody.append('<tr id="rowSinPacientes"><td colspan="4" class="text-center text-muted">Sin pacientes registrados.</td></tr>');
                return;
            }

            pacientes.forEach(function (paciente) {
                var nombreCompleto = [paciente.nombre || '', paciente.apellido || ''].join(' ').trim();
                var edad = paciente.edad || '';
                var telefono = paciente.telefono || '';

                var row = '<tr>' +
                    '<td>' + escaparHtml(nombreCompleto) + '</td>' +
                    '<td>' + escaparHtml(String(edad)) + '</td>' +
                    '<td>' + escaparHtml(telefono) + '</td>' +
                    '<td></td>' +
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
