<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - FISIOMAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="funcionesJS.js"></script>
<script>
    $(function () {
        // Encabezado: inicialización del modal
        // Interacciones básicas del modal
        var modalReporteEl = document.getElementById('modalNuevoReporte');
        var modalReporte = new bootstrap.Modal(modalReporteEl);
        var modalDetalleEl = document.getElementById('modalDetalleReporte');
        var modalDetalle = new bootstrap.Modal(modalDetalleEl);

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
                }
            }).fail(function () {
                pintarTablaReportes([]);
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
                            '<button type="button" class="btn btn-sm btn-outline-primary btn-ver-reporte me-1" data-id="' + Number(reporte.id_reporte || 0) + '">Ver</button>' +
                            '<button type="button" class="btn btn-sm btn-outline-success btn-descargar-reporte me-1" data-id="' + Number(reporte.id_reporte || 0) + '">Descargar</button>' +
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
                alert('Paciente y tipo de reporte son obligatorios.');
                return;
            }

            if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                alert('La fecha de inicio no puede ser mayor a la fecha de fin.');
                return;
            }

            // Inserción en BD: guardar reporte
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
                if (!response || !response.success) {
                    alert((response && response.message) ? response.message : 'No se pudo generar el reporte.');
                    return;
                }

                modalReporte.hide();
                $('#formNuevoReporte')[0].reset();
                cargarReportes();
            }).fail(function () {
                alert('Error de conexión al generar el reporte.');
            });
        });

        // Tabla: acciones básicas
        $(document).on('click', '.btn-ver-reporte', function () {
            var idReporte = Number($(this).data('id') || 0);
            if (!idReporte) {
                alert('No se pudo identificar el reporte.');
                return;
            }

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
                    alert((response && response.message) ? response.message : 'No se pudo obtener el detalle del reporte.');
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
                alert('Error de conexión al obtener el detalle del reporte.');
            });
        });

        $(document).on('click', '.btn-descargar-reporte', function () {
            var idReporte = Number($(this).data('id') || 0);
            if (!idReporte) {
                alert('No se pudo identificar el reporte para descarga.');
                return;
            }

            window.open('acciones_reportes.php?accion=descargarReporte&id_reporte=' + idReporte, '_blank');
        });

        $(document).on('click', '.btn-eliminar-reporte', function () {
            var idReporte = Number($(this).data('id') || 0);
            if (!idReporte) {
                alert('No se pudo identificar el reporte a eliminar.');
                return;
            }

            if (!confirm('¿Deseas eliminar este reporte?')) {
                return;
            }

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
                    alert((response && response.message) ? response.message : 'No se pudo eliminar el reporte.');
                    return;
                }

                cargarReportes();
            }).fail(function () {
                alert('Error de conexión al eliminar el reporte.');
            });
        });
    });
</script>
</body>
</html>
