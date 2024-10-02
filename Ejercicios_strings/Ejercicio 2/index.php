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
if (isset($_POST["comprobar"])) {
    #compruebo errores formulario
    $string = trim($_POST["string"]);
    $error_string = $string == "";
    $error_longitud_minima = strlen($string) < 3;
    $error_todo_num = !todo_num($string);
    $error_todo_letras = !todo_letras($string);
    $errores_form = $error_string || $error_longitud_minima || ($error_todo_num && $error_todo_letras);
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