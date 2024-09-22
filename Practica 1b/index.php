<?php
    if (isset($_POST["enviar"])) {
        #compruebo errores formulario
        $error_nombre=$_POST["nombre"]=="";
        $error_apellido=$_POST["apellidos"]=="";
        $error_clave=$_POST["pass"]=="";
        $error_dni=$_POST["dni"]=="";
        $error_sexo=!isset($_POST["sexo"]);
        $error_comentarios=$_POST["coment"]=="";
        $errores_form=$error_nombre||$error_apellido||$error_clave||$error_dni||$error_sexo||$error_comentarios;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error{color:red}
    </style>
    <title>Práctica 1</title>
</head>
<body>
    <?php
        if (isset($_POST["enviar"])&& !$errores_form) {
            require "vistas/vistaphp.php";
            
        }else{
            require "vistas/vistaform.php";
        }
    ?>
</body>
</html>