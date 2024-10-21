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
    <title>Ejer 2</title>
</head>
<body>
    <form action="ejer2-clase.php" method="post">
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
    if (isset($_POST["subir"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        $var = move_uploaded_file($_FILES["fichero"][""], $_FILES[""]["name"]);
    }
    ?>
</body>
</html>