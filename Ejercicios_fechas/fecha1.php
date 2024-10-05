<?php
function esFormatoValido($fecha)
{
    // Expresión regular para validar el formato DD/MM/YYYY
    $regex = "/^\d{2}\/\d{2}\/\d{4}$/";

    if (preg_match($regex, $fecha)) {
        return true;
    } else {
        return false;
    }
}

function esFechaValida($fecha)
{
    // Comprobar si la fecha está en el formato correcto antes de continuar
    if (!esFormatoValido($fecha)) {
        return false;
    }

    $arrayFecha = explode("/", $fecha);
    if (count($arrayFecha) !== 3) { // Comprobar que hay 3 elementos (día, mes, año)
        return false;
    }

    $dia = (int)$arrayFecha[0];
    $mes = (int)$arrayFecha[1];
    $anio = (int)$arrayFecha[2];

    // Verificar si la fecha es válida
    return checkdate($mes, $dia, $anio);
}

if (isset($_POST["calcular"])) {
    #compruebo errores formulario
    $error_primera = $_POST["primera"] == "";
    $error_segunda = $_POST["segunda"] == "";
    $error_formato_valido1 = !esFormatoValido($_POST["primera"]);
    $error_formato_valido2 = !esFormatoValido($_POST["segunda"]);
    $error_fecha_valida1 = !esFechaValida($_POST["primera"]);
    $error_fecha_valida2 = !esFechaValida($_POST["segunda"]);
    $errores_form = $error_primera || $error_segunda || $error_fecha_valida1 || $error_fecha_valida2 || $error_formato_valido1 || $error_formato_valido2;
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
    <title>Fecha 1</title>
</head>

<body>
    <div id="contenedor-form">
        <h1>Fechas - Formulario</h1>
        <form action="fecha1.php" method="post">
            <p>Introduzca una fecha: (DD/MM/YYYY) <input type="text" name="primera" id="primera" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
                <?php
                if (isset($_POST["calcular"]) && $error_primera) {
                    echo "<span class='error'> * Campo obligatorio * </span>";
                } else if (isset($_POST["calcular"]) && $error_formato_valido1) {
                    echo "<span class='error'> * El formato no es valido, debe ser (DD/MM/YYYY) * </span>";
                } else if (isset($_POST["calcular"]) && $error_fecha_valida1) {
                    echo "<span class='error'> * La fecha no es válida * </span>";
                }
                ?>
            </p>
            <p>Introduzca una fecha: (DD/MM/YYYY) <input type="text" name="segunda" id="segunda" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"]; ?>">
                <?php
                if (isset($_POST["calcular"]) && $error_segunda) {
                    echo "<span class='error'> * Campo obligatorio * </span>";
                } else if (isset($_POST["calcular"]) && $error_formato_valido2) {
                    echo "<span class='error'> * El formato no es valido, debe ser (DD/MM/YYYY) * </span>";
                } else if (isset($_POST["calcular"]) && $error_fecha_valida2) {
                    echo "<span class='error'> * La fecha no es válida * </span>";
                }
                ?>
            </p>
            <button type="submit" name="calcular">Calcular</button>
        </form>
    </div>
    <?php
    if (isset($_POST["calcular"]) && !$errores_form) {

        $arrayFecha1 = explode("/", $_POST["primera"]);
        $segFecha1 = mktime(0, 0, 0, $arrayFecha1[1], $arrayFecha1[0], $arrayFecha1[2]);

        $arrayFecha2 = explode("/", $_POST["segunda"]);
        $segFecha2 = mktime(0, 0, 0, $arrayFecha2[1], $arrayFecha2[0], $arrayFecha2[2]);

        $diferenciaFechasSeg = abs($segFecha1 - $segFecha2);

        //86400 es la cantidad de segundos en un día
        $diferenciaFechasDias = $diferenciaFechasSeg / 86400;

        echo "<div id='contenedor-resp'>";
        echo "<h1>Fechas - Resultado</h1>";
        echo "<p>La diferencia en días entre las dos fechas es de: " . $diferenciaFechasDias . "</p>";
        echo "</div>";
    }
    ?>
</body>

</html>