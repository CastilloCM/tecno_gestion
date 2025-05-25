<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: clientes.php");
    exit;
}

// Mostrar mensaje de error si lo hay
$error = '';
if (isset($_GET['error'])) {
    $error = "Correo o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded-8 p-4">
                <h4 class="text-center text-primary">Ingreso al Sistema</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger mt-4" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form action="usuario.php" method="POST" class="mt-1">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="text-center mt-3">
                    <small>¿No tienes una cuenta?</small><br>
                    <a href="registrar_usuario.php" class="btn btn-outline-secondary btn-sm mt-1">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>



