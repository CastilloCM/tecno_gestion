<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Validar que llegan los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['cliente_id'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cliente_id = $_POST['cliente_id'];

        try {
            $stmt = $pdo->prepare("UPDATE proyectos SET nombre = ?, descripcion = ?, cliente_id = ? WHERE id = ?");
            $stmt->execute([$nombre, $descripcion, $cliente_id, $id]);

            // Redireccionar con éxito
            header("Location: proyectos.php?actualizado=1");
            exit;
        } catch (PDOException $e) {
            echo "Error al actualizar: " . $e->getMessage();
        }
    } else {
        echo "Faltan datos del formulario.";
    }
} else {
    echo "Método de acceso no permitido.";
}
