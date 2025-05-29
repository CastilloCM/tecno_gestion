<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Reportes - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg p-5" style="max-width: 600px; margin: auto;">
        <h2 class="text-center mb-4 text-primary fw-bold">Generar Reportes</h2>
        <p class="text-center text-muted mb-4">
            Selecciona el tipo de reporte que deseas generar en PDF.
        </p>

        <!-- Botones grandes para reportes -->
        <div class="d-grid gap-3 mb-4">
            <a href="reporte_pdf.php" class="btn btn-outline-primary btn-lg">
                📄 Reporte de Clientes
            </a>
            <a href="reporte_proyectos_pdf.php" class="btn btn-outline-success btn-lg">
                📊 Reporte de Proyectos
            </a>
        </div>

        <!-- Botones pequeños al final -->
        <div class="d-flex justify-content-center gap-2">
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                🏠 Menú Principal
            </a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                🔒 Cerrar sesión
            </a>
        </div>
    </div>
</div>
</body>
</html>



