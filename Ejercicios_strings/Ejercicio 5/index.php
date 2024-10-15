<?php
function todo_num($texto)
{
    $todo_n = true;
    for ($i = 0; $i < strlen($texto); $i++) {
        if (!is_numeric($texto[$i])) {
            $todo_n = false;
            break;
        }
    }
    return $todo_n;
}

if (isset($_POST["convertir"])) {
    #compruebo errores formulario
    $numero_arabe = trim($_POST["string"]);
    $string_sin_espacios = str_replace(" ", "", $numero_arabe);
    $error_string = $string_sin_espacios == "";
    $error_longitud_minima = strlen($string_sin_espacios) < 3;
    $error_todo_num = !todo_num($string_sin_espacios);
    $error_mayor_4999 = $string_sin_espacios > 4999;
    $errores_form = $error_string || $error_longitud_minima || $error_todo_num || $error_mayor_4999;
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
            margin: 1rem;
        }

        #contenedor-resp {
            background-color: lightgreen;
            border: 2px solid black;
            margin-top: 0.5rem;
        }
    </style>
    <title>Ejercicio 5</title>
</head>

<body>
    <?php
    if (isset($_POST["convertir"]) && !$errores_form) {
        require "vistas/vista_form.php";
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_form.php";
    }
    ?>
</body>

</html>