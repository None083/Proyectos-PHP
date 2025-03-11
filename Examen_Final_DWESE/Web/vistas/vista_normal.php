<?php
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/obtenerHorario/" . urlencode($datos_usu_log["id_usuario"]);
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_horario = json_decode($respuesta, true);
if (!$json_horario) {
    session_destroy();
    die(error_page("Examen Final PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_horario["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_horario["error"])) {
    session_destroy();
    die(error_page("Examen Final PHP", "<p>" . $json_horario["error"] . "</p>"));
}

if (isset($json_horario["mensaje_baneo"])) {
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
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Su Horario</h2>
    <?php
    if (isset($_SESSION["mensaje"])) {
        echo "<p>" . $_SESSION["mensaje"] . "</p>";
        unset($_SESSION["mensaje"]);
    }
    echo "<h3>Horario del Profesor: " . $datos_usu_log["nombre"] . "</h3>";
    //var_dump($json_horario);
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

    echo "<table class='centrado'>";
    echo "<tr>";
    echo "<th></th>";
    for ($i = 1; $i <= count($dias); $i++)
        echo "<th>" . $dias[$i] . "</th>";
    echo "</tr>";

    for ($hora = 1; $hora <= count($horas); $hora++) {
        echo "<tr>";
        echo "<th>" . $horas[$hora] . "</th>";
        if ($hora == 4) {
            echo "<td colspan='5'>RECREO</td>";
        } else {
            for ($dia = 1; $dia <= count($dias); $dia++) {
                echo "<td>";
                foreach ($json_horario["horario"] as $tupla) {
                    if ($tupla["dia"] == $dia && $tupla["hora"] == $hora) {
                        echo $tupla["nombre"] . "<br>";
                        //no consigo que aparezca / en todos los grupos menos el ultimo, asi que le puse <br>
                    }
                }
                echo "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";

    ?>

</body>

</html>