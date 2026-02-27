<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente - FISIOMAR</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- MENÚ LATERAL -->
        <aside id="menuContainer" class="col-12 col-lg-2 p-0"></aside>

        <main class="col-12 col-lg-10 p-0">
            <!-- ENCABEZADO PRINCIPAL -->
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center sticky-top">
                <h1 class="h4 mb-0">Registrar Paciente</h1>
                <div class="d-flex align-items-center gap-3 text-secondary">
                    <i class="bi bi-bell"></i>
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </header>

            <div class="p-4">
                <div class="card">
                    <div class="card-body">
                        <!-- TABS DE REGISTRO -->
                        <ul class="nav nav-tabs mb-4" id="tabsRegistro" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="datos-personales-tab" data-bs-toggle="tab" data-bs-target="#datos-personales" type="button" role="tab" aria-controls="datos-personales" aria-selected="true">Datos Personales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="datos-clinicos-tab" data-bs-toggle="tab" data-bs-target="#datos-clinicos" type="button" role="tab" aria-controls="datos-clinicos" aria-selected="false">Datos Clínicos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="datos-admin-tab" data-bs-toggle="tab" data-bs-target="#datos-admin" type="button" role="tab" aria-controls="datos-admin" aria-selected="false">Datos Administrativos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="agenda-tab" data-bs-toggle="tab" data-bs-target="#agenda" type="button" role="tab" aria-controls="agenda" aria-selected="false">Agendar Cita Rápida</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="emergencia-tab" data-bs-toggle="tab" data-bs-target="#emergencia" type="button" role="tab" aria-controls="emergencia" aria-selected="false">Contacto de Emergencia</button>
                            </li>
                        </ul>

                        <div id="formAlert" class="alert d-none" role="alert"></div>

                        <form id="formRegistroPX" action="acciones_registroPX.php" method="post" novalidate>
                            <input type="hidden" name="accion" value="guardarRegistroPX">
                            <input type="hidden" name="archivo_origen" value="registro_px.php">
                            <input type="hidden" id="fechaRegistro" name="fechaRegistro">

                            <div class="tab-content" id="tabsRegistroContent">
                                <!-- DATOS PERSONALES -->
                                <div class="tab-pane fade show active" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab" tabindex="0">
                                    <h2 class="h5 mb-3">Datos Personales</h2>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="sexo" class="form-label">Sexo</label>
                                            <select class="form-select" id="sexo" name="sexo" required>
                                                <option value="">Seleccionar sexo</option>
                                                <option>Masculino</option>
                                                <option>Femenino</option>
                                                <option>Otro</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="edad" class="form-label">Edad</label>
                                            <input type="number" class="form-control" id="edad" name="edad" min="0" max="120" placeholder="Edad calculada o manual">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="estadoCivil" class="form-label">Estado Civil</label>
                                            <select class="form-select" id="estadoCivil" name="estadoCivil">
                                                <option value="">Seleccionar estado civil</option>
                                                <option>Soltero/a</option>
                                                <option>Casado/a</option>
                                                <option>Unión libre</option>
                                                <option>Divorciado/a</option>
                                                <option>Viudo/a</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="ocupacion" class="form-label">Ocupación</label>
                                            <input type="text" class="form-control" id="ocupacion" name="ocupacion" placeholder="Ocupación">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="seguroMedico" class="form-label">Seguro Médico</label>
                                            <select class="form-select" id="seguroMedico" name="seguroMedico">
                                                <option value="">Seleccionar seguro médico</option>
                                                <option>Particular</option>
                                                <option>IMSS</option>
                                                <option>ISSSTE</option>
                                                <option>Privado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- DATOS CLÍNICOS -->
                                <div class="tab-pane fade" id="datos-clinicos" role="tabpanel" aria-labelledby="datos-clinicos-tab" tabindex="0">
                                    <h2 class="h5 mb-3">Datos Clínicos</h2>
                                    <!-- CAMPOS CLÍNICOS -->
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="diagnostico" class="form-label">Diagnóstico Inicial</label>
                                            <input type="text" class="form-control" id="diagnostico" name="diagnostico" placeholder="Diagnóstico inicial" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="antecedentes" class="form-label">Antecedentes Relevantes</label>
                                            <textarea class="form-control" id="antecedentes" name="antecedentes" rows="3" placeholder="Antecedentes médicos"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="exploracionFisica" class="form-label">Exploración Física</label>
                                            <textarea class="form-control" id="exploracionFisica" name="exploracionFisica" rows="3" placeholder="Hallazgos de exploración física"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="tratamientoPropuesto" class="form-label">Tratamiento Propuesto</label>
                                            <input type="text" class="form-control" id="tratamientoPropuesto" name="tratamientoPropuesto" placeholder="Tratamiento propuesto">
                                        </div>
                                    </div>
                                </div>

                                <!-- DATOS ADMINISTRATIVOS -->
                                <div class="tab-pane fade" id="datos-admin" role="tabpanel" aria-labelledby="datos-admin-tab" tabindex="0">
                                    <h2 class="h5 mb-3">Datos Administrativos</h2>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="folio" class="form-label">Folio de Paciente</label>
                                            <input type="text" class="form-control" id="folio" name="folio" placeholder="Folio interno">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="estatus" class="form-label">Estatus</label>
                                            <select class="form-select" id="estatus" name="estatus">
                                                <option value="">Seleccionar estatus</option>
                                                <option>Activo</option>
                                                <option>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- AGENDAR CITA -->
                                <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab" tabindex="0">
                                    <h2 class="h5 mb-3">Agendar Cita Rápida</h2>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="fechaCita" class="form-label">Fecha de Cita</label>
                                            <input type="date" class="form-control" id="fechaCita" name="fechaCita">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="horaCita" class="form-label">Hora de Cita</label>
                                            <input type="time" class="form-control" id="horaCita" name="horaCita">
                                        </div>
                                    </div>
                                </div>

                                <!-- CONTACTO EMERGENCIA -->
                                <div class="tab-pane fade" id="emergencia" role="tabpanel" aria-labelledby="emergencia-tab" tabindex="0">
                                    <h2 class="h5 mb-3">Contacto de Emergencia</h2>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="contactoEmergencia" class="form-label">Nombre de Contacto</label>
                                            <input type="text" class="form-control" id="contactoEmergencia" name="contactoEmergencia" placeholder="Nombre de contacto">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="telefonoEmergencia" class="form-label">Teléfono de Contacto</label>
                                            <input type="tel" class="form-control" id="telefonoEmergencia" name="telefonoEmergencia" placeholder="Teléfono de emergencia">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- BOTONES DE ACCIÓN -->
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="submit" class="btn btn-primary px-4">Guardar</button>
                                <button type="reset" id="btnCancelar" class="btn btn-outline-secondary px-4">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(function () {
        $('#menuContainer').load('menu.php', function () {
            var currentFile = window.location.pathname.split('/').pop() || 'registro_px.php';
            $('#menu .nav-link').removeClass('active');
            $('#menu .nav-link[data-page="' + currentFile + '"]').addClass('active');
        });

        // FECHA DE REGISTRO AUTOMÁTICA
        establecerFechaRegistro();

        // VALIDACIONES DEL FORMULARIO
        $('#formRegistroPX').on('submit', function (event) {
            event.preventDefault();

            var nombre = $.trim($('#nombre').val());
            var apellido = $.trim($('#apellido').val());
            var fecha = $('#fechaNacimiento').val();
            var sexo = $('#sexo').val();
            var telefono = $.trim($('#telefono').val());
            var correo = $.trim($('#correo').val());
            var diagnostico = $.trim($('#diagnostico').val());

            var telefonoRegex = /^[0-9()\-\s+]{8,20}$/;
            var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!nombre || !apellido || !fecha || !sexo || !telefono || !correo) {
                mostrarAlerta('Completa Nombre, Apellido, Fecha de Nacimiento, Sexo, Teléfono y Correo.', 'danger');
                return;
            }

            if (!telefonoRegex.test(telefono)) {
                mostrarAlerta('Formato de teléfono no válido.', 'danger');
                return;
            }

            if (!correoRegex.test(correo)) {
                mostrarAlerta('Formato de correo no válido.', 'danger');
                return;
            }

            if (!diagnostico) {
                mostrarAlerta('Diagnóstico Inicial es obligatorio.', 'danger');
                var tabClinico = new bootstrap.Tab(document.querySelector('#datos-clinicos-tab'));
                tabClinico.show();
                $('#diagnostico').trigger('focus');
                return;
            }

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json'
            }).done(function (response) {
                if (response && response.success) {
                    mostrarAlerta(response.message || 'Registro PX guardado correctamente.', 'success');
                    $('#formRegistroPX')[0].reset();
                    establecerFechaRegistro();
                    var primerTab = new bootstrap.Tab(document.querySelector('#datos-personales-tab'));
                    primerTab.show();
                } else {
                    mostrarAlerta((response && response.message) ? response.message : 'No se pudo procesar el registro PX.', 'danger');
                }
            }).fail(function () {
                mostrarAlerta('Error al conectar con acciones_registroPX.php.', 'danger');
            });
        });

        // BOTÓN CANCELAR (RESET)
        $('#formRegistroPX').on('reset', function () {
            setTimeout(function () {
                establecerFechaRegistro();
            }, 0);
            $('#formAlert').addClass('d-none').removeClass('alert-success alert-danger').text('');
            var primerTab = new bootstrap.Tab(document.querySelector('#datos-personales-tab'));
            primerTab.show();
        });

        function mostrarAlerta(mensaje, tipo) {
            $('#formAlert')
                .removeClass('d-none alert-success alert-danger')
                .addClass('alert-' + tipo)
                .text(mensaje);
        }

        function establecerFechaRegistro() {
            var ahora = new Date();
            var yyyy = ahora.getFullYear();
            var mm = String(ahora.getMonth() + 1).padStart(2, '0');
            var dd = String(ahora.getDate()).padStart(2, '0');
            var hh = String(ahora.getHours()).padStart(2, '0');
            var min = String(ahora.getMinutes()).padStart(2, '0');
            var ss = String(ahora.getSeconds()).padStart(2, '0');
            $('#fechaRegistro').val(yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + min + ':' + ss);
        }
    });
</script>
</body>
</html>
