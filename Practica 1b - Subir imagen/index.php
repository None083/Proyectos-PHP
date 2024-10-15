<?php
if (isset($_POST["borrar"])) {
    header("Location:index.php");
    exit;
}

function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_valido($dni)
{
    $valido = true;

    if (strlen($dni) != 9) {
        $valido = false;
    } else {
        if (!ctype_alpha($dni[strlen($dni) - 1])) {
            $valido = false;
        } else {
            $numero_dni = substr($dni, 0, -1);
            $letra_dni = strtoupper(substr($dni, -1));
            
            if (!is_numeric($numero_dni)) {
                return false;
            }

            $letra_valida_dni = LetraNIF((int)$numero_dni);

            if ($letra_dni != $letra_valida_dni) {
                return false;
            }
        }
    }
    return $valido;
}

if (isset($_POST["enviar"])) {
    #compruebo errores formulario
    $error_nombre = $_POST["nombre"] == "";
    $error_apellido = $_POST["apellidos"] == "";
    $error_clave = $_POST["pass"] == "";
    $error_dni = !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_comentarios = $_POST["coment"] == "";
    $errores_form = $error_nombre || $error_apellido || $error_clave || $error_dni || $error_sexo || $error_comentarios;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red
        }
    </style>
    <title>Práctica 1</title>
</head>

<body>
    <?php
    if (isset($_POST["enviar"]) && !$errores_form) {
        require "vistas/vistaphp.php";
    } else {
        require "vistas/vistaform.php";
    }
    ?>
</body>

</html>