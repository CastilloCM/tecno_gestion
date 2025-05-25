<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Depuración: Ver valores recibidos
    error_log("Intento de login con email: $email");

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            error_log("Usuario encontrado: " . print_r($usuario, true));
            
            // Verificación mejorada
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario'] = $usuario['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                error_log("Falló password_verify para usuario: $email");
            }
        } else {
            error_log("No se encontró usuario con email: $email");
        }
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage());
    }

    // Mensaje genérico por seguridad
    echo "<script>alert('Correo o contraseña incorrectos'); window.location='index.php';</script>";
}
?>






