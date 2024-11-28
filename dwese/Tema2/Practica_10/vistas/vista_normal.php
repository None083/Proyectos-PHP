<?php
try {
    $consulta = "
    select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as nom_grupo
        from horario_lectivo
        join grupos on horario_lectivo.grupo = grupos.id_grupo
        where usuario = " . $datos_usuario_log["id_usuario"] . "
    ";
    $result_grupos_profesor = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Práctica 10", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 90%;
            margin: 0 auto;
        }
        .centrado {
            text-align: center
        }
        .enLinea {
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
    <title>Práctica 10</title>
</head>

<body>
    <h1>Práctica 10</h1>
    <div>
        Bienvenido - <strong><?php echo $datos_usuario_log["usuario"]; ?></strong>
        <form action="index.php" class="enlinea" method="post">
            <button type="submit" class="enlace" name="btnCerrarSesion">Cerrar sesión</button>
        </form>
        <?php
        echo "<h2 class='centrado'>Tu horario:</h2>";
        $horas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($hora = 0; $hora < count($horas); $hora++) {
            echo "<tr><th>" . $horas[$hora] . "</th>";
            if ($hora == 3) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 0; $dia < 5; $dia++) {
                    $grupos = "";
                    echo "<td>";
                    foreach ($result_grupos_profesor as $value) {
                        if ($value["dia"] == $dia + 1 && $value["hora"] == $hora + 1) {
                            if ($grupos == "") {
                                $grupos = $value["nom_grupo"];
                            } else {
                                $grupos .= " / " . $value["nom_grupo"];
                            }
                        }
                    }
                    echo $grupos;
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
</body>

</html>