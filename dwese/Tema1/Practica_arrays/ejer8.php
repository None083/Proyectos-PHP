<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 8 Arrays</title>
</head>

<body>
    <?php
    $array_nombres = array("Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa");
    echo "<p>El array contiene ".count($array_nombres)." elementos:</p>";
    echo "<ul>";
    for ($i=0; $i < count($array_nombres); $i++) { 
        echo "<li>".$array_nombres[$i]."</li>";
    }
    echo "</ul>";
    ?>
</body>

</html>