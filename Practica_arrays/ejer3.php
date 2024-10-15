<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 Arrays</title>
</head>

<body>
    <?php
    $peliculas_vistas["Enero"] = 9;
    $peliculas_vistas["Febrero"] = 12;
    $peliculas_vistas["Marzo"] = 0;
    $peliculas_vistas["Abril"] = 17;
    echo "<h1>Películas vistas por mes</h1>";
    echo "<ul>";
    foreach ($peliculas_vistas as $mes => $num_peliculas) {
        if ($num_peliculas > 0) {
            echo "<li>" . $mes . ": " . $num_peliculas . " </li>";
        }
    }
    echo "</ul>";
    ?>
</body>

</html>