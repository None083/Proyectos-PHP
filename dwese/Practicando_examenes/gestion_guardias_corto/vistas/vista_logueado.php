<?php
$dias_semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
$dia_actual = $dias_semana[date('w')];

$horas_lectivas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];

//obtener json con los datos de un usuario especifico a partir de su id utilizando el servicio rest
if (isset($_POST["btnDetalles"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/usuario/" . urlencode($_POST["btnDetalles"]);
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_detalles_profesor = json_decode($respuesta, true);
    if (!$json_detalles_profesor) {
        session_destroy();
        die(error_page("Gestión de Guardias", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_detalles_profesor["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_detalles_profesor["error"])) {
        session_destroy();
        die(error_page("Gestión de Guardias", "<p>" . $json_detalles_profesor["error"] . "</p>"));
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }
    </style>
    <title>Gestión de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> - <button type="submit" name="btnCerrarSession">Salir</button></p>
    </form>
    <h2>Hoy es <?php echo $dia_actual; ?></h2>
    <table>
        <tr>
            <th>Hora</th>
            <th>Profesor de guardia</th>
            <th>Información del profesor con id:</th>
        </tr>
        <tr>
            <?php
            //mostrar un tr por cada hora lectiva con una lista ordenada de profesores que estan a esa hora ese dia
            for ($i = 0; $i < count($horas_lectivas); $i++) {
                $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
                $url = DIR_SERV . "/usuariosGuardia/" . urlencode(date('w')) . "/" . urlencode($i + 1);
                $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
                $json_profesores = json_decode($respuesta, true);
                if (!$json_profesores) {
                    session_destroy();
                    die(error_page("Gestión de Guardias", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));
                }

                if (isset($json_profesores["no_auth"])) {
                    session_unset();
                    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
                    header("Location:index.php");
                    exit;
                }

                if (isset($json_profesores["error"])) {
                    session_destroy();
                    die(error_page("Gestión de Guardias", "<p>" . $json_profesores["error"] . "</p>"));
                }

                if (isset($json_profesores["mensaje_baneo"])) {
                    session_unset();
                    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
                    header("Location:index.php");
                    exit;
                }

                echo "<tr><td>" . $horas_lectivas[$i] . "</td>";
                echo "<td><ol>";
                foreach ($json_profesores["usuarios"] as $profesor) {
                    echo "<li><form action='index.php' method='post'><button type='submit' name='btnDetalles' value='" . $profesor["id_usuario"] . "'>" . $profesor["nombre"] . "</button><input type='hidden' name='hora' value='" . $i . "'/></form></li>";
                    
                }
                echo "</td></ol>";
                echo "<td>";
                if (isset($_POST["btnDetalles"]) && $json_detalles_profesor["usuario"]["id_usuario"] == $_POST["btnDetalles"] && isset($_POST["hora"]) && $_POST["hora"] == $i) {
                    echo "<p>Nombre: " . $json_detalles_profesor["usuario"]["nombre"] . "</p>";
                    echo "<p>Apellidos: " . $json_detalles_profesor["usuario"]["usuario"] . "</p>";
                    echo "<p>Contraseña: </p>";
                    echo "<p>Email: " . $json_detalles_profesor["usuario"]["email"] . "</p>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tr>
    </table>
</body>

</html>