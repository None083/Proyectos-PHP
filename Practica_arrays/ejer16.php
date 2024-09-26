<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 16 Arrays</title>
</head>

<body>
    <?php
    $array = array(
        "5" => "1",
        "12" => "2",
        "13" => "56",
        "x" => "42"
    );
    print_r($array);
    echo "<p>Número de elementos del array anterior: " . count($array) . "</p>";
    unset($array[5]);
    print_r($array);
    echo "<p>Número de elementos del array después de borrar un elemento: " . count($array) . "</p>";
    unset($array);
    ?>
</body>

</html>