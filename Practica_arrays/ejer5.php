<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 Arrays</title>
</head>

<body>
    <?php
    $datos["Nombre"] = "Pedro Torres";
    $datos["Direccion"] = "C/Mayor, 37";
    $datos["Telefono"] = "123456789";
    echo "<ul>";
    foreach ($datos as $campo => $valor) {
        echo "<li>" . $campo . ": " . $valor . "</li>";
    }
    echo "</ul>";
    ?>
</body>

</html>