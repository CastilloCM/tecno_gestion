<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - TecnoSoluciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow rounded-4 p-4">
                <h4 class="text-center text-primary mb-5">Crear cuenta</h4>
                <form action="registrar.php" method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-success w-100">Registrarse</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="index.php">¿Ya tienes una cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
