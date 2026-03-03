<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos - FISIOMAR</title>
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
                <div class="card">
                    <div class="card-body">
                        <h2 class="h5">Archivos</h2>
                        <p class="text-muted mb-0">Placeholder: aquí irá la gestión de archivos clínicos por AJAX y JSON.</p>
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
            var currentFile = window.location.pathname.split('/').pop() || 'archivos.php';
            $('#menu .nav-link').removeClass('active');
            $('#menu .nav-link[data-page="' + currentFile + '"]').addClass('active');
        });
    });
</script>
</body>
</html>
