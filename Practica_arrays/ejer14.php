<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 14 Arrays</title>
    <style>
        table, td, th{
            border: 1px, solid, black;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <?php
    $estadios_futbol = array(
        "Barcelona" => "Camp Nou",
        "Real Madrid" => "Santiago Bernabeu",
        "Valencia" => "Mestalla",
        "Real Sociedad" => "Anoeta"
    );
    echo "<table>";
    echo "<tr><th>Índice</th><th>Valor</th></tr>";
    foreach ($estadios_futbol as $indice => $valor) {
        echo "<tr><td>".$indice."</td><td>".$valor."</td></tr>";
    }
    echo "</table>";
    unset($estadios_futbol["Real Madrid"]);//Borro el valor del indice "Real Madrid"
    echo "<ol>";
    foreach ($estadios_futbol as $indice => $valor) {
        echo "<li>".$indice.": ".$valor."</li>";
    }
    echo "</ol>";
    ?>
</body>

</html>