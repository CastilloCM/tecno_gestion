<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'config.php';

// Eliminar cliente
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: clientes.php");
    exit;
}

// Variables de paginación y búsqueda
$por_pagina = 5;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$params = [];
$sql_busqueda = "";

if ($buscar !== '') {
    $sql_busqueda = " WHERE nombre LIKE ? ";
    $params[] = "%$buscar%";
}

// Total registros
$sql_total = "SELECT COUNT(*) FROM clientes $sql_busqueda";
$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute($params);
$total_registros = $stmt_total->fetchColumn();
$total_paginas = ceil($total_registros / $por_pagina);

// Obtener clientes filtrados
$sql = "SELECT * FROM clientes $sql_busqueda ORDER BY id DESC LIMIT $inicio, $por_pagina";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary">Gestión de Clientes</h4>
        <div>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm me-2">Menú Principal</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
        </div>
    </div>

    <!-- Formulario de búsqueda -->
    <form method="GET" class="input-group mb-3">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar cliente por nombre..." value="<?= htmlspecialchars($buscar) ?>">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <!-- Botón Agregar Cliente -->
    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_cliente.php" class="btn btn-success">
            <i class="bi bi-person-plus-fill"></i> Agregar Cliente
        </a>
    </div>

    <!-- Tabla de clientes -->
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($clientes): ?>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td><?= htmlspecialchars($c['correo']) ?></td>
                        <td><?= htmlspecialchars($c['telefono']) ?></td>
                        <td>
                            <a href="editar_cliente.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a> 
                                                      
                            <a href="clientes.php?eliminar=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger me-1" title="Eliminar" onclick="return confirm('¿Eliminar este cliente?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No se encontraron clientes.</td></tr>
            <?php endif ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&buscar=<?= urlencode($buscar) ?>">Anterior</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>&buscar=<?= urlencode($buscar) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina < $total_paginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&buscar=<?= urlencode($buscar) ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Botón de Reporte PDF -->
    <div class="text-end mt-4">
        <a href="reporte_pdf.php" class="btn btn-outline-dark">
            <i class="bi bi-file-earmark-pdf-fill"></i> Generar Reporte PDF
        </a>
    </div>
</div>

</body>
</html>
