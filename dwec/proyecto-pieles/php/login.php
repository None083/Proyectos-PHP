<?php
header('Access-Control-Allow-Origin: *');
$_POST = json_decode(file_get_contents("php://input"), true);

if ($_POST["usuario"] === "usuario" && $_POST["password"] === md5("1234")) {
    $respuesta["usuario"] = $_POST["usuario"];
    $respuesta["mensaje"] = "Acceso correcto";
} else {
    $respuesta["mensaje"] = "Usuario o contraseña incorrectos.";
}

echo json_encode($respuesta);
?>