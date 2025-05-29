<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css" />
   
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card dashboard-card shadow p-5 text-center">
        <h1 class="mb-4 text-primary fw-bold">TecnoSoluciones</h1>
        <h3 class="mb-4 text-dark">Panel Principal</h3>
        <p class="mb-5 text-muted">Selecciona una sección para comenzar a gestionar la información.</p>

        <div class="d-grid gap-3 mb-4">
            <a href="clientes.php" class="btn btn-outline-primary btn-lg">Gestión de Clientes</a>
            <a href="proyectos.php" class="btn btn-outline-success btn-lg">Gestión de Proyectos</a>
            <a href="generar_reportes.php" class="btn btn-outline-info btn-lg">Generar Reportes</a>

        </div>

        <a href="logout.php" class="btn btn-danger btn-lg">Cerrar sesión</a>
    </div>

</body>
</html>


