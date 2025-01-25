<?php
define("SERVIDOR_BD", "localhost");
/*define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");*/
define("USUARIO_BD", "root");
define("CLAVE_BD", "");
define("NOMBRE_BD", "bd_foro");

// a) Mediante una petición GET, obtener todos los datos de todos los usuarios. En caso de error por la BD el JSON devuelto será: { “error” : “Error….”}, en otro caso el JSON será: { “usuarios” : [[…], [...],…,[…]]}
function obtener_usuarios()
{
    //Lo primero es crear la conexión con PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la bd: " . $e->getMessage();
        return $respuesta;
    }

    // Ahora ya se podría hacer la consulta
    try {
        //sentencia de la consulta
        $consulta = "select * from usuarios";
        //se prepara con la conexión realizada previamente con éxito
        $sentencia = $conexion->prepare($consulta);
        //finalmente se ejecuta
        $sentencia->execute();
    } catch (PDOException $e) {
        //si por alguna razón no se completase la consulta se limpiarian la sentencia y la conexion
        $sentencia = null;
        $conexion = null;
        //y se mandaría el mensaje de error correspondiente
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    //si todo está ok se envían los productos
    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    // y se limpian la sentencia y la conexión
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function insertar_usuario($datos){
    try {
        // Conexión a la base de datos
        $conexion = new PDO(
            "mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD,
            USUARIO_BD,
            CLAVE_BD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
        );
    } catch (PDOException $e) {
        // Error al conectarse a la base de datos
        $respuesta["error"] = "No ha podido conectarse a la BD: " . $e->getMessage();
        return $respuesta;
    }

    try {
        // Consulta SQL para insertar el usuario
        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES (?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);

        // Obtener el ID del último usuario insertado
        $ultimoId = $conexion->lastInsertId();

        // Mensaje de éxito personalizado
        $respuesta["mensaje"] = "El usuario con código: " . $ultimoId . " se ha insertado correctamente.";
        $respuesta["ult_id"] = $ultimoId;
    } catch (PDOException $e) {
        // Error al insertar el usuario
        $respuesta["error"] = "No se ha podido insertar el usuario: " . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Liberar recursos y cerrar conexión
    $sentencia = null;
    $conexion = null;

    return $respuesta;
}
