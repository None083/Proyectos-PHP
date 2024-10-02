<?php
echo "<div id='contenedor-resp'";

function pal_cap($frase)
{
    $frase_sin_espacios = str_replace(" ", "", $frase);
    $frase_sin_espacios_m = strtoupper($frase_sin_espacios);
    $i = 0;
    $j = strlen($frase_sin_espacios) - 1;
    $palin_capi = true;
    while ($i < $j) {
        if ($frase_sin_espacios_m[$i] != $frase_sin_espacios_m[$j]) {
            $palin_capi = false;
            break;
        }
        $i++;
        $j--;
    }
    return $palin_capi;
}

if (isset($_POST["comprobar"]) && !$errores_form) {
    $frase = trim($_POST["string"]);
    $palin_capi = pal_cap($frase);
    if ($palin_capi) {
        echo " style='background-color: lightgreen;'>";
        echo "<p>La frase '" . $frase . "' es palíndroma</p>";
    } else {
        echo " style='background-color: #ff4542;'>";
        echo "<p>La frase '" . $frase . "' no es palíndroma</p>";
    }
}

echo "</div>";
?>