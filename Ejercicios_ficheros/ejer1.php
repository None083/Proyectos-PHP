<?php


if (isset($_POST["crear"])) {
    
    $error_vacio = $_POST["crear"] == "";
    $error_es_numero = !is_numeric($_POST["crear"]);
    $error_num_valido = $_POST["crear"] < 1 || $_POST["crear"] > 10;

    $errores_form = $error_vacio || $error_es_numero || $error_num_valido;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejer1.php" method="post">
        <p>Crea una tabla de multiplicar:
            <input type="text" name="numero" id="numero">
        </p>
        <button type="submit" name="crear">Crear tabla</button>
    </form>
    <?php

    ?>
</body>

</html>