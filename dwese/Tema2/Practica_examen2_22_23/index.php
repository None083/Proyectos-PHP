<?php
require "src/funciones_ctes.php";
try {
    @$conexion = mysqli_connect($HOST_BD, $USUARIO_BD, $CLAVE_BD, $NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <p>
        Seleccione un alumno: 
        <select name="alumnos" id="alumnos">
            <?php
            //echo "<option value='".."'>".."</option>";
            ?>
        </select>
    </p>
</body>
</html>