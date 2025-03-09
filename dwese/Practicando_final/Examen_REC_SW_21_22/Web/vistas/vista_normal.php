<?php
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/horarioProfesor/" . urlencode($datos_usuario_log["id_usuario"]);
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h1>Examen5 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
    echo "<h2>Horario del Profesor: " . $datos_usuario_log["nombre"] . " </h2>";
    $horario = $json_horario["horario"];
    //var_dump($horario);
    //$dias = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];
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
    ?>
</body>

</html>