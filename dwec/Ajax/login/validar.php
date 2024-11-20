<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($nombre === "admin" && $password === "1234") {
        echo "Usuario válido";
    } else {
        echo "Usuario no válido";
    }
} else {
    echo "Método no permitido.";
}
?>
