<?php
if (isset($_POST["subir"])) {
    $error_form = $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"] > 1000 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer 4</title>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    
    if (isset($_POST["subir"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        $var = move_uploaded_file($_FILES["fichero"][""], $_FILES[""]["name"]);
    }

    @$fd = fopen("Horario/horarios.txt", "r");
    if ($fd) {
        echo "<h2>Muestro horario</h2>";

        fclose($fd);
    } else {
    ?>

        <form action="ejer4-clase.php" method="post">
            <p>
                <label for="fichero">Seleccione</label>
                <input type="file" name="fichero" id="fichero">
                <?php
                if (isset($_POST["subir"]) && $error_form) {
                    if ($_FILES["fichero"]["type"] != "text/plain") {
                        # code...
                    }
                }
                ?>
            </p>
            <button type="submit" name="subir">Subir</button>
        </form>

    <?php

        echo "<h2>No se encuentra el fichero</h2>";
    }
    ?>

    <?php
    if (isset($_POST["subir"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        $var = move_uploaded_file($_FILES["fichero"][""], $_FILES[""]["name"]);
    }
    ?>
</body>

</html>