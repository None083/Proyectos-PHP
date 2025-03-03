<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$_POST = json_decode(file_get_contents("php://input"), true);

if (!isset($_POST["usuario"]) || !isset($_POST["password"])) {
    echo json_encode(["mensaje" => "Faltan datos"]);
    exit;
}

$usuariosFile = 'usuarios.json';
$usuarios = file_exists($usuariosFile) ? json_decode(file_get_contents($usuariosFile), true) : [];

$usuario = $_POST["usuario"];
$password = md5($_POST["password"]);

if (isset($usuarios[$usuario])) {
    if ($usuarios[$usuario] === $password) {
        $respuesta["usuario"] = $usuario;
        $respuesta["mensaje"] = "Acceso correcto";
    } else {
        $respuesta["mensaje"] = "Contraseña incorrecta.";
    }
} else {
    $usuarios[$usuario] = $password;
    file_put_contents($usuariosFile, json_encode($usuarios, JSON_PRETTY_PRINT));
    $respuesta["usuario"] = $usuario;
    $respuesta["mensaje"] = "Usuario creado correctamente.";
}

echo json_encode($respuesta);
