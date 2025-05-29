<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cliente_id = $_POST['cliente_id'];

    $stmt = $pdo->prepare("INSERT INTO proyectos (nombre, descripcion, cliente_id) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $cliente_id]);

    header("Location: proyectos.php");
    exit;
}

$clientes = $pdo->query("SELECT id, nombre FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 600px;">
        <h3 class="text-center mb-4 text-primary"><i class="fas fa-folder-plus me-2"></i>Agregar Nuevo Proyecto</h3>

        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del proyecto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Sistema de Ventas" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Descripción breve del proyecto..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente asociado</label>
                <select name="cliente_id" id="cliente_id" class="form-select" required>
                    <option value="">-- Selecciona un cliente --</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="proyectos.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Guardar Proyecto
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
