<?php
function todo_letras($texto)
{
    // Verifica que el texto solo contenga letras, incluyendo las tildes en español y espacios
    return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u', $texto);
}


if (isset($_POST["convertir"])) {
    #compruebo errores formulario
    $texto = trim($_POST["string"]);
    $error_string = $texto == "";
    $error_longitud_minima = strlen($texto) < 3;
    $error_todo_letras = !todo_letras($texto);
    $errores_form = $error_string || $error_longitud_minima || $error_todo_letras;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

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

        textarea{
            margin-left: 1rem;
        }

        #contenedor-resp {
            background-color: lightgreen;
            border: 2px solid black;
            margin-top: 0.5rem;
            padding-bottom: 1rem;
            padding-left: 1rem;
        }
    </style>
    <title>Ejercicio 6</title>
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