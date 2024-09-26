<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7 Arrays</title>
</head>

<body>
    <?php
    $array["MD"] = "Madrid";
    $array["BCN"] = "Barcelona";
    $array["LND"] = "Londres";
    $array["NY"] = "New York";
    $array["LA"] = "Los Ángeles";
    $array["CCG"] = "Chicago";
    foreach ($array as $iniciales => $ciudad) {
        echo "<p>El indice del array que contiene como valor ".$ciudad." es ".$iniciales."</p>";
    }
    ?>
</body>

</html>