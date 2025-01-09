<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

function obtener_productos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from producto";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_producto($cod)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from producto where cod = " . $cod;
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["producto"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
