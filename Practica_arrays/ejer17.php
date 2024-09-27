<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 17 Arrays</title>
</head>

<body>
    <?php
    $familias = [
        "Los Simpsons" => [
            "Padre" => "Homer",
            "Madre" => "Marge",
            "Hijos" => ["Bart", "Lisa", "Maggie"]
        ],
        "Los Griffin" => [
            "Padre" => "Peter",
            "Madre" => "Lois",
            "Hijos" => ["Chris", "Meg", "Stewie"]
        ]

    ];
    echo "<ul>";
    foreach ($familias as $familia => $roles) {
        echo "<li>" . $familia . "</li>";
        echo "<ul>";
        foreach ($roles as $rol => $nombres) {

            if (is_array($nombres)) {
                echo "<li>".$rol.":</li>";
                echo "<ul>";
                foreach ($nombres as $nombre => $value) {
                    echo "<li>Hijo" . $nombre+1 . ": " . $value . "</li>";
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