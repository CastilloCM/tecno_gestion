<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID de proyecto no proporcionado.";
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->execute([$id]);
$proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proyecto) {
    echo "Proyecto no encontrado.";
    exit;
}

// Obtener clientes para el <select>
$clientes = $pdo->query("SELECT id, nombre FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow" style="max-width: 600px; margin: auto;">
        <h2 class="mb-4 text-center text-primary">Editar Proyecto</h2>
        <form action="actualizar_proyecto.php" method="POST">
            <input type="hidden" name="id" value="<?= $proyecto['id'] ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" name="nombre" required value="<?= htmlspecialchars($proyecto['nombre']) ?>">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3"><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select name="cliente_id" class="form-select" required>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $proyecto['cliente_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cliente['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="proyectos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

</body>
</html>

