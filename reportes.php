<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - FISIOMAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
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
                <!-- Encabezado de la vista -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                    <h1 class="h3 mb-0">Reportes</h1>
                    <button id="btnAbrirModalReporte" type="button" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-file-earmark-plus me-2"></i>Generar nuevo reporte
                    </button>
                </div>

                <!-- Tabla de reportes -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Listado de Reportes</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaReportes">
                            <thead class="table-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>Tipo de reporte</th>
                                    <th>Fecha de generación</th>
                                    <th class="text-nowrap">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Sin reportes generados.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal para generar nuevo reporte -->
                <div class="modal fade" id="modalNuevoReporte" tabindex="-1" aria-labelledby="modalNuevoReporteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title h5" id="modalNuevoReporteLabel">Generar nuevo reporte</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form id="formNuevoReporte" method="post" action="#">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="reportePaciente" class="form-label">Paciente</label>
                                            <select class="form-select" id="reportePaciente" name="reportePaciente" required>
                                                <option value="" selected disabled>Cargando pacientes...</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label for="tipoReporte" class="form-label">Tipo de reporte</label>
                                            <select class="form-select" id="tipoReporte" name="tipoReporte" required>
                                                <option value="" selected disabled>Selecciona una opción...</option>
                                                <option value="Historial Completo">Historial clínico</option>
                                                <option value="Sesiones Realizadas">Sesiones realizadas</option>
                                                <option value="Resumen de Tratamientos">Resumen administrativo</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Rango de fechas</label>
                                            <div class="row g-2">
                                                <div class="col-12 col-md-6">
                                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="bi bi-save me-1"></i>Guardar
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="btnCancelarReporte" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal de detalle para acción Ver -->
                <div class="modal fade" id="modalDetalleReporte" tabindex="-1" aria-labelledby="modalDetalleReporteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title h5" id="modalDetalleReporteLabel">Detalle de Reporte</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2"><strong>Paciente:</strong> <span id="detallePaciente">-</span></div>
                                <div class="mb-2"><strong>Tipo:</strong> <span id="detalleTipo">-</span></div>
                                <div class="mb-2"><strong>Fecha de generación:</strong> <span id="detalleFecha">-</span></div>
                                <div class="mb-2"><strong>Teléfono:</strong> <span id="detalleTelefono">-</span></div>
                                <div class="mb-0"><strong>Correo:</strong> <span id="detalleCorreo">-</span></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de visualización de reportes -->
                <div class="modal fade" id="modalHistorialClinico" tabindex="-1" aria-labelledby="modalHistorialClinicoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <h2 class="modal-title h5 mb-0" id="modalHistorialClinicoLabel">Reporte</h2>
                                    <small class="text-muted">Paciente: <span id="historialNombrePaciente"></span></small>
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Renderizado: tabla responsiva dinámica según tipo de reporte -->
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" id="tablaHistorialClinico">
                                        <thead class="table-light" id="encabezadoReporteDinamico"></thead>
                                        <tbody>
                                            <tr><td colspan="5" class="text-center text-muted py-3">Cargando...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" id="btnExportarPDF">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>Exportar PDF
                                </button>
                                <button type="button" class="btn btn-outline-success" id="btnExportarExcel">
                                    <i class="bi bi-file-earmark-excel me-1"></i>Exportar Excel
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="funcionesJS.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    $(function () {
        // Encabezado: inicialización del modal
        // Interacciones básicas del modal
        var modalReporteEl = document.getElementById('modalNuevoReporte');
        var modalReporte = new bootstrap.Modal(modalReporteEl);
        var modalDetalleEl = document.getElementById('modalDetalleReporte');
        var modalDetalle = new bootstrap.Modal(modalDetalleEl);
        var modalHistorialEl = document.getElementById('modalHistorialClinico');
        var modalHistorial = new bootstrap.Modal(modalHistorialEl);

        // Tabla: utilidades de render
        function escaparHtml(texto) {
            return String(texto)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatearFecha(fechaTexto) {
            if (!fechaTexto) return '';
            var fecha = new Date(fechaTexto.replace(' ', 'T'));
            if (isNaN(fecha.getTime())) {
                return fechaTexto;
            }
            return fecha.toLocaleString('es-MX', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Tabla: carga inicial y refresco
        function cargarReportes() {
            $.ajax({
                url: 'acciones_reportes.php',
                method: 'POST',
                dataType: 'json',
                data: { accion: 'obtenerReportes' }
            }).done(function (response) {
                if (response && response.success && Array.isArray(response.data)) {
                    pintarTablaReportes(response.data);
                } else {
                    pintarTablaReportes([]);
                    iziToast.warning({ title: 'Aviso', message: 'No se pudieron cargar los reportes.', position: 'topRight' });
                }
            }).fail(function () {
                pintarTablaReportes([]);
                iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al cargar reportes.', position: 'topRight' });
            });
        }

        function pintarTablaReportes(reportes) {
            var $tbody = $('#tablaReportes tbody');
            $tbody.empty();

            if (!reportes.length) {
                $tbody.append('<tr><td colspan="4" class="text-center text-muted py-4">Sin reportes generados.</td></tr>');
                return;
            }

            reportes.forEach(function (reporte) {
                var fila =
                    '<tr>' +
                        '<td>' + escaparHtml(reporte.paciente || '') + '</td>' +
                        '<td>' + escaparHtml(reporte.tipo || '') + '</td>' +
                        '<td>' + escaparHtml(formatearFecha(reporte.fecha_generado || '')) + '</td>' +
                        '<td class="text-nowrap">' +
                            '<button type="button" class="btn btn-sm btn-outline-primary btn-ver-reporte me-1" data-id="' + Number(reporte.id_reporte || 0) + '" data-tipo="' + escaparHtml(reporte.tipo || '') + '" data-id-paciente="' + Number(reporte.id_paciente || 0) + '" data-paciente="' + escaparHtml(reporte.paciente || '') + '">Ver</button>' +
                            '<button type="button" class="btn btn-sm btn-outline-danger btn-eliminar-reporte" data-id="' + Number(reporte.id_reporte || 0) + '">Eliminar</button>' +
                        '</td>' +
                    '</tr>';

                $tbody.append(fila);
            });
        }

        function cargarPacientesActivosReporte() {
            var $selectPaciente = $('#reportePaciente');
            $selectPaciente.empty();
            $selectPaciente.append('<option value="" selected disabled>Cargando pacientes...</option>');

            CargarPX(function (pacientes) {
                $selectPaciente.empty();
                $selectPaciente.append('<option value="" selected disabled>Selecciona un paciente...</option>');

                var pacientesActivos = pacientes.filter(function (px) {
                    if (typeof px.estatus === 'undefined' || px.estatus === null || px.estatus === '') {
                        return true;
                    }
                    return String(px.estatus).toLowerCase() === 'activo';
                });

                if (!pacientesActivos.length) {
                    $selectPaciente.append('<option value="" disabled>Sin pacientes activos disponibles</option>');
                    return;
                }

                pacientesActivos.forEach(function (px) {
                    var nombreCompleto = [px.nombre || '', px.apellido || ''].join(' ').trim();
                    $selectPaciente.append(
                        '<option value="' + (px.id_paciente || '') + '">' +
                        nombreCompleto +
                        '</option>'
                    );
                });
            });
        }

        // Carga inicial del select de pacientes
        cargarPacientesActivosReporte();
        // Carga inicial de tabla de reportes
        cargarReportes();

        $('#btnAbrirModalReporte').on('click', function () {
            // Refrescar lista de pacientes al abrir el modal
            cargarPacientesActivosReporte();
            modalReporte.show();
        });

        $('#btnCancelarReporte').on('click', function () {
            modalReporte.hide();
        });

        // Formulario preparado para integración con backend (conn.php)
        $('#formNuevoReporte').on('submit', function (e) {
            e.preventDefault();

            var paciente = $('#reportePaciente').val();
            var tipo = $('#tipoReporte').val();
            var fechaInicio = $('#fechaInicio').val();
            var fechaFin = $('#fechaFin').val();

            // Inserción en BD: validación de campos obligatorios
            if (!paciente || !tipo) {
                iziToast.warning({ title: 'Campos requeridos', message: 'Paciente y tipo de reporte son obligatorios.', position: 'topRight' });
                return;
            }

            if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                iziToast.warning({ title: 'Fechas inválidas', message: 'La fecha de inicio no puede ser mayor a la fecha de fin.', position: 'topRight' });
                return;
            }

            // Toast de procesamiento: visible durante validación y guardado
            iziToast.info({
                id: 'toastProcesando',
                title: 'Procesando',
                message: 'Validando disponibilidad de datos...',
                position: 'topRight',
                timeout: false,
                close: false,
                progressBar: false
            });

            // Validar que existan registros antes de insertar el reporte
            $.ajax({
                url: 'acciones_reportes.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    accion: 'validarDatosReporte',
                    id_paciente: paciente,
                    tipo: tipo,
                    fecha_inicio: fechaInicio,
                    fecha_fin: fechaFin
                }
            }).done(function (validacion) {
                var $toast = document.getElementById('toastProcesando');

                if (!validacion || !validacion.success) {
                    iziToast.hide({}, $toast);
                    iziToast.error({ title: 'Error', message: (validacion && validacion.message) ? validacion.message : 'No se pudo validar el reporte.', position: 'topRight' });
                    return;
                }

                if (!validacion.tiene_datos) {
                    iziToast.hide({}, $toast);
                    iziToast.warning({ title: 'Sin datos', message: 'El paciente no tiene registros para el tipo de reporte seleccionado.', position: 'topRight' });
                    return;
                }

                // Hay datos: proceder a insertar el reporte
                $.ajax({
                    url: 'acciones_reportes.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'guardarReporte',
                        id_paciente: paciente,
                        tipo: tipo,
                        fecha_inicio: fechaInicio,
                        fecha_fin: fechaFin
                    }
                }).done(function (response) {
                    iziToast.hide({}, document.getElementById('toastProcesando'));
                    if (!response || !response.success) {
                        iziToast.error({ title: 'Error', message: (response && response.message) ? response.message : 'No se pudo generar el reporte.', position: 'topRight' });
                        return;
                    }
                    modalReporte.hide();
                    $('#formNuevoReporte')[0].reset();
                    iziToast.success({ title: 'Listo', message: 'Reporte generado correctamente.', position: 'topRight' });
                    cargarReportes();
                }).fail(function () {
                    iziToast.hide({}, document.getElementById('toastProcesando'));
                    iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al generar el reporte.', position: 'topRight' });
                });
            }).fail(function () {
                iziToast.hide({}, document.getElementById('toastProcesando'));
                iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al validar el reporte.', position: 'topRight' });
            });
        });

        // Configuración reusable para los 3 tipos de reporte
        var configuracionReportes = {
            'Historial Completo': {
                columnas: [
                    { key: 'diagnostico', label: 'Diagnóstico' },
                    { key: 'antecedentes', label: 'Antecedentes' },
                    { key: 'exploracion', label: 'Exploración' },
                    { key: 'tratamiento', label: 'Tratamiento' },
                    { key: 'fecha_registro', label: 'Fecha de registro', formatter: formatearFecha, nowrap: true }
                ]
            },
            'Sesiones Realizadas': {
                columnas: [
                    { key: 'fecha_cita', label: 'Fecha de cita', formatter: formatearFecha, nowrap: true },
                    { key: 'hora', label: 'Hora', nowrap: true },
                    { key: 'tipo_tratamiento', label: 'Tipo de tratamiento' },
                    { key: 'notas', label: 'Notas' },
                    { key: 'fecha_registro', label: 'Fecha de registro', formatter: formatearFecha, nowrap: true }
                ]
            },
            'Resumen de Tratamientos': {
                columnas: [
                    { key: 'tipo_tratamiento', label: 'Tipo de tratamiento' },
                    { key: 'total_sesiones', label: 'Total de sesiones', nowrap: true },
                    { key: 'ultima_sesion', label: 'Última sesión', formatter: formatearFecha, nowrap: true }
                ]
            }
        };

        // Funciones globales de reportes para reutilización desde cualquier tipo o evento
        window.Reportes = {
            abrirReporte: function (tipo, idPaciente, nombrePaciente) {
                var config = configuracionReportes[tipo] || null;
                if (!config) {
                    iziToast.error({ title: 'Error', message: 'Tipo de reporte no soportado.', position: 'topRight' });
                    return;
                }

                if (!idPaciente) {
                    iziToast.error({ title: 'Error', message: 'No se pudo identificar el paciente.', position: 'topRight' });
                    return;
                }

                $('#modalHistorialClinicoLabel').text(tipo);
                $('#historialNombrePaciente').text(nombrePaciente || '-');

                // Estado inicial de carga y apertura de modal
                this.pintarReporte(tipo, null);
                modalHistorial.show();

                $.ajax({
                    url: 'acciones_reportes.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'obtenerDatosReporte',
                        id_paciente: idPaciente,
                        tipo: tipo
                    }
                }).done(function (response) {
                    if (!response || !response.success) {
                        window.Reportes.pintarReporte(tipo, []);
                        iziToast.error({ title: 'Error', message: (response && response.message) ? response.message : 'No se pudo cargar el reporte.', position: 'topRight' });
                        return;
                    }

                    if (response.paciente) {
                        $('#historialNombrePaciente').text(response.paciente);
                    }

                    window.Reportes.pintarReporte(tipo, response.data || []);
                }).fail(function () {
                    window.Reportes.pintarReporte(tipo, []);
                    iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al cargar el reporte.', position: 'topRight' });
                });
            },

            pintarReporte: function (tipo, registros) {
                var config = configuracionReportes[tipo] || null;
                var columnas = config ? config.columnas : [];
                var $thead = $('#encabezadoReporteDinamico');
                var $tbody = $('#tablaHistorialClinico tbody');

                $thead.empty();
                $tbody.empty();

                if (!columnas.length) {
                    $thead.append('<tr><th>Sin configuración</th></tr>');
                    $tbody.append('<tr><td class="text-center text-muted py-3">No hay columnas configuradas para este reporte.</td></tr>');
                    return;
                }

                var encabezado = '<tr>';
                columnas.forEach(function (col) {
                    encabezado += '<th' + (col.nowrap ? ' class="text-nowrap"' : '') + '>' + escaparHtml(col.label) + '</th>';
                });
                encabezado += '</tr>';
                $thead.append(encabezado);

                if (registros === null) {
                    $tbody.append('<tr><td colspan="' + columnas.length + '" class="text-center text-muted py-3">Cargando...</td></tr>');
                    return;
                }

                if (!registros.length) {
                    $tbody.append('<tr><td colspan="' + columnas.length + '" class="text-center text-muted py-3">Sin datos disponibles para este reporte.</td></tr>');
                    return;
                }

                registros.forEach(function (reg) {
                    var fila = '<tr>';
                    columnas.forEach(function (col) {
                        var valor = typeof reg[col.key] === 'undefined' || reg[col.key] === null ? '' : reg[col.key];
                        if (typeof col.formatter === 'function') {
                            valor = col.formatter(String(valor));
                        }
                        fila += '<td' + (col.nowrap ? ' class="text-nowrap"' : '') + '>' + escaparHtml(String(valor)) + '</td>';
                    });
                    fila += '</tr>';
                    $tbody.append(fila);
                });
            }
        };

        // Extrae encabezados y filas visibles de la tabla del reporte abierto
        function extraerDatosTabla() {
            var columnas = [];
            $('#encabezadoReporteDinamico th').each(function () {
                columnas.push($(this).text().trim());
            });
            var filas = [];
            $('#tablaHistorialClinico tbody tr').each(function () {
                var $celdas = $(this).find('td');
                // Omitir filas de estado (colspan): cargando / sin datos
                if ($celdas.length === 1 && $celdas.first().attr('colspan')) return;
                var fila = [];
                $celdas.each(function () { fila.push($(this).text().trim()); });
                filas.push(fila);
            });
            return { columnas: columnas, filas: filas };
        }

        $('#btnExportarPDF').on('click', function () {
            var datos = extraerDatosTabla();
            if (!datos.filas.length) {
                iziToast.warning({ title: 'Sin datos', message: 'No hay datos para exportar.', position: 'topRight' });
                return;
            }
            var titulo   = $('#modalHistorialClinicoLabel').text();
            var paciente = $('#historialNombrePaciente').text();
            var doc = new window.jspdf.jsPDF({ orientation: 'landscape' });
            doc.setFontSize(13);
            doc.text(titulo, 14, 15);
            doc.setFontSize(9);
            doc.text('Paciente: ' + paciente, 14, 22);
            doc.autoTable({
                head: [datos.columnas],
                body: datos.filas,
                startY: 28,
                styles: { fontSize: 8 },
                headStyles: { fillColor: [52, 144, 220] }
            });
            doc.save(titulo + ' - ' + paciente + '.pdf');
        });

        $('#btnExportarExcel').on('click', function () {
            var datos = extraerDatosTabla();
            if (!datos.filas.length) {
                iziToast.warning({ title: 'Sin datos', message: 'No hay datos para exportar.', position: 'topRight' });
                return;
            }
            var titulo   = $('#modalHistorialClinicoLabel').text();
            var paciente = $('#historialNombrePaciente').text();
            var aoa = [datos.columnas].concat(datos.filas);
            var ws = XLSX.utils.aoa_to_sheet(aoa);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, titulo.substring(0, 31));
            XLSX.writeFile(wb, titulo + ' - ' + paciente + '.xlsx');
        });

        // Tabla: acciones básicas
        $(document).on('click', '.btn-ver-reporte', function () {
            var idReporte  = Number($(this).data('id') || 0);
            var tipo       = String($(this).data('tipo') || '');
            var idPaciente = Number($(this).data('id-paciente') || 0);
            var paciente   = String($(this).data('paciente') || '');

            if (!idReporte) {
                iziToast.error({ title: 'Error', message: 'No se pudo identificar el reporte.', position: 'topRight' });
                return;
            }

            // Reutiliza la misma apertura global para los 3 tipos de reporte
            if (configuracionReportes[tipo]) {
                window.Reportes.abrirReporte(tipo, idPaciente, paciente);
                return;
            }

            // Otros tipos: modal de detalle genérico
            $.ajax({
                url: 'acciones_reportes.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    accion: 'obtenerReporteDetalle',
                    id_reporte: idReporte
                }
            }).done(function (response) {
                if (!response || !response.success || !response.data) {
                    iziToast.error({ title: 'Error', message: (response && response.message) ? response.message : 'No se pudo obtener el detalle del reporte.', position: 'topRight' });
                    return;
                }

                var detalle = response.data;
                $('#detallePaciente').text(detalle.paciente || '-');
                $('#detalleTipo').text(detalle.tipo || '-');
                $('#detalleFecha').text(formatearFecha(detalle.fecha_generado || ''));
                $('#detalleTelefono').text(detalle.telefono || 'N/A');
                $('#detalleCorreo').text(detalle.correo || 'N/A');
                modalDetalle.show();
            }).fail(function () {
                iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al obtener el detalle del reporte.', position: 'topRight' });
            });
        });

        $(document).on('click', '.btn-descargar-reporte', function () {
            var idReporte = Number($(this).data('id') || 0);
            if (!idReporte) {
                iziToast.error({ title: 'Error', message: 'No se pudo identificar el reporte para descarga.', position: 'topRight' });
                return;
            }

            window.open('acciones_reportes.php?accion=descargarReporte&id_reporte=' + idReporte, '_blank');
        });

        $(document).on('click', '.btn-eliminar-reporte', function () {
            var idReporte = Number($(this).data('id') || 0);
            if (!idReporte) {
                iziToast.error({ title: 'Error', message: 'No se pudo identificar el reporte a eliminar.', position: 'topRight' });
                return;
            }

            iziToast.question({
                title: 'Eliminar reporte',
                message: '¿Deseas eliminar este reporte?',
                position: 'center',
                timeout: false,
                overlay: true,
                closeOnOverlayClick: false,
                buttons: [
                    ['<button>Sí, eliminar</button>', function (instance, toast) {
                        instance.hide({}, toast);
                        $.ajax({
                            url: 'acciones_reportes.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                accion: 'eliminarReporte',
                                id_reporte: idReporte
                            }
                        }).done(function (response) {
                            if (!response || !response.success) {
                                iziToast.error({ title: 'Error', message: (response && response.message) ? response.message : 'No se pudo eliminar el reporte.', position: 'topRight' });
                                return;
                            }
                            iziToast.success({ title: 'Listo', message: 'Reporte eliminado correctamente.', position: 'topRight' });
                            cargarReportes();
                        }).fail(function () {
                            iziToast.error({ title: 'Error de conexión', message: 'Error de conexión al eliminar el reporte.', position: 'topRight' });
                        });
                    }],
                    ['<button>Cancelar</button>', function (instance, toast) {
                        instance.hide({}, toast);
                    }]
                ]
            });
        });
    });
</script>
</body>
</html>
