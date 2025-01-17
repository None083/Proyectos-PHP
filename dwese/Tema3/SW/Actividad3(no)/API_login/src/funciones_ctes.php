<?php
define("SERVIDOR_BD", "localhost");
//define("USUARIO_BD", "jose");
define("USUARIO_BD", "root");
//define("CLAVE_BD", "josefa");
define("CLAVE_BD", "");
define("NOMBRE_BD", "bd_tienda");

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }

    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

