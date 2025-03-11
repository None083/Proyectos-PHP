<?php

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

if (isset($_POST["btn_editar"]) || isset($_POST["btnAgregar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/profesoresLibres/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["grupo"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores_libres = json_decode($respuesta, true);
    if (!$json_profesores_libres) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores_libres["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores_libres["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_profesores_libres["error"] . "</p>"));
    }

    if (isset($json_profesores_libres["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/aulas";
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_aulas = json_decode($respuesta, true);
    if (!$json_aulas) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_aulas["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_aulas["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_aulas["error"] . "</p>"));
    }

    if (isset($json_aulas["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnAgregar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/insertarProfesor";
    $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers, $_POST);
    $json_agregar = json_decode($respuesta, true);
    if (!$json_agregar) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_agregar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_agregar["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_agregar["error"] . "</p>"));
    }

    if (isset($json_agregar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje"] = "¡¡ Profesor agregado con éxito !!";
}

if (isset($_POST["btnHorario"]) || isset($_POST["btn_editar"]) || isset($_POST["btnQuitar"]) || isset($_POST["btnAgregar"])) {
    if (isset($_POST["btnEditar"])) {
        $_POST["grupo"] = $_POST["btn_editar"];
    }
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/horario/" . urlencode($_POST["grupo"]);
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_horario = json_decode($respuesta, true);
    if (!$json_horario) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_horario["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_horario["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_horario["error"] . "</p>"));
    }

    if (isset($json_horario["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
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

if (isset($_POST["editarProfe"])) {
    $error_usuario_vacio = $_POST["usuario_profe"] == "";
    if (!$error_usuario_vacio) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/usuarios/usuario/" . urlencode($_POST["usuario_profe"]) . "/id_usuario/" . urlencode($_POST["usuario_profe"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Examen5 PHP", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Examen5 PHP", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset(); //Me deslogueo
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_usuario_profe = $json_repetido["repetido"];
    }

    if (!$error_usuario_profe) {
        //edito y salto con mensaje
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/profesor/editar/" . urlencode($_POST["editarProfe"]);
        
        $respuesta = consumir_servicios_JWT_REST($url, "PUT", $headers, $_POST);
        $json_actualizar = json_decode($respuesta, true);
        if (!$json_actualizar) {
            session_destroy();
            die(error_page("Examen5 PHP", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));
        }

        if (isset($json_actualizar["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_actualizar["error"])) {
            session_destroy();
            die(error_page("Examen5 PHP", "<p>" . $json_actualizar["error"] . "</p>"));
        }

        if (isset($json_actualizar["mensaje_baneo"])) {
            session_unset(); //Me deslogueo
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje"] = "¡¡ Profesor actualizado con éxito !!";
    }
}

//peticion grupos
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/grupos";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_grupos = json_decode($respuesta, true);
if (!$json_grupos) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_grupos["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_grupos["error"])) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>" . $json_grupos["error"] . "</p>"));
}

if (isset($json_grupos["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/profesores";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_todos_profesores = json_decode($respuesta, true);
if (!$json_todos_profesores) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_todos_profesores["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_todos_profesores["error"])) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>" . $json_todos_profesores["error"] . "</p>"));
}

if (isset($json_todos_profesores["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th,
        td {
            padding: 5px
        }

        th {
            background-color: lightgray
        }
    </style>
    <title>Examen5 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }
    </style>
</head>

<body>
    <h1>Examen5 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h2>Horario de los Grupos</h2>
    <Form method="post" action="index.php">
        <p>
            <label for="grupo">Elija el grupo: </label>
            <select name="grupo" id="grupo">
                <?php
                /*foreach ($json_grupos["grupos"] as $tupla) {
                    echo "<option value='" . $tupla["id_grupo"] . "' " . (isset($_POST["btnHorario"]) && $_POST["grupo"] == $tupla["id_grupo"] ? 'selected' : '') . ">" . $tupla["nombre"] . "</option>";
                }*/
                foreach ($json_grupos["grupos"] as $tupla) {
                    if (isset($_POST["grupo"]) && $_POST["grupo"] == $tupla["id_grupo"]) {
                        echo "<option value='" . $tupla["id_grupo"] . "' selected>" . $tupla["nombre"] . "</option>";
                    } else {
                        echo "<option value='" . $tupla["id_grupo"] . "'>" . $tupla["nombre"] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="btnHorario">Ver Horario</button>
        </p>
    </Form>
    <?php

    if (isset($_SESSION["mensaje"])) {
        echo "<p>" . $_SESSION["mensaje"] . "</p>";
        unset($_SESSION["mensaje"]);
    }

    if (isset($_POST["grupo"]) || isset($_POST["btn_editar"]) || isset($_POST["btnQuitar"])) {
        $id_grupo = $_POST["grupo"];
        $nombre_grupo = "";
        foreach ($json_grupos["grupos"] as $tupla) {
            if ($tupla["id_grupo"] == $id_grupo) {
                $nombre_grupo = $tupla["nombre"];
                break;
            }
        }
        echo "<h3>Horario del grupo: " . $nombre_grupo . "</h3>";

        $horas = ["", "8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        $dias = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        $horario = $json_horario["horario"];

        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($hora = 1; $hora <= 7; $hora++) {
            echo "<tr>";
            echo "<td>" . $horas[$hora] . "</td>";
            if ($hora == 4) {
                echo "<td colspan='5'>Recreo</td>";
            } else {
                for ($dia = 1; $dia <= 5; $dia++) {

                    $datos_celda = servicio_mostrar_profesores($dia, $hora, $id_grupo);
                    echo "<td>";
                    foreach ($datos_celda["profesores"] as $datos) {
                        echo $datos["usuario"] . " (" . $datos["nombre"] . ")<br>";
                    }
                    echo "<form method='post'><button type='submit' name='btn_editar'>Editar</button><input type='hidden' name='grupo' value='" . $id_grupo . "'/><input type='hidden' name='dia' value='" . $dia . "'/><input type='hidden' name='hora' value='" . $hora . "'/></form></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        if (isset($_POST["btn_editar"]) || isset($_POST["btnAgregar"])) {
            $dia = $_POST["dia"];
            $hora = $_POST["hora"];
            $id_grupo = $_POST["grupo"];
            $datos_celda = servicio_mostrar_profesores($dia, $hora, $id_grupo);

            echo "<h3>Editando la " . $_POST["hora"] . "º Hora (" . $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h3>";

            echo "<table>";
            echo "<tr><th>Profesor (Aula)</th><th>Acción</th></tr>";
            foreach ($datos_celda["profesores"] as $datos) {
                echo "<tr><td>" . $datos["usuario"] . " (" . $datos["nombre"] . ")</td><td><form method='post'><button type='submit' name='btnQuitar' >Quitar</button><input type='hidden' name='grupo' value='" . $id_grupo . "'/><input type='hidden' name='dia' value='" . $dia . "'/><input type='hidden' name='hora' value='" . $hora . "'/><input type='hidden' name='id_usuario' value='" . $datos["id_usuario"] . "'/></form></td></tr>";
            }
            echo "</table>";

            echo "<form method='post'>";
            echo "<p><label for='profesor'>Elija profesor: </label><select name='profesor' id='profesor'>";
            foreach ($json_profesores_libres["profesores_libres"] as $tupla) {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["usuario"] . "</option>";
            }
            echo "</select>";
            echo "<label for='aula'> Elija aula: </label><select name='aula' id='aula'>";
            foreach ($json_aulas["aulas"] as $tupla) {
                echo "<option value='" . $tupla["id_aula"] . "'>" . $tupla["nombre"] . "</option>";
            }
            echo "</select> ";
            echo "<button type='submit' name='btnAgregar'>Agregar</button><input type='hidden' name='grupo' value='" . $id_grupo . "'/><input type='hidden' name='dia' value='" . $dia . "'/><input type='hidden' name='hora' value='" . $hora . "'/></p>";
            echo "</form>";

            if (isset($_POST["btnAgregar"])) {
                echo "Datos enviados: " . $_POST["grupo"] . " - " . $_POST["dia"] . " - " . $_POST["hora"] . " - " . $_POST["profesor"] . " - " . $_POST["aula"];
            }
        }
    }
    ?>
    <form method="post">
        <p>
            <label for="todos_profesores">Elija el profesor: </label>
            <select name="todos_profesores" id="todos_profesores">
                <?php
                foreach ($json_todos_profesores["profesores"] as $tupla) {
                    if (isset($_POST["todos_profesores"]) && $_POST["todos_profesores"] == $tupla["id_usuario"]) {
                        echo "<option value='" . $tupla["id_usuario"] . "' selected>" . $tupla["usuario"] . "</option>";
                    } else {
                        echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["usuario"] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="seleccionarProfe">Editar profe</button>
        </p>
    </form>
    <?php
    if (isset($_POST["seleccionarProfe"]) || isset($_POST["editarProfe"])) {
        echo "<form method='post'><p>
            <label for='usuario_profe'>Usuario: </label>
            <input type='text' value='";
        if (isset($_POST["todos_profesores"])) {
            echo $_POST["todos_profesores"];
        }
        echo "' name='usuario_profe' id='usuario_profe'>";
        echo "</p>
            <p>
            <label for='clave_profe'>Clave: </label>
            <input type='password' name='clave_profe' id='clave_profe'>
            </p>
            <button type='submit' value='". $_POST["todos_profesores"]."' name='editarProfe'>Editar profesor</button></form>";
        if (isset($_POST["seleccionarProfe"]) && $_POST["seleccionarProfe"] &&  $error_usuario_profe) {
            echo "<p>El usuario ya existe</p>";
        }
    }
    
    ?>
</body>

</html>