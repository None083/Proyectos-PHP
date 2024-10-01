<?php
echo "<div id='contenedor-resp'";

function pal_cap($string, $longitud_string)
{
    $string_sin_espacios = strtoupper($string);
    $i = 0;
    $j = $longitud_string - 1;
    $palin_capi = true;
    while ($i < $j) {
        if ($string_sin_espacios[$i] != $string_sin_espacios[$j]) {
            $palin_capi = false;
            break;
        }
        $i++;
        $j--;
    }
    return $palin_capi;
}

if (isset($_POST["comprobar"]) && !$errores_form) {
    $string_m = strtoupper(trim($_POST["string"]));
    $palin_capi = pal_cap($string_m, strlen($string_m));

    if ($palin_capi) {
        echo " style='background-color: lightgreen;'>";
        echo "<p>La frase '" . $string_m . "' es palíndroma</p>";
    } else {

        echo " style='background-color: #ff4542;'>";
        echo "<p>La frase '" . $string_m . "' no es palíndroma</p>";
    }
}

echo "</div>";
