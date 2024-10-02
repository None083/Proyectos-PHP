<?php
echo "<div id='contenedor-resp'>";

$numero_arabe = str_replace(" ", "", $_POST["string"]);

function convertirARomano($num) {
    $resultado = "";

    while ($num >= 1000) {
        $resultado .= "M";
        $num -= 1000;
    }

    if ($num >= 500) {
        $resultado .= "D";
        $num -= 500;
    }

    while ($num >= 100) {
        $resultado .= "C";
        $num -= 100;
    }

    if ($num >= 50) {
        $resultado .= "L";
        $num -= 50;
    }

    while ($num >= 10) {
        $resultado .= "X";
        $num -= 10;
    }

    if ($num >= 5) {
        $resultado .= "V";
        $num -= 5;
    }

    while ($num >= 1) {
        $resultado .= "I";
        $num -= 1;
    }

    return $resultado;
}

$numero_romano = convertirARomano($numero_arabe);

echo "<h1>Romanos a árabes - Resultado</h1>";
echo "<p>El número " . $numero_arabe . " se escribe en números romanos: <strong>" . $numero_romano . "</strong></p>";
echo "</div>";
