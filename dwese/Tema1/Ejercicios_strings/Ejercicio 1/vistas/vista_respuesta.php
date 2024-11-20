<?php
$texto1 = strtoupper(trim($_POST["primera"]));
$texto2 = strtoupper(trim($_POST["segunda"]));
echo "<div id='contenedor-resp'";
if (substr($texto1, -3) == substr($texto2, -3)) {
    echo " style='background-color: lightgreen;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $texto1 . " y " . $texto2 . " riman.</p>";
} elseif (substr($texto1, -2) == substr($texto2, -2)) {
    echo " style='background-color: lightsalmon;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $texto1 . " y " . $texto2 . " riman un poco.</p>";
} else {
    echo " style='background-color: #ff4542;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $texto1 . " y " . $texto2 . " no riman.</p>";
}

echo "</div>";
?>