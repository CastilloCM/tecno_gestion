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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow p-4 border rounded">
                <h2 class="text-center mb-4 text-primary">Acceso al sistema</h2>
                <h5 class="text-center mb-4">TecnoSoluciones S.A.</h5>

                <!-- Mensaje de error -->
                <?php if ($error): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="usuario.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="usuario@empresa.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small>¿No tienes una cuenta? <a href="registrar_usuario.php">Regístrate aquí</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
