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
            <p>Introduzca una fecha:</p>
            <p>Día:
                <select name="dia1" id="dia1">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                        $dia1 = str_pad($i, 2, "0", STR_PAD_LEFT);
                        echo "<option value='$dia1'" . (isset($_POST["dia1"]) && $_POST["dia1"] == $dia1 ? " selected" : "") . ">$dia1</option>";
                    }
                    ?>
                </select>
                Mes:
                <select name="mes1" id="mes1">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $mes1 = str_pad($i, 2, "0", STR_PAD_LEFT);
                        echo "<option value='$mes1'" . (isset($_POST["mes1"]) && $_POST["mes1"] == $mes1 ? " selected" : "") . ">$mes1</option>";
                    }
                    ?>
                </select>
                Año:
                <select name="anio1" id="anio1">
                    <?php
                    $anio1Actual = date("Y"); // Año actual
                    for ($i = $anio1Actual; $i >= 1900; $i--) {
                        echo "<option value='$i'" . (isset($_POST["anio1"]) && $_POST["anio1"] == $i ? " selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>
                <?php
                if (isset($_POST["calcular"]) && $error_fecha_valida1) {
                    echo "<span class='error'> * La fecha no es válida * </span>";
                }
                ?>
            </p>
            <p>Introduzca otra fecha:</p>
            <p>Día:
                <select name="dia2" id="dia2">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                        $dia2 = str_pad($i, 2, "0", STR_PAD_LEFT);
                        echo "<option value='$dia2'" . (isset($_POST["dia2"]) && $_POST["dia2"] == $dia2 ? " selected" : "") . ">$dia2</option>";
                    }
                    ?>
                </select>
                Mes:
                <select name="mes2" id="mes2">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $mes2 = str_pad($i, 2, "0", STR_PAD_LEFT);
                        echo "<option value='$mes2'" . (isset($_POST["mes2"]) && $_POST["mes2"] == $mes2 ? " selected" : "") . ">$mes2</option>";
                    }
                    ?>
                </select>
                Año:
                <select name="anio2" id="anio2">
                    <?php
                    $anio2Actual = date("Y"); // Año actual
                    for ($i = $anio2Actual; $i >= 1900; $i--) {
                        echo "<option value='$i'" . (isset($_POST["anio2"]) && $_POST["anio2"] == $i ? " selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>
                <?php
                if (isset($_POST["calcular"]) && $error_fecha_valida2) {
                    echo "<span class='error'> * La fecha no es válida * </span>";
                }
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