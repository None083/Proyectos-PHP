<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 10 Arrays</title>
</head>

<body>
    <?php
    $array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    $resultado = 0;
    $contador = 0;
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] % 2 == 0) {
            $resultado += $array[$i];
            echo $array[$i]. ", ";
            $contador++;
        }
    }
    $resultado /= $contador;
    echo "La media de los números anteriores es: " . $resultado;
    ?>
</body>

</html>