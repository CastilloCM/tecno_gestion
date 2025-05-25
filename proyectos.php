<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

// Insertar nuevo proyecto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'], $_POST['cliente_id'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'] ?? '';
    $cliente_id = $_POST['cliente_id'];

    $stmt = $pdo->prepare("INSERT INTO proyectos (nombre, descripcion, cliente_id) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $cliente_id]);
    header("Location: proyectos.php");
    exit;
}

// Eliminar proyecto
if (isset($_GET['eliminar'])) {
    $stmt = $pdo->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
    header("Location: proyectos.php");
    exit;
}

// Obtener todos los proyectos con el nombre del cliente
$stmt = $pdo->query("SELECT proyectos.*, clientes.nombre AS cliente_nombre FROM proyectos
                     JOIN clientes ON proyectos.cliente_id = clientes.id
                     ORDER BY proyectos.id DESC");
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener clientes para el selector
$clientes = $pdo->query("SELECT id, nombre FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Proyectos - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilo.css" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2>Listado de Proyectos</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        
    </div>
    <a href="dashboard.php" class="btn btn-danger me-2">Menú Principal</a>
    <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
    <a href="reporte_proyectos_pdf.php" class="btn btn-success">Generar Reporte PDF</a>
    </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Descripción</th><th>Cliente</th><th>Acción</th>
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
                        <a href="proyectos.php?eliminar=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proyecto?')">Eliminar</a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr />
    <h4>Agregar nuevo proyecto</h4>
    <form method="POST" action="proyectos.php">
        <div class="mb-3">
            <label>Nombre del proyecto</label>
            <input type="text" name="nombre" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Cliente asociado</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">-- Selecciona un cliente --</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Agregar Proyecto</button>
    </form>
</div>

</body>
</html>
