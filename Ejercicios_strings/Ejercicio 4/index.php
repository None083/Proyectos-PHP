<?php
const VALORES = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);

function letras_correctas($texto)
{
    $correcto = true;
    for ($i = 0; $i < strlen($texto); $i++) {
        if (!isset(VALORES[$texto[$i]])) {
            $correcto = false;
            break;
        }
    }
    return $correcto;
}

function orden_bueno($texto){
    $bueno = true;
    for ($i=0; $i < strlen($texto)-1; $i++) { 
        if (VALORES[$texto[$i]] < VALORES[$texto[$i+1]]) {
            $bueno = false;
            break;
        }
    }
    return $bueno;
}

function repite_bien($texto){
    $contador["M"] = 4;
    $contador["D"] = 1;
    $contador["C"] = 4;
    $contador["L"] = 1;
    $contador["X"] = 4;
    $contador["V"] = 1;
    $contador["I"] = 4;

    $bueno = true;

    for ($i=0; $i < strlen($texto); $i++) { 
        $contador[$texto[$i]]--;
        if ($contador[$texto[$i]] < 0) {
            $bueno = false;
        }
    }
    return $bueno;
}

function bien_escrito_romano($texto){
    return letras_correctas($texto) && orden_bueno($texto) && repite_bien($texto);
}

if (isset($_POST["convertir"])) {
    #compruebo errores formulario
    $numero_romano = trim($_POST["string"]);
    $string_sin_espacios = str_replace(" ", "", $numero_romano);
    $error_string = $string_sin_espacios == "";
    $error_longitud_minima = strlen($string_sin_espacios) < 3;
    $error_escrito_mal = !bien_escrito_romano($string_sin_espacios);
    $errores_form = $error_string || $error_longitud_minima || $error_escrito_mal;
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
            background-color: lightgrey;
            border: 2px solid black;
            margin-top: 0.5rem;
        }
    </style>
    <title>Ejercicio 4</title>
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