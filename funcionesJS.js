// Funciones globales para FisioMar

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
