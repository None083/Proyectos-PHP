<?php

session_start();

require "src/funciones_const.php";

try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die(error_page("Examen 2", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}
//a partir de aqui tengo conxion con mi bd





//consulta para listar usuarios
try {
    $consulta = "select * from usuarios";
    $datos_usuario = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    die(error_page("Práctica 8", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <p>
            Horario del profesor:
            <?php
            echo "<select name='select_usuarios' id='select_usuarios'>";
            while ($tupla = mysqli_fetch_assoc($datos_usuario)) {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            ?>
            <button type="submit" name="verHorario">Ver Horario</button>
        </p>
    </form>
    <?php
    if (isset($_POST["verHorario"])) {
        
    }
    ?>
</body>

</html>