<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 18 Arrays</title>
</head>

<body>
    <?php
    $deportes = array("fútbol", "baloncesto", "natación", "tenis");
    echo "<h1>Deportes</h1>";
    for ($i = 0; $i < count($deportes); $i++) {
        echo "<p>" . $deportes[$i] . "</p>";
    }
    echo "<p><strong>El número de deportes en el array es: </strong>" . count($deportes) . "</p>";
    echo "<p><strong>Primera posición: </strong>" . current($deportes) . "</p>";
    echo "<p><strong>Siguiente posición: </strong>" . next($deportes) . "</p>";
    echo "<p><strong>Última posición: </strong>" . end($deportes) . "</p>";
    echo "<p><strong>Previa posición: </strong>" . prev($deportes) . "</p>";
    ?>
</body>

</html>