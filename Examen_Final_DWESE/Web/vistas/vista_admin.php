<?php
function mostrar_profesores($dia, $hora)
{
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/usuariosGuardia/" . urldecode($dia) . "/" . urldecode($hora);
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores = json_decode($respuesta, true);
    if (!$json_profesores) {
        session_destroy();
        die(error_page("Examen Final PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<p>" . $json_profesores["error"] . "</p>"));
    }

    if (isset($json_profesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    return $json_profesores["usuarios"];
}

if (isset($_POST["btnDetalles"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/usuario/" . urlencode($_POST["btnDetalles"]);
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesor = json_decode($respuesta, true);
    if (!$json_profesor) {
        session_destroy();
        die(error_page("Examen Final PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesor["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesor["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<p>" . $json_profesor["error"] . "</p>"));
    }

    if (isset($json_profesor["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table,
        td,
        th,
        tr {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        #detalles {
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    $dias[1] = "Lunes";
    $dias[] = "Martes";
    $dias[] = "Miércoles";
    $dias[] = "Jueves";
    $dias[] = "Viernes";

    $horas[1] = "8:15 - 9:15";
    $horas[] = "9:15 - 10:15";
    $horas[] = "10:15 - 11:15";
    $horas[] = "11:15 - 11:45";
    $horas[] = "11:45 - 12:45";
    $horas[] = "12:45 - 13:45";
    $horas[] = "13:45 - 14:45";

    if (isset($_SESSION["mensaje"])) {
        echo "<p>" . $_SESSION["mensaje"] . "</p>";
        unset($_SESSION["mensaje"]);
    }

    echo "<h2>Hoy es " . $dias[date("w")] . "</h2>";
    //var_dump($json_profesores);

    echo "<table>";
    echo "<tr>";
    echo "<th>Hora</th><th>Profesor de Guardia</th><th>Información del Profesor con Id: ";
    if (isset($_POST["btnDetalles"])) {
        echo $_POST["btnDetalles"];
    }
    echo "</th>";
    echo "</tr>";
    for ($hora = 1; $hora <= count($horas); $hora++) {
        echo "<tr><td>" . $horas[$hora] . "</td>";
        echo "<td>";
        foreach (mostrar_profesores(date("w"), $hora) as $tupla) {
            echo "<form method='post'><button type='submit' name='btnDetalles' value='" . $tupla["id_usuario"] . "' class='enlace'>" . $tupla["nombre"] . "</button></form>";
        }
        echo "</td>";
        echo "<td>";
        if (isset($_POST["btnDetalles"]) && $hora == 1) {
            //var_dump($json_profesor);
            echo "<div id='detalles'>";
            echo "<p><strong>Nombre: </strong>" . $json_profesor["usuario"]["nombre"] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $json_profesor["usuario"]["usuario"] . "</p>";
            echo "<p><strong>Contraseña: </strong></p>";
            if ($json_profesor["usuario"]["email"] == "") {
                echo "<p><strong>Email: </strong>Email no disponible";
            } else {
                echo "<p><strong>Email: </strong>" . $json_profesor["usuario"]["email"] . "</p>";
            }
            echo "</div>";
        }
        echo "</td></tr>";
    }

    echo "</table>";

    ?>
</body>

</html>