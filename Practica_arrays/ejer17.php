<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 17 Arrays</title>
</head>

<body>
    <?php
    $familias = array(
        "Los Simpsons" => array(
            "Padre" => "Homer",
            "Madre" => "Marge",
            "Hijos" => array("Bart", "Lisa", "Maggie")
        ),
        "Los Griffin" => array(
            "Padre" => "Peter",
            "Madre" => "Lois",
            "Hijos" => array("Chris", "Meg", "Stewie")
        )
    );
    echo "<ul>";
    foreach ($familias as $familia => $roles) {
        echo "<li>" . $familia . "</li>";
        echo "<ul>";
        foreach ($roles as $rol => $nombres) {
            if (is_array($nombres)) {
                $contador = 0;
                echo "<ul>";
                foreach ($nombres as $nombre) {
                    $contador++;
                    echo "<li>Hijo" . $contador . ": " . $nombre . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<li>" . $rol . ": " . $nombres . "</li>";
            }
        }
        echo "</ul>";
    }
    echo "</ul>";
    ?>
</body>

</html>