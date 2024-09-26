<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 Arrays</title>
</head>

<body>
    <?php
    $array[] = "Madrid";
    $array[] = "Barcelona";
    $array[] = "Londres";
    $array[] = "New York";
    $array[] = "Los Ángeles";
    $array[] = "Chicago";
    for ($i=0; $i < count($array); $i++) { 
        echo "<p>La ciudad con el indice ".$i." tiene el nombre ".$array[$i]."</p>";
    }
    ?>
</body>

</html>