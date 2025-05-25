<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'config.php';

// Insertar cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $stmt = $pdo->prepare("INSERT INTO clientes (nombre, correo, telefono) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $correo, $telefono]);
    header("Location: clientes.php");
}

// Eliminar cliente
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: clientes.php");
}

// Obtener todos los clientes
$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-primary">Gestión de Clientes</h4>
        <a href="dashboard.php" class="btn btn-danger btn-sm">Menú Principal</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
        <a href="reporte_pdf.php" class="btn btn-success">Generar Reporte PDF</a>

    </div>

    <form method="POST" class="row g-2 mb-4">
        <input type="hidden" name="agregar" value="1">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="correo" class="form-control" placeholder="Correo" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Agregar Cliente</button>
        </div>
    </form>

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
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['correo']) ?></td>
                    <td><?= htmlspecialchars($c['telefono']) ?></td>
                    <td>
                        <a href="clientes.php?eliminar=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este cliente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    
</div>

</body>
</html>

