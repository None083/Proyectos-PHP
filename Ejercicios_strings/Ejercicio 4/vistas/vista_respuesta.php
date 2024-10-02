<?php
echo "<div id='contenedor-resp'";

$numero_romano = strtoupper(str_replace(" ", "", $_POST["string"]));
$numero_arabe = 0;
$num_valido = true;

for ($i = 0; $i < strlen($numero_romano); $i++) {

    switch ($numero_romano[$i]) {
        case 'M':
            $numero_arabe += 1000;
            break;
        case 'D':
            $numero_arabe += 500;
            break;
        case 'C':
            $numero_arabe += 100;
            break;
        case 'L':
            $numero_arabe += 50;
            break;
        case 'X':
            $numero_arabe += 10;
            break;
        case 'V':
            $numero_arabe += 5;
            break;
        case 'I':
            $numero_arabe += 1;
            break;
        default:
            $num_valido = false;
            break 2;
    }
}

if (!$num_valido) {
    echo " style='background-color: #ff4542;'>";
    echo "<h1>Romanos a árabes - Resultado</h1>";
    echo "<p>El número " . $numero_romano . " no es válido</p>";
} else {
    echo " style='background-color: lightgreen;'>";
    echo "<h1>Romanos a árabes - Resultado</h1>";
    echo "<p>El número " . $numero_romano . " se escribe en cifras árabes: <strong>" . $numero_arabe . "</strong></p>";
}

echo "</div>";
?>