<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "root");
define("CLAVE_BD", "");
define("NOMBRE_BD", "bd_horarios_exam");

function obtener_usuarios()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select id_usuario,nombre from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje_baneo"] = "No hay usuarios registrados en la BD";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_horario_profesor($id_profesor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select dia,hora,nombre from horario_lectivo, grupos where horario_lectivo.grupo=grupos.id_grupo AND horario_lectivo.usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_profesor]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje_baneo"] = "No hay horario para el profesor con id:" . $id_profesor;

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}