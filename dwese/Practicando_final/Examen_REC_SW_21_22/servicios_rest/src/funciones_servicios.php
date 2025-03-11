<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';
require "config_bd.php";

function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if (!$conexion)
        $respuesta["error"] = "Imposible conectar:" . mysqli_connect_errno() . " : " . mysqli_connect_error();
    else {
        mysqli_set_charset($conexion, "utf8");
        $respuesta["mensaje"] = "Conexion a la BD realizada con exito";
        mysqli_close($conexion);
    }
    return $respuesta;
}

function validateToken()
{

    $headers = apache_request_headers();
    if (!isset($headers["Authorization"]))
        return false; //Sin autorizacion
    else {
        $authorization = $headers["Authorization"];
        $authorizationArray = explode(" ", $authorization);
        $token = $authorizationArray[1];
        try {
            $info = JWT::decode($token, new Key(PASSWORD_API, 'HS256'));
        } catch (\Throwable $th) {
            return false; //Expirado
        }

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
            return $respuesta;
        }

        try {
            $consulta = "select * from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$info->data]);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
            $sentencia = null;
            $conexion = null;
            return $respuesta;
        }
        if ($sentencia->rowCount() > 0) {
            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            $payload['exp'] = time() + 3600;
            $payload['data'] = $respuesta["usuario"]["id_usuario"];
            $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
            $respuesta["token"] = $jwt;
        } else
            $respuesta["mensaje_baneo"] = "El usuario no se encuentra registrado en la BD";

        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
}

function login($usario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);


        $payload = ['exp' => time() + 3600, 'data' => $respuesta["usuario"]["id_usuario"]];
        $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
        $respuesta["token"] = $jwt;
    } else
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_grupos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from grupos";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_todos_profesores()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario<>'admin'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["profesores"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_horario($id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from horario_lectivo where grupo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_grupo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function obtener_profesores($dia, $hora, $id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select usuarios.id_usuario, usuarios.usuario, aulas.nombre from usuarios join horario_lectivo on horario_lectivo.usuario = usuarios.id_usuario join aulas on aulas.id_aula = horario_lectivo.aula where horario_lectivo.dia=? and horario_lectivo.hora=? and grupo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["profesores"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function borrar_profesor($dia, $hora, $id_grupo, $id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "delete from horario_lectivo where dia=? and hora=? and grupo=? and usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo, $id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El profesor con id: " . $id_usuario . " se ha quitado de la tabla horario_lectivo";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function horario_profesor($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as grupo, aulas.nombre as aula from horario_lectivo join grupos on grupos.id_grupo = horario_lectivo.grupo join aulas on aulas.id_aula = horario_lectivo.aula where usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_profesores_libres($dia, $hora, $id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select id_usuario, usuario from usuarios where usuario<>'admin' and id_usuario not in (select usuarios.id_usuario from usuarios join horario_lectivo on horario_lectivo.usuario = usuarios.id_usuario join aulas on aulas.id_aula = horario_lectivo.aula where horario_lectivo.dia=? and horario_lectivo.hora=? and grupo=?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["profesores_libres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_aulas()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from aulas";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["aulas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function insertar_profesor($dia, $hora, $id_grupo, $id_usuario, $id_aula)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into horario_lectivo (dia, hora, grupo, usuario, aula) values (?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo, $id_usuario, $id_aula]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El profesor con id: " . $id_usuario . " se ha insertado en la tabla horario_lectivo";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function editar_profesor($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "update usuarios set usuario=?, clave=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $filas_afectadas = $sentencia->rowCount();
    if ($filas_afectadas == 0) {
        $respuesta["error"] = "No se realizó ninguna actualización, puede que los datos sean los mismos." . $datos[0] . " ----" . $datos[1] . " " . $datos[2];
        return $respuesta;
    } else {
        $respuesta["mensaje"] = "El profesor con cod: " . end($datos) . " se ha actualizado correctamente";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_editando($tabla, $columna, $valor, $columna_id, $valor_id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=? and " . $columna_id . "<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_id]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"] = $sentencia->rowCount() > 0;


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
