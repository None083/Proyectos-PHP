<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 15 Arrays</title>
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
    $array = array(
        "0" => "3",
        "1" => "2",
        "2" => "8",
        "3" => "123",
        "4" => "5",
        "5" => "1"
    );
    asort($array);
    echo "<table>";
    echo "<tr><th>Índice</th><th>Valor</th></tr>";
    foreach ($array as $indice => $valor) {
        echo "<tr><td>".$indice."</td><td>".$valor."</td></tr>";
    }
    echo "</table>";
    ?>
</body>

</html>