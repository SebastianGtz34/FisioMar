// Estado global de pacientes para el modal de detalle
var pacientesDetallePorId = {};
var pacienteDetalleActualId = 0;

// Función para obtener las citas del día desde el servidor
function CargarCitasHoy(callback) {
    $.ajax({
        url: 'acciones_citas.php',
        method: 'POST',
        dataType: 'json',
        data: { accion: 'obtenerCitasDia' }
    }).done(function(response) {
        if (response && response.success && Array.isArray(response.data)) {
            if (typeof callback === 'function') callback(response.data);
        } else {
            if (typeof callback === 'function') callback([]);
        }
    }).fail(function() {
        if (typeof callback === 'function') callback([]);
    });
}

// Función para obtener el total de citas realizadas
function CargarTotalSesionesRealizadas(callback) {
    $.ajax({
        url: 'acciones_citas.php',
        method: 'POST',
        dataType: 'json',
        data: { accion: 'obtenerTotalSesionesRealizadas' }
    }).done(function(response) {
        var total = 0;
        if (response && response.success && response.data && typeof response.data.total !== 'undefined') {
            total = parseInt(response.data.total, 10) || 0;
        }
        if (typeof callback === 'function') callback(total);
    }).fail(function() {
        if (typeof callback === 'function') callback(0);
    });
}

// Función para obtener la lista de pacientes desde el servidor
function selectPX(callback) {
    $.ajax({
        url: 'acciones_pacientes.php',
        method: 'POST',
        dataType: 'json',
        data: { accion: 'obtenerPacientes' }
    }).done(function (response) {
        if (response && response.success && Array.isArray(response.data)) {
            callback(response.data);
        } else {
            callback([]);
        }
    }).fail(function () {
        callback([]);
    });
}

// Función global para cargar próximas citas (no realizadas)
function cargarProximasCitas(callback) {
    $.ajax({
        url: 'acciones_citas.php',
        method: 'POST',
        dataType: 'json',
        data: { accion: 'obtenerCitas' },
    }).done(function(response) {
        if (response && response.success && Array.isArray(response.data)) {
            if (typeof callback === 'function') callback(response.data);
        } else {
            if (typeof callback === 'function') callback([]);
        }
    }).fail(function() {
        if (typeof callback === 'function') callback([]);
    });
}

// Función global para cargar pacientes y autocompletar campo PX
function CargarPX(callback) {
    $.ajax({
        url: 'acciones_pacientes.php',
        method: 'POST',
        dataType: 'json',
        data: { accion: 'obtenerPacientes' }
    }).done(function (response) {
        if (!response || !response.success || !Array.isArray(response.data)) {
            if (typeof callback === 'function') callback([]);
            return;
        }
        if (typeof callback === 'function') callback(response.data);
    }).fail(function () {
        console.error('No se pudieron cargar los pacientes desde el servidor.');
        if (typeof callback === 'function') callback([]);
    });
}

// Ejemplo de autocompletado para un campo PX (input con id='inputPX')
function AutocompletarPX(inputSelector) {
    CargarPX(function(pacientes) {
        var nombres = pacientes.map(function(px) {
            return [px.nombre || '', px.apellido || ''].join(' ').trim();
        });
        $(inputSelector).autocomplete({
            source: nombres,
            minLength: 1
        });
    });
}

// Escapa texto para construir HTML seguro
function escaparHtml(texto) {
    return String(texto)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// Función para pintar la tabla de pacientes activos
function pintarTablaPacientesActivos(pacientes, rowVaciaSelector) {
    var selectorFilaVacia = rowVaciaSelector || '#rowSinPacientes';
    var $selector = $(selectorFilaVacia);
    var tbody = $selector.is('tbody') ? $selector : $selector.closest('tbody');

    if (!tbody.length) {
        tbody = $('#tbodyPacientesActivos');
    }

    tbody.empty();
    pacientesDetallePorId = {};
    var pacientesActivos = Array.isArray(pacientes)
        ? pacientes.filter(function (paciente) {
            return String(paciente.estatus || '').toLowerCase() === 'activo';
        })
        : [];

    if (!pacientesActivos.length) {
        tbody.append('<tr id="rowSinPacientes"><td colspan="3" class="text-center text-muted">Sin pacientes activos.</td></tr>');
        return;
    }

    pacientesActivos.forEach(function (paciente) {
        var idPaciente = Number(paciente.id_paciente || 0);
        var nombreCompleto = [paciente.nombre || '', paciente.apellido || ''].join(' ').trim();
        var telefono = paciente.telefono || '';

        if (idPaciente) {
            pacientesDetallePorId[idPaciente] = paciente;
        }

        var row = '<tr>' +
            '<td>' + escaparHtml(nombreCompleto) + '</td>' +
            '<td>' + escaparHtml(telefono) + '</td>' +
            '<td>' +
                '<div class="btn-group btn-group-sm" role="group" aria-label="Acciones del paciente">' +
                    '<button type="button" class="btn btn-outline-primary btn-ver-detalle-px" data-id-paciente="' + idPaciente + '"><i class="bi bi-person-vcard me-1"></i></button>' +
                    '<button type="button" class="btn btn-outline-danger btn-eliminar-px" data-id-paciente="' + idPaciente + '"><i class="bi bi-trash me-1"></i></button>' +
                '</div>' +
            '</td>' +
        '</tr>';

        tbody.append(row);
    });
}

// Función para mostrar detalles de paciente en el modal
function valorDetallePaciente(valor) {
    if (valor === null || typeof valor === 'undefined' || String(valor).trim() === '') {
        return '<span class="text-muted">No registrado</span>';
    }
    return escaparHtml(valor);
}

// Función para construir el HTML del detalle del paciente
function construirHtmlDetallePaciente(paciente) {
    var nombreCompleto = [paciente.nombre || '', paciente.apellido || ''].join(' ').trim();

    return '<div class="row g-3">' +
        '<div class="col-12"><h3 class="h6 mb-0">' + escaparHtml(nombreCompleto || 'Sin nombre') + '</h3></div>' +
        '<div class="col-12 col-md-6"><strong>ID:</strong> ' + valorDetallePaciente(paciente.id_paciente) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Estatus:</strong> ' + valorDetallePaciente(paciente.estatus) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Edad:</strong> ' + valorDetallePaciente(paciente.edad) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Sexo:</strong> ' + valorDetallePaciente(paciente.sexo) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Fecha de nacimiento:</strong> ' + valorDetallePaciente(paciente.fecha_nacimiento) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Telefono:</strong> ' + valorDetallePaciente(paciente.telefono) + '</div>' +
        '<div class="col-12"><strong>Correo:</strong> ' + valorDetallePaciente(paciente.correo) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Ocupacion:</strong> ' + valorDetallePaciente(paciente.ocupacion) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Estado civil:</strong> ' + valorDetallePaciente(paciente.estado_civil) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Seguro medico:</strong> ' + valorDetallePaciente(paciente.seguro_medico) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Folio:</strong> ' + valorDetallePaciente(paciente.folio) + '</div>' +
        '<div class="col-12"><strong>Diagnostico:</strong><br>' + valorDetallePaciente(paciente.diagnostico) + '</div>' +
        '<div class="col-12"><strong>Antecedentes:</strong><br>' + valorDetallePaciente(paciente.antecedentes) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Contacto de emergencia:</strong> ' + valorDetallePaciente(paciente.contacto_emergencia) + '</div>' +
        '<div class="col-12 col-md-6"><strong>Telefono emergencia:</strong> ' + valorDetallePaciente(paciente.telefono_emergencia) + '</div>' +
        '<div class="col-12"><strong>Fecha de registro:</strong> ' + valorDetallePaciente(paciente.fecha_registro) + '</div>' +
    '</div>';
}

// Función para iniciar eventos de botones de detalle de pacientes
function iniciarEventosDetallePacientes(modalDetallePaciente, detalleBodySelector) {
    var selectorBody = detalleBodySelector || '#detallePacienteBody';

    $(document).off('click', '.btn-ver-detalle-px').on('click', '.btn-ver-detalle-px', function () {
        var idPaciente = Number($(this).data('id-paciente') || 0);
        if (!idPaciente || !pacientesDetallePorId[idPaciente]) {
            return;
        }

        var paciente = pacientesDetallePorId[idPaciente];
        pacienteDetalleActualId = idPaciente;
        $(selectorBody).html(construirHtmlDetallePaciente(paciente));
        modalDetallePaciente.show();
    });
}

// Función para cargar los datos de un paciente en el formulario de edición
function cargarFormularioEditarPaciente(paciente, formSelector) {
    var selectorForm = formSelector || '#formEditarPaciente';

    $(selectorForm + ' #editarIdPaciente').val(paciente.id_paciente || '');
    $(selectorForm + ' #editarNombre').val(paciente.nombre || '');
    $(selectorForm + ' #editarApellido').val(paciente.apellido || '');
    $(selectorForm + ' #editarFechaNacimiento').val(paciente.fecha_nacimiento || '');
    $(selectorForm + ' #editarTelefono').val(paciente.telefono || '');
    $(selectorForm + ' #editarCorreo').val(paciente.correo || '');
    $(selectorForm + ' #editarOcupacion').val(paciente.ocupacion || '');
    $(selectorForm + ' #editarEstadoCivil').val(paciente.estado_civil || '');
    $(selectorForm + ' #editarSeguroMedico').val(paciente.seguro_medico || '');
    $(selectorForm + ' #editarSexo').val(paciente.sexo || '');
    $(selectorForm + ' #editarDiagnostico').val(paciente.diagnostico || '');
    $(selectorForm + ' #editarAntecedentes').val(paciente.antecedentes || '');
    $(selectorForm + ' #editarFolio').val(paciente.folio || '');
    $(selectorForm + ' #editarEstatus').val(paciente.estatus || '');
    $(selectorForm + ' #editarContactoEmergencia').val(paciente.contacto_emergencia || '');
    $(selectorForm + ' #editarTelefonoEmergencia').val(paciente.telefono_emergencia || '');
}

// Función para iniciar eventos de edición de pacientes desde el modal de detalle
function iniciarEventosEditarPacientes(modalDetallePaciente, modalEditarPaciente, formSelector, onPacienteActualizado) {
    var selectorForm = formSelector || '#formEditarPaciente';

    $(document).off('click', '#btnEditarPacienteDesdeDetalle').on('click', '#btnEditarPacienteDesdeDetalle', function () {
        if (!pacienteDetalleActualId || !pacientesDetallePorId[pacienteDetalleActualId]) {
            iziToast.error({ title: 'Error', message: 'No hay un paciente seleccionado para editar.', position: 'topRight' });
            return;
        }

        var paciente = pacientesDetallePorId[pacienteDetalleActualId];
        cargarFormularioEditarPaciente(paciente, selectorForm);

        modalDetallePaciente.hide();
        setTimeout(function () {
            modalEditarPaciente.show();
        }, 200);
    });

    $(document).off('submit', selectorForm).on('submit', selectorForm, function (e) {
        e.preventDefault();

        var idPaciente = Number($(selectorForm + ' #editarIdPaciente').val() || 0);

        if (!idPaciente) {
            iziToast.error({ title: 'Error', message: 'ID de paciente inválido.', position: 'topRight' });
            return;
        }

        $.ajax({
            url: 'acciones_pacientes.php',
            method: 'POST',
            dataType: 'json',
            data: {
                accion: 'modificarPaciente',
                id_paciente: idPaciente,
                nombre: $(selectorForm + ' #editarNombre').val(),
                apellido: $(selectorForm + ' #editarApellido').val(),
                fechaNacimiento: $(selectorForm + ' #editarFechaNacimiento').val(),
                telefono: $(selectorForm + ' #editarTelefono').val(),
                correo: $(selectorForm + ' #editarCorreo').val(),
                ocupacion: $(selectorForm + ' #editarOcupacion').val(),
                estadoCivil: $(selectorForm + ' #editarEstadoCivil').val(),
                seguroMedico: $(selectorForm + ' #editarSeguroMedico').val(),
                sexo: $(selectorForm + ' #editarSexo').val(),
                diagnostico: $(selectorForm + ' #editarDiagnostico').val(),
                antecedentes: $(selectorForm + ' #editarAntecedentes').val(),
                folio: $(selectorForm + ' #editarFolio').val(),
                estatus: $(selectorForm + ' #editarEstatus').val(),
                contactoEmergencia: $(selectorForm + ' #editarContactoEmergencia').val(),
                telefonoEmergencia: $(selectorForm + ' #editarTelefonoEmergencia').val()
            }
        }).done(function (response) {
            if (!response || !response.success) {
                iziToast.error({
                    title: 'Error',
                    message: (response && response.message) ? response.message : 'No se pudo modificar el paciente.',
                    position: 'topRight'
                });
                return;
            }

            modalEditarPaciente.hide();

            if (typeof onPacienteActualizado === 'function') {
                onPacienteActualizado(idPaciente);
            }

            iziToast.success({
                title: 'Éxito',
                message: 'Paciente modificado correctamente.',
                position: 'topRight'
            });
        }).fail(function () {
            iziToast.error({ title: 'Error', message: 'Error de conexión al modificar el paciente.', position: 'topRight' });
        });
    });
}

// Función para dar de baja a pacientes
function iniciarEventosBajaPacientes(onPacienteDadoDeBaja) {
    $(document).off('click', '.btn-eliminar-px').on('click', '.btn-eliminar-px', function () {
        var idPaciente = Number($(this).data('id-paciente') || 0);

        if (!idPaciente) {
            iziToast.error({ title: 'Error', message: 'ID de paciente inválido.', position: 'topRight' });
            return;
        }

        iziToast.question({
            title: 'Dar de baja',
            message: '¿Estás seguro de dar de baja a este paciente?',
            position: 'center',
            timeout: false,
            overlay: true,
            closeOnOverlayClick: false,
            buttons: [
                ['<button>Sí, dar de baja</button>', function (instance, toast) {
                    instance.hide({}, toast);

                    $.ajax({
                        url: 'acciones_pacientes.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            accion: 'darBajaPaciente',
                            id_paciente: idPaciente
                        }
                    }).done(function (response) {
                        if (!response || !response.success) {
                            iziToast.error({
                                title: 'Error',
                                message: (response && response.message) ? response.message : 'No se pudo dar de baja al paciente.',
                                position: 'topRight'
                            });
                            return;
                        }

                        if (typeof onPacienteDadoDeBaja === 'function') {
                            onPacienteDadoDeBaja(idPaciente);
                        }

                        iziToast.success({
                            title: 'Éxito',
                            message: 'Paciente dado de baja correctamente.',
                            position: 'topRight'
                        });
                    }).fail(function () {
                        iziToast.error({ title: 'Error', message: 'Error de conexión al dar de baja al paciente.', position: 'topRight' });
                    });
                }],
                ['<button>Cancelar</button>', function (instance, toast) {
                    instance.hide({}, toast);
                }]
            ]
        });
    });
}
