<?php
if (isset($_POST["calcular"])) {
    #compruebo errores formulario
    $error_primera = $_POST["primera"] == "";
    $error_segunda = $_POST["segunda"] == "";
    $errores_form = $error_primera || $error_segunda;
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
    <title>Fecha 3</title>
</head>

<body>
    <div id="contenedor-form">
        <h1>Fechas - Formulario</h1>
        <form action="fecha3.php" method="post">
            <p>Introduzca una fecha: <input type="date" name="primera" id="primera" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
                <?php
                if (isset($_POST["calcular"]) && $error_primera) {
                    echo "<span class='error'> * Campo obligatorio * </span>";
                }
                ?>
            </p>
            <p>Introduzca una fecha: <input type="date" name="segunda" id="segunda" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"]; ?>">
                <?php
                if (isset($_POST["calcular"]) && $error_segunda) {
                    echo "<span class='error'> * Campo obligatorio * </span>";
                }
                ?>
            </p>
            <button type="submit" name="calcular">Calcular</button>
        </form>
    </div>
    <?php
    if (isset($_POST["calcular"]) && !$errores_form) {

        $arrayFecha1 = explode("-", $_POST["primera"]);
        $segFecha1 = mktime(0, 0, 0, $arrayFecha1[1], $arrayFecha1[2], $arrayFecha1[0]);

        $arrayFecha2 = explode("-", $_POST["segunda"]);
        $segFecha2 = mktime(0, 0, 0, $arrayFecha2[1], $arrayFecha2[2], $arrayFecha2[0]);

        $diferenciaFechasSeg = abs($segFecha1 - $segFecha2);

        //86400 es la cantidad de segundos en un día
        $diferenciaFechasDias = $diferenciaFechasSeg / 86400; 

        echo "<div id='contenedor-resp'>";
        echo "<h1>Fechas - Resultado</h1>";
        echo "<p>La diferencia en días entre las dos fechas es de: ".$diferenciaFechasDias."</p>";
        echo "</div>";
    }
    ?>
</body>

</html>