<?php

//obtener tabla
$app->get('/tabla', function () {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin")
                echo json_encode(obtener_tabla());
            else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function obtener_tabla()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from tabla";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["tabla"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//peticion tabla
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/tabla";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_tabla = json_decode($respuesta, true);
if (!$json_tabla) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_tabla["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_tabla["error"])) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>" . $json_tabla["error"] . "</p>"));
}

if (isset($json_tabla["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

//obtener tabla con atributo, multiples resultados
$app->get('/tabla/{atributo}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $atributo = $request->getAttribute("atributo");
                echo json_encode(obtener_tabla_con_atributo($atributo));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function obtener_tabla_con_atributo($atributo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from tabla where atributo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$atributo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["tabla"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//obtener datos de varias tablas con varios atributos
$app->get('/profesores/{dia}/{hora}/{id_grupo}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getAttribute("dia");
                $hora = $request->getAttribute("hora");
                $id_grupo = $request->getAttribute("id_grupo");
                echo json_encode(obtener_profesores($dia, $hora, $id_grupo));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function obtener_profesores($dia, $hora, $id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        //si quiro cambiarle el nombre a algun atributo para locaizarlo mejor puedo pponer "as x", donde x es el nombre que quiero
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

//hice una funcion ya que lo iba a usar varias veces
function servicio_mostrar_profesores($dia, $hora, $id_grupo)
{
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/profesores/" . $dia . "/" . $hora . "/" . $id_grupo;
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores = json_decode($respuesta, true);
    if (!$json_profesores) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_profesores["error"] . "</p>"));
    }

    if (isset($json_profesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    return $json_profesores;
}

//borrar entrada de una tabla con atributos
$app->delete('/borrarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getAttribute("dia");
                $hora = $request->getAttribute("hora");
                $id_grupo = $request->getAttribute("id_grupo");
                $id_usuario = $request->getAttribute("id_usuario");
                echo json_encode(borrar_profesor($dia, $hora, $id_grupo, $id_usuario));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

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

if (isset($_POST["btnQuitar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/borrarProfesor/" . urlencode($_POST["dia"]) . "/" . urlencode($_POST["hora"]) . "/" . urlencode($_POST["grupo"]) . "/" . urlencode($_POST["id_usuario"]);
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrar = json_decode($respuesta, true);
    if (!$json_borrar) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_borrar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_borrar["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_borrar["error"] . "</p>"));
    }

    if (isset($json_borrar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje"] = "¡¡ Profesor quitado con éxito !!";
}

//tabla horario guardias grupos de un profesor
$horario = $json_horario["horario"];
$horas = ["", "8:15-9:15", "9:15-10:15", "10:15-11:15", "11:15-11:45", "11:45-12:45", "12:45-13:45", "13:45-14:45"];
echo "<table>";
echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
for ($hora = 1; $hora <= 7; $hora++) {
    echo "<tr>";
    echo "<td>" . $horas[$hora] . "</td>";
    if ($hora == 4) {
        echo "<td colspan='5'>Recreo</td>";
    } else {
        for ($dia = 1; $dia <= 5; $dia++) {
            echo "<td>";
            foreach ($horario as $tupla) {

                if ($tupla["dia"] == $dia && $tupla["hora"] == $hora) {
                    echo $tupla["grupo"] . "<br>";
                }
            }
            //para que el aula no se repita
            foreach ($horario as $tupla) {
                if ($tupla["dia"] == $dia && $tupla["hora"] == $hora) {
                    echo $tupla["aula"];
                    break;
                }
            }
            echo "</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";
