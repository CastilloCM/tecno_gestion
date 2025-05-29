<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit;
}

$id = $_GET['id'];

// Obtener datos del cliente
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

// Actualizar datos si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    // Validar campos
    if ($nombre === '' || $correo === '' || $telefono === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $pdo->prepare("UPDATE clientes SET nombre = ?, correo = ?, telefono = ? WHERE id = ?");
        $stmt->execute([$nombre, $correo, $telefono, $id]);
        header("Location: clientes.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h4 class="text-primary mb-4">Editar Cliente</h4>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control" value="<?= htmlspecialchars($cliente['correo']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Cambios</button>
        </div>
    </form>
</div>

</body>
</html>

