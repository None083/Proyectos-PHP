<?php
/*
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/usuario/" . $datos_usu_log["id_usuario"];
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_usuario = json_decode($respuesta, true);
if (!$json_usuario) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_usuario["error"])) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>" . $json_usuario["error"] . "</p>"));
}
if (isset($json_usuario["mensaje"])) {
    $error_usuario = true;
} else {
    $_SESSION["token"] = $json_usuario["token"];
    $_SESSION["ultm_accion"] = time();
    header("Location:index.php");
    exit;
}
*/
/*
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/usuariosGuardia/" . urlencode(1) . "/" . urlencode(1);
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_usuarios_guardia = json_decode($respuesta, true);
if (!$json_usuarios_guardia) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_usuarios_guardia["error"])) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>" . $json_usuarios_guardia["error"] . "</p>"));
}
if (isset($json_usuarios_guardia["mensaje"])) {
    $error_usuario = true;
} else {
    $_SESSION["token"] = $json_usuarios_guardia["token"];
    $_SESSION["ultm_accion"] = time();
    header("Location:index.php");
    exit;
}
*/

$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/deGuardia/" . urlencode($datos_usu_log["id_usuario"]);
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_dias_horas_guardia = json_decode($respuesta, true);

if (!$json_dias_horas_guardia) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_dias_horas_guardia["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_dias_horas_guardia["error"])) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>" . $json_dias_horas_guardia["error"] . "</p>"));
}

if (isset($json_dias_horas_guardia["mensaje_baneo"])) {
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
    <title>Gestión de Guardias</title>
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
    </style>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Equipos de Guardia del IES Mar de Alborán</h2>
    <?php
    $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
    $horas = ["1º Hora", "2º Hora", "3º Hora", "", "4º Hora", "5º Hora", "6º Hora"];
    echo $datos_usu_log["id_usuario"];
    //var_dump($json_usuario);
    //var_dump($json_usuarios_guardia);
    var_dump($json_dias_horas_guardia);

    echo "<table>";
    echo "<tr>";
    echo "<th></th>";
    for ($i = 0; $i < count($dias); $i++)
        echo "<th>" . $dias[$i] . "</th>";
    echo "</tr>";

    for ($hora = 0; $hora < count($horas); $hora++) {
        echo "<tr>";
        echo "<th>" . $horas[$hora] . "</th>";
        if ($hora == 3) {
            echo "<td colspan='5'>RECREO</td>";
        } else {
            for ($dia = 1; $dia <= count($dias); $dia++) {
                if ($hora < 3) {
                    echo "<td>";
                    echo "<button type='submit'>Equipo " . ($hora * 5) + $dia . "</button>";
                    echo "</td>";
                }else{
                    echo "<td>";
                    echo "<button type='submit'>Equipo " . ($hora * 5) + $dia - 5 . "</button>";
                    echo "</td>";
                }
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>

</html>