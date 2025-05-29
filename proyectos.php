<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

// Eliminar proyecto
if (isset($_GET['eliminar'])) {
    $stmt = $pdo->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
    header("Location: proyectos.php");
    exit;
}

// Obtener proyectos
$stmt = $pdo->query("SELECT proyectos.*, clientes.nombre AS cliente_nombre FROM proyectos
                     JOIN clientes ON proyectos.cliente_id = clientes.id
                     ORDER BY proyectos.id DESC");
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Proyectos - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="css/estilo.css" />

</head>
<body class="bg-light">

<div class="container mt-5">

    <!-- Barra superior reorganizada -->
    <div class="top-bar d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="text-primary fw-bold">Gestión de Proyectos</h2>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="dashboard.php" class="btn btn-outline-secondary">Menú Principal</a>
            <a href="logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
            <a href="nuevo_proyecto.php" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Agregar Proyecto
            </a>
            <a href="reporte_proyectos_pdf.php" class="btn btn-outline-dark">
                <i class="fas fa-file-pdf me-1"></i> Generar Reporte PDF
            </a>
        </div>
    </div>

    <!-- Buscador -->
    <div class="d-flex justify-content-start mb-3">
        <form class="d-flex w-50" role="search">
            <input class="form-control me-2" type="search" placeholder="Buscar proyecto por nombre..." aria-label="Buscar">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <!-- Tabla de proyectos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (count($proyectos) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Cliente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proyectos as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['id']) ?></td>
                                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= htmlspecialchars($p['descripcion']) ?></td>
                                    <td><?= htmlspecialchars($p['cliente_nombre']) ?></td>
                                    <td>
                                        <a href="editar_proyecto.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="proyectos.php?eliminar=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este proyecto?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">No hay proyectos registrados.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
