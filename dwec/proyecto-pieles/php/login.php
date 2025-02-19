<?php
header('Access-Control-Allow-Origin: *');
require "bd_config.php";
$_POST = json_decode(file_get_contents("php://input"), true);

try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_DB . ";dbname=" . NOMBRE_DB, USUARIO_DB, CLAVE_DB, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $consulta = "SELECT * FROM daw_usuarios WHERE usuario=? AND password=?";
    $datos[] = $_POST["usuario"];
    $datos[] = $_POST["password"];
    try {
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        if ($sentencia->rowCount() > 0) {
            $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
            $respuesta["usuario"] = $tupla["usuario"];
            $respuesta["mensaje"] = "Acceso correcto";
        } else {
            $respuesta["mensaje"] = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        $respuesta["mensaje"] = "Error al intentar realizar la consulta.";
    }
    $sentencia = null;
    $conexion = null;
} catch (PDOException $e) {
    $respuesta["mensaje"] = "Error al intentar conectarse con la BBDD.";
}

echo json_encode($respuesta);
?>

login.php
Mostrando login.php.