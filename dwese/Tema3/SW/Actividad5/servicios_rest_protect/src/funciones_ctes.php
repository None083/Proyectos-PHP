<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
//define("USUARIO_BD","root");
//define("CLAVE_BD","");
define("NOMBRE_BD", "bd_tienda");
define("PASSWORD_API", "PASSWORD_DE_MI_APLICACION");

function validateToken() {
    
}

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        $payload = ["exp" => strtotime("now") + 3600, 'data' => $respuesta["usuario"]["id_usuario"]];
        $jwt = JWT::encode($payload, PASSWORD_API, "HAS265");
        $respuesta["token"] = $jwt;
    } else {
        $respuesta["mensanje"] = "El usuario no se encuentra registrado en la BD";
    }


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
