<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Fisioterapia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- MENÚ LATERAL -->
        <aside class="col-12 col-lg-2 bg-primary text-white p-0">
            <div class="p-3 border-bottom border-primary-subtle">
                <h2 class="h5 mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-universal-access-circle"></i>
                    Fisioterapia
                </h2>
            </div>

            <nav class="nav flex-column p-2" id="menuLateral">
                <a class="nav-link text-white active" href="#" data-section="inicio" data-title="Inicio">
                    <i class="bi bi-house-door-fill me-2"></i>Inicio
                </a>
                <a class="nav-link text-white" href="#" data-section="pacientes" data-title="Pacientes">
                    <i class="bi bi-people-fill me-2"></i>Pacientes
                </a>
                <a class="nav-link text-white" href="#" data-section="citas" data-title="Agenda de Citas">
                    <i class="bi bi-calendar-check-fill me-2"></i>Citas
                </a>
                <a class="nav-link text-white" href="#" data-section="reportes" data-title="Reportes">
                    <i class="bi bi-bar-chart-fill me-2"></i>Reportes
                </a>
                <a class="nav-link text-white" href="#" data-section="archivos" data-title="Archivos">
                    <i class="bi bi-folder-fill me-2"></i>Archivos
                </a>
            </nav>
        </aside>

        <main class="col-12 col-lg-10 p-0">
            <!-- ENCABEZADO PRINCIPAL -->
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center sticky-top">
                <h1 class="h4 mb-0" id="mainTitle">Inicio</h1>
                <div class="d-flex align-items-center gap-3 text-secondary">
                    <i class="bi bi-bell"></i>
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </header>

            <div class="p-4">
                <!-- SECCIÓN INICIO -->
                <section id="section-inicio" class="page-section">
                    <!-- MÉTRICAS -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-primary h-100">
                                <div class="card-body">
                                    <small class="d-block">Pacientes Activos</small>
                                    <h2 class="h3 mb-0">--</h2>
                                    <small class="text-white-50">Placeholder: total de pacientes activos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-warning h-100">
                                <div class="card-body">
                                    <small class="d-block">Citas del Día</small>
                                    <h2 class="h3 mb-0">--</h2>
                                    <small class="text-dark">Placeholder: citas programadas hoy</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-success h-100">
                                <div class="card-body">
                                    <small class="d-block">Sesiones Realizadas</small>
                                    <h2 class="h3 mb-0">--</h2>
                                    <small class="text-white-50">Placeholder: sesiones completadas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="card text-bg-info h-100">
                                <div class="card-body">
                                    <small class="d-block">Reportes Generados</small>
                                    <h2 class="h3 mb-0">--</h2>
                                    <small class="text-white-50">Placeholder: reportes emitidos</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-xl-8">
                            <!-- TABLA DE PACIENTES -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h2 class="h5 mb-0">Listado de Pacientes</h2>
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
                                        <tr>
                                            <td>Placeholder: nombre paciente</td>
                                            <td>--</td>
                                            <td>Placeholder: teléfono</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-ver">Ver</button>
                                                <button type="button" class="btn btn-sm btn-success btn-editar">Editar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Placeholder: nombre paciente</td>
                                            <td>--</td>
                                            <td>Placeholder: teléfono</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-ver">Ver</button>
                                                <button type="button" class="btn btn-sm btn-success btn-editar">Editar</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- PRÓXIMAS CITAS -->
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h2 class="h5 mb-0">Próximas Citas</h2>
                                    <span class="text-muted">Placeholder: mes/año</span>
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
                                                <td>Placeholder: yyyy-mm-dd</td>
                                                <td>Placeholder: hh:mm</td>
                                                <td>Placeholder: nombre paciente</td>
                                                <td>Placeholder: motivo de cita</td>
                                            </tr>
                                            <tr>
                                                <td>Placeholder: yyyy-mm-dd</td>
                                                <td>Placeholder: hh:mm</td>
                                                <td>Placeholder: nombre paciente</td>
                                                <td>Placeholder: motivo de cita</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4">
                            <!-- FORMULARIO DE REGISTRO -->
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h2 class="h5 mb-0">Registrar Paciente</h2>
                                </div>
                                <div class="card-body">
                                    <div id="formAlert" class="alert d-none" role="alert"></div>

                                    <form id="formPaciente" action="acciones_pacientes.php" method="post" novalidate>
                                        <input type="hidden" name="archivo_origen" value="index.php">

                                        <div class="mb-3">
                                            <label for="nombreCompleto" class="form-label">Nombre Completo</label>
                                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Ejemplo: Ana López" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ejemplo: (953) 329-0200" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ejemplo: paciente@correo.com" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ocupacion" class="form-label">Ocupación</label>
                                            <input type="text" class="form-control" id="ocupacion" name="ocupacion" placeholder="Ejemplo: Docente">
                                        </div>
                                        <div class="mb-3">
                                            <label for="estadoCivil" class="form-label">Estado Civil</label>
                                            <select class="form-select" id="estadoCivil" name="estadoCivil">
                                                <option value="">Placeholder: seleccionar estado civil</option>
                                                <option>Soltero/a</option>
                                                <option>Casado/a</option>
                                                <option>Unión libre</option>
                                                <option>Divorciado/a</option>
                                                <option>Viudo/a</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="seguroMedico" class="form-label">Seguro Médico</label>
                                            <select class="form-select" id="seguroMedico" name="seguroMedico">
                                                <option value="">Placeholder: seleccionar seguro médico</option>
                                                <option>Particular</option>
                                                <option>IMSS</option>
                                                <option>ISSSTE</option>
                                                <option>Privado</option>
                                            </select>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-fill">Guardar</button>
                                            <button type="button" id="btnCancelar" class="btn btn-outline-secondary flex-fill">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="section-pacientes" class="page-section d-none">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4">Pacientes</h2>
                            <p class="text-muted mb-0">Placeholder: vista de gestión de pacientes.</p>
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
<script>
    $(function () {
        // MENÚ: mostrar/ocultar secciones y cambiar título
        $('#menuLateral .nav-link').on('click', function (event) {
            event.preventDefault();

            var section = $(this).data('section');
            var title = $(this).data('title');

            $('#menuLateral .nav-link').removeClass('active');
            $(this).addClass('active');

            $('.page-section').addClass('d-none');
            $('#section-' + section).removeClass('d-none');

            $('#mainTitle').text(title);
        });

        // DEMO acciones de tabla
        $('.btn-ver').on('click', function () {
            alert('Placeholder: vista de paciente.');
        });

        $('.btn-editar').on('click', function () {
            alert('Placeholder: editar paciente.');
        });

        // VALIDACIÓN BÁSICA DEL FORMULARIO
        $('#formPaciente').on('submit', function (event) {
            var nombre = $.trim($('#nombreCompleto').val());
            var fecha = $('#fechaNacimiento').val();
            var telefono = $.trim($('#telefono').val());
            var correo = $.trim($('#correo').val());

            var telefonoRegex = /^[0-9()\-\s+]{8,20}$/;
            var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!nombre || !fecha || !telefono || !correo) {
                event.preventDefault();
                mostrarAlerta('Completa Nombre, Fecha de Nacimiento, Teléfono y Correo.', 'danger');
                return;
            }

            if (!telefonoRegex.test(telefono)) {
                event.preventDefault();
                mostrarAlerta('Formato de teléfono no válido.', 'danger');
                return;
            }

            if (!correoRegex.test(correo)) {
                event.preventDefault();
                mostrarAlerta('Formato de correo no válido.', 'danger');
                return;
            }
        });

        // BOTÓN CANCELAR FORMULARIO
        $('#btnCancelar').on('click', function () {
            $('#formPaciente')[0].reset();
            $('#formAlert').addClass('d-none').removeClass('alert-success alert-danger').text('');
        });

        function mostrarAlerta(mensaje, tipo) {
            $('#formAlert')
                .removeClass('d-none alert-success alert-danger')
                .addClass('alert-' + tipo)
                .text(mensaje);
        }
    });
</script>
</body>
</html>
