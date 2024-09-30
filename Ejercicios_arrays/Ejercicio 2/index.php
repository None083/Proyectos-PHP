<?php
if (isset($_POST["comprobar"])) {
    #compruebo errores formulario
    $string = trim($_POST["string"]);
    $error_string = $string == "";
    $error_longitud_minima = strlen($string) < 3;
    $errores_form = $error_string || $error_longitud_minima;
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
            background-color: lightgrey;
            border: 2px solid black;
            margin-top: 0.5rem;
        }
    </style>
    <title>Ejercicio 2</title>
</head>

<body>
    <?php
    if (isset($_POST["comprobar"]) && !$errores_form) {
        require "vistas/vista_form.php";
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_form.php";
    }
    ?>
</body>

</html>