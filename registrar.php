<?php
session_start();
require_once 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuario (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hash]);
        echo "<script>alert('Usuario registrado con éxito. Ahora puedes iniciar sesión.'); window.location='index.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al registrar usuario: " . $e->getMessage() . "');</script>";
    }
}
?>
