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

function insertar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into producto (cod, nombre, nombre_corto, descripcion, PVP, familia) values (?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["mensaje"] = "El producto con cod:" .$datos[0]."se ha insertado correctamente";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function actualizar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "update producto set nombre=?, nombre_corto=?, descripcion=?, PVP=?, familia=? where cod=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["mensaje"] = "El producto con cod:" . $datos[5] . "se ha actualizado correctamente";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function borrar_producto($cod)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "delete from producto where cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["mensaje"] = "El producto con cod:" . $cod . "se ha borrado correctamente";;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_familias()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from familia";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["familias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_insertando($tabla, $columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * ".$columna." from ".$tabla." where ".$columna ."=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($valor);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["repetido"] = $sentencia->rowCount()>0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_editando($tabla, $columna, $valor, $columna_id, $valor_id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * " . $columna . " from " . $tabla . " where " . $columna . "=? and ".$columna_id."<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_id]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error al conectar con la base de datos: " . $e->getMessage();
        return $respuesta;
    }
    $respuesta["repetido"] = $sentencia->rowCount() > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}