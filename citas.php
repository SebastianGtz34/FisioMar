<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas - FISIOMAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row min-vh-100">
        <aside id="menuContainer" class="col-12 col-lg-2 p-0"></aside>

        <main class="col-12 col-lg-10 p-0">
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center sticky-top">
                <h1 class="h4 mb-0">Agenda de Citas</h1>
                <div class="d-flex align-items-center gap-3 text-secondary">
                    <i class="bi bi-bell"></i>
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </header>

            <div class="p-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h5">Citas</h2>
                        <p class="text-muted mb-0">Placeholder: aquí irá el calendario/listado de citas conectado por AJAX y JSON.</p>
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
            var currentFile = window.location.pathname.split('/').pop() || 'citas.php';
            $('#menu .nav-link').removeClass('active');
            $('#menu .nav-link[data-page="' + currentFile + '"]').addClass('active');
        });
    });
</script>
</body>
</html>
