<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $stmt = $pdo->prepare("INSERT INTO clientes (nombre, correo, telefono) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $correo, $telefono]);

    header("Location: clientes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4 text-primary"><i class="fas fa-user-plus me-2"></i>Agregar Cliente</h3>

        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ej: correo@ejemplo.com" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ej: 987654321" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="clientes.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Cancelar</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Guardar Cliente</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
