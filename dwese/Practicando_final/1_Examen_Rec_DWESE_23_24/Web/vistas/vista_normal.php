<?php
function mostrar_profesores_guardia($dia, $hora)
{
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/usuariosGuardia/" . $dia . "/" . $hora;
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores_guardia = json_decode($respuesta, true);
    if (!$json_profesores_guardia) {
        session_destroy();
        die(error_page("Examen PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores_guardia["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores_guardia["error"])) {
        session_destroy();
        die(error_page("Examen PHP", "<p>" . $json_profesores_guardia["error"] . "</p>"));
    }

    if (isset($json_profesores_guardia["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    return $json_profesores_guardia;
}

if (isset($_POST["btnDetalles"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/usuario/" . $_POST["btnDetalles"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_detalles_profesor = json_decode($respuesta, true);
    if (!$json_detalles_profesor) {
        session_destroy();
        die(error_page("Examen PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_detalles_profesor["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_detalles_profesor["error"])) {
        session_destroy();
        die(error_page("Examen PHP", "<p>" . $json_detalles_profesor["error"] . "</p>"));
    }

    if (isset($json_detalles_profesor["mensaje_baneo"])) {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen PHP</title>
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
</head>

<body>
    <h1>Examen PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
    $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
    $horas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
    //echo "<h2>Hoy es ".$dias[date("N")-1]."</h2>";
    echo "<h2>Hoy es " . $dias[0] . "</h2>";
    //var_dump(mostrar_profesores_guardia(1, 1)["usuarios_guardia"]);
    echo "<table>";
    echo "<tr><th>Hora</th><th>Profesor de Guardia</th><th>Información del Profesor con Id: </th></tr>";
    for ($hora = 1; $hora <= 6; $hora++) {
        echo "<tr>";
        echo "<td>" . $horas[$hora - 1] . "</td>";
        echo "<td>";
        foreach (mostrar_profesores_guardia(1, $hora)["usuarios_guardia"] as $tupla) {
            echo "<form method='post'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalles' class='enlace'>" . $tupla["nombre"] . "</button></form><br>";
        }
        echo "</td>";
        if (isset($_POST["btnDetalles"])) {
            echo "<td>";
            echo "<p>";
            echo "<strong>Nombre: </strong>" . $json_detalles_profesor["usuario"]["nombre"] . "<br>";
            echo "<strong>Usuario: </strong>" . $json_detalles_profesor["usuario"]["usuario"] . "<br>";
            echo "<strong>Contrseña: </strong><br>";
            if ($json_detalles_profesor["usuario"]["email"] == "") {
                echo "<strong>Email: </strong> Email no disponible";
            } else {
                echo "<strong>Email: </strong>" . $json_detalles_profesor["usuario"]["email"];
            }

            echo "</p>";
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>