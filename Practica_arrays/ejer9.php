<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 9 Arrays</title>
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
    $lenguajes_cliente["Hola"] = "Inglés";
    $lenguajes_cliente[3] = "Francés";
    $lenguajes_cliente["18"] = "CSS";
    $lenguajes_cliente[0] = "HTML";

    $lenguajes_servidor[3] = "Español";
    $lenguajes_servidor[9] = "JAVA";
    $lenguajes_servidor["Dormir"] = "PHP";
    $lenguajes_servidor[18] = "JS";

    $lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);
    echo "<table>";
    echo "<tr><th>Índice</th><th>Valor</th></tr>";
    foreach ($lenguajes as $indice => $valor) {
        echo "<tr><td>".$indice."</td><td>".$valor."</td></tr>";
    }
    echo "</table>";
    ?>
</body>

</html>