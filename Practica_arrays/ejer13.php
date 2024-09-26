<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 13 Arrays</title>
</head>

<body>
    <?php
    $animales = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
    $numeros = array("12", "34", "45", "52", "12");
    $cosas = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");
    $todo = array_merge($animales, $numeros, $cosas);
    print_r(array_reverse($todo));
    ?>
</body>
</html>