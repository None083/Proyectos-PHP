<?php
require "src/funciones_ctes.php";
$url = DIR_SERV . "/usuarios";
$respuesta = consumir_servicios_REST($url, "GET");
$json_usuarios = json_decode($respuesta, true);
if (!$json_usuarios) {
    die(error_page("Examen Php", "<p>Error consumiendo el servicio rest: " . $url . "</p>"));
}
if (isset($json_usuarios["error"])) {
    die(error_page("Examen Php", "<p>" . $json_usuarios["error"] . "</p>"));
}

if (isset($_POST["profesor"])) {
    $url = DIR_SERV . "/horario/" . urlencode($_POST["profesor"]);
    $respuesta = consumir_servicios_REST($url, "GET");
    $json_horario = json_decode($respuesta, true);
    if (!$json_horario) {
        die(error_page("Examen Php", "<p>Error consumiendo el servicio rest: " . $url . "</p>"));
    }
    if (isset($json_horario["error"])) {
        die(error_page("Examen Php", "<p>" . $json_horario["error"] . "</p>"));
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

        .centrado {
            margin: 0 auto;
        }

        .enlace {
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
    <title>Examen PHP</title>
</head>

<body>
    <h1>Examen Php</h1>
    <form action="index.php" method="post">
        <p>Horario del profesor:
            <select name="profesor" id="profesor">
                <?php
                foreach ($json_usuarios as $usuario) {
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $usuario["id_usuario"]) {
                        echo "<option selected value='" . $usuario["id_usuario"] . "'>" . $usuario["nombre"] . "</option>";
                        $nombre_profesor = $tupla["nombre"];
                    } else {
                        echo "<option value='" . $usuario["id_usuario"] . "'>" . $usuario["nombre"] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Ver Horario</button>
        </p>
    </form>
    <?php
    const DIAS = array(1 => "Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
    const HORAS = array(1 => "8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");

    if (isset($_POST["profesor"])) {
        echo "<h2>Horario de " . $nombre_profesor . "</h2>";

        echo "<table class='centrado'>";
        echo "<tr>";
        echo "<th></th>";
        for ($i = 1; $i <= count(DIAS); $i++)
            echo "<th>" . DIAS[$i] . "</th>";
        echo "</tr>";

        for ($hora = 1; $hora <= count(HORAS); $hora++) {
            echo "<tr>";
            echo "<th>" . HORAS[$hora] . "</th>";
            if ($hora == 4) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 1; $dia <= count(DIAS); $dia++) {
                    echo "<td>";
                    foreach ($json_horario as $horario) {
                        if ($horario["dia"] == $dia && $horario["hora"] == $hora) {
                            echo $horario["nombre"] . "<br>";
                        }
                    }
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                    echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                    echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                    echo "<button class='enlace' name='btnEditar' type='submit'>Editar</button>";
                    echo "</form>";
                    echo "</td>";
                }
            }

            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>

</html>