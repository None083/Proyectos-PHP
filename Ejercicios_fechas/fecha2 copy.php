<?php
if (isset($_POST["calcular"])) {
    #compruebo errores formulario
    $dia1 = $_POST["dia1"];
    $mes1 = $_POST["mes1"];
    $anio1 = $_POST["anio1"];
    $error_fecha_valida1 = !checkdate($mes1, $dia1, $anio1);

    $dia2 = $_POST["dia2"];
    $mes2 = $_POST["mes2"];
    $anio2 = $_POST["anio2"];
    $error_fecha_valida2 = !checkdate($mes2, $dia2, $anio2);

    $errores_form = $error_fecha_valida1 || $error_fecha_valida2;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: lightgrey;
        }

        .error {
            color: red
        }

        #contenedor-form {
            background-color: lightblue;
            border: 2px solid black;
        }

        h1 {
            text-align: center;
            padding: 1rem;
        }

        p,
        button {
            margin-left: 1rem;
            margin-bottom: 1rem;
        }

        #contenedor-resp {
            background-color: lightgreen;
            border: 2px solid black;
            margin-top: 0.5rem;
        }
    </style>
    <title>Fecha 2</title>
</head>

<body>
    <div id="contenedor-form">
        <h1>Fechas - Formulario</h1>
        <form action="fecha2.php" method="post">
            <p><label for="texto1">Introduzca una fecha</label></p>
            <p>
                <?php
                //añadir array_meses

                $anyo_actual = date("Y");
                const N_ANYOS = 50;


                echo "<label for='dia1'>Día:</label>";
                echo "<select name='dia1' id='dia1'>Día:";
                for ($i = 1; $i < 31; $i++) {
                    echo "<option value=" . $i . ">" . sprintf("%02d", $i) . "</option>";
                }
                echo "</select>";

                echo "<label for='mes1'>Día:</label>";
                echo "<select name='mes1' id='mes1'>Mes:";
                for ($i = 1; $i < 12; $i++) {
                    echo "<option value=" . $i . ">" . $array_mes[$i] . "</option>";
                }
                echo "</select>";

                echo "<label for='anyo1'>Día:</label>";
                echo "<select name='anyo1' id='anyo1'>Año:";
                for ($i = $anyo_actual - floor(N_ANYOS / 2); $i <=  $anyo_actual + floor(N_ANYOS / 2); $i++) {
                    echo "<option value=" . $i . ">" . $i . "</option>";
                }
                echo "</select>";

                ?>
            </p>
            <button type="submit" name="calcular">Calcular</button>
        </form>
    </div>

    </div>
    <?php
    if (isset($_POST["calcular"]) && !$errores_form) {

        $dia1 = $_POST["dia1"];
        $mes1 = $_POST["mes1"];
        $anio1 = $_POST["anio1"];
        $segFecha1 = mktime(0, 0, 0, $mes1, $dia1, $anio1);

        $dia2 = $_POST["dia2"];
        $mes2 = $_POST["mes2"];
        $anio2 = $_POST["anio2"];
        $segFecha2 = mktime(0, 0, 0, $mes2, $dia2, $anio2);

        $diferenciaFechasSeg = abs($segFecha1 - $segFecha2);

        //86400 es la cantidad de segundos en un día
        $diferenciaFechasDia1s = $diferenciaFechasSeg / 86400;

        echo "<div id='contenedor-resp'>";
        echo "<h1>Fechas - Resultado</h1>";
        echo "<p>La diferencia en días entre las dos fechas es de: " . $diferenciaFechasDia1s . "</p>";
        echo "</div>";
    }
    ?>
</body>

</html>