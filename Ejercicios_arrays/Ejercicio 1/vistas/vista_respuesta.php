<?php
echo "<div id='contenedor-resp'";

if (substr($_POST["primera"], -3) == substr($_POST["segunda"], -3)) {
    echo " style='background-color: lightgreen;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $_POST["primera"] . " y " . $_POST["segunda"] . " riman.</p>";
} elseif (substr($_POST["primera"], -2) == substr($_POST["segunda"], -2)) {
    echo " style='background-color: lightsalmon;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $_POST["primera"] . " y " . $_POST["segunda"] . " riman un poco.</p>";
} else {
    echo " style='background-color: red;'>";
    echo "<h1>Ripios - Resultado</h1>";
    echo "<p>" . $_POST["primera"] . " y " . $_POST["segunda"] . " no riman.</p>";
}

echo "</div>";
?>