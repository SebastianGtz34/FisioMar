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
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-info h-100">
                                <div class="card-body">
                                    <small class="d-block">Reportes Generados:</small>
                                    <h2 class="h3 mb-0" id="metricaReportes">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
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
                                            <th>Acciones</th>
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

                            <!-- PRÓXIMAS CITAS -->
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h2 class="h5 mb-0">Próximas Citas</h2>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">Ver Todas</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Paciente</th>
                                                <th>Motivo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <section id="section-pacientes" class="page-section d-none">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4">Pacientes</h2>
                            <p class="text-muted mb-0">Vista de gestión de pacientes.</p>
                        </div>
                    </div>
                </section>

                <section id="section-citas" class="page-section d-none">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4">Agenda de Citas</h2>
                            <p class="text-muted mb-0">Placeholder: calendario/listado completo de citas.</p>
                        </div>
                    </div>
                </section>

                <section id="section-reportes" class="page-section d-none">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4">Reportes</h2>
                            <p class="text-muted mb-0">Placeholder: módulo de reportes.</p>
                        </div>
                    </div>
                </section>

                <section id="section-archivos" class="page-section d-none">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4">Archivos</h2>
                            <p class="text-muted mb-0">Placeholder: gestión de archivos clínicos.</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="funcionesJS.js"></script>
<script>
    $(function () {
        $('#menuContainer').load('menu.php', function () {
            var currentFile = window.location.pathname.split('/').pop() || 'index.php';
            $('#menu .nav-link').removeClass('active');
            $('#menu .nav-link[data-page="' + currentFile + '"]').addClass('active');
        });

        CargarPX();

        // DEMO acciones de tabla
        $(document).on('click', '.btn-ver', function () {
            alert('Placeholder: vista de paciente.');
        });

        $(document).on('click', '.btn-editar', function () {
            alert('Placeholder: editar paciente.');
        });

        // ...función global CargarPX() se usará desde funcionesJS.js...

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
                    '<td>' +
                        '<button type="button" class="btn btn-sm btn-outline-primary btn-ver me-1">Ver</button>' +
                        '<button type="button" class="btn btn-sm btn-outline-success btn-editar">Editar</button>' +
                    '</td>' +
                '</tr>';

                tbody.append(row);
            });
        }

        function pintarMetricas(pacientes) {
            $('#metricaPacientesActivos').text(pacientes.length);
            $('#metricaCitasDia').text(0);
            $('#metricaSesiones').text(0);
            $('#metricaReportes').text(0);
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
