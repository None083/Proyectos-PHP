<?php
if (isset($_POST["borrar"])) {
    header("Location:index.php");
    exit;
}

if (isset($_POST["enviar"])) {
    #compruebo errores formulario
    $error_nombre = $_POST["nombre"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $errores_form = $error_nombre || $error_sexo;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi primera página PHP</title>
</head>

<body>
    <?php
    if (isset($_POST["enviar"]) && !$errores_form) {
        require "vistas/vista_recogida.php";
    } else {
        require "vistas/vista_form.php";
    }
    ?>
</body>

</html>