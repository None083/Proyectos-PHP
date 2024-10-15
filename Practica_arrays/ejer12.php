<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 12 Arrays</title>
</head>

<body>
    <?php
    $animales = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
    $numeros = array("12", "34", "45", "52", "12");
    $cosas = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");
    $todo = array();

    array_push($todo, ...$animales);
    array_push($todo, ...$numeros);
    array_push($todo, ...$cosas);

    print_r($todo);
    ?>
</body>

</html>