<?php
function todo_letras($texto)
{
    $todo_l = true;
    for ($i = 0; $i < strlen($texto); $i++) {
        if (ord($texto[$i]) < ord("A") || ord($texto[$i]) > ord("z")) {
            $todo_l = false;
            break;
        }
    }
    return $todo_l;
}
if (isset($_POST["comparar"])) {
    #compruebo errores formulario
    $primera = trim($_POST["primera"]);
    $segunda = trim($_POST["segunda"]);
    $error_primera = $primera == "";
    $error_segunda = $segunda == "";
    $error_longitud_minima_primera = strlen($primera) < 3;
    $error_longitud_minima_segunda = strlen($segunda) < 3;
    $error_todo_letras_primera = !todo_letras($primera);
    $error_todo_letras_segunda = !todo_letras($segunda);
    $errores_form = $error_primera || $error_segunda
        || $error_longitud_minima_primera || $error_longitud_minima_segunda
        || $error_todo_letras_primera || $error_todo_letras_segunda;
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
    <title>Ejercicio 1</title>
</head>

<body>
    <?php
    if (isset($_POST["comparar"]) && !$errores_form) {
        require "vistas/vista_form.php";
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_form.php";
    }
    ?>
</body>

</html>