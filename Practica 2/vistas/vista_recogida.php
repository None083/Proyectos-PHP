<?php
echo "<h1>Estos son los datos enviados:</h1>";
echo "<p><strong>El nombre enviado ha sido: </strong>", $_POST["nombre"] . "</p>";
echo "<p><strong>Ha nacido en: </strong>", $_POST["ciudad"] . "</p>";
echo "<p><strong>El sexo es: </strong>", $_POST["sexo"] . "</p>";

if (!isset($_POST["aficiones"])) {
    echo "<strong>No has seleccionado ninguna afición</strong>";
} else {
    echo "<strong>Las aficiones seleccionadas han sido: </strong>";
    echo "<ol>";
    foreach ($_POST["aficiones"] as $value) {
        echo "<li>$value</li>";
    }
    echo "</ol>";
}

if (!isset($_POST["coment"]) || !isset($_POST["coment"]) == "") {
    echo "<strong>No has hecho un comentario</strong>";
} else {
    echo "<p><strong>El comentario enviado ha sido: </strong>", $_POST["coment"] . "</p>";
}