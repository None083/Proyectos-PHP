<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 Arrays</title>
</head>

<body>
    <?php
    define("N_PARES", 10);//CONSTANTE: NOMBRE Y VALOR
    //const N_PARES = 30;

    for ($i = 0; $i < N_PARES; $i++) {
        $pares[] = $i * 2;
    }
    echo "<h1>Los ".N_PARES." primeros números pares</h1>";
    for ($i = 0; $i < N_PARES; $i++)
        echo "<p>" . $pares[$i] . "</p>";

    ?>
</body>
</html>