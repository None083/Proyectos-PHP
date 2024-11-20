<?php
if (isset($_POST["agregar"])) {
    $error_form = $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 500 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }
    </style>
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejercicio1.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">
                Seleccione un fichero de texto plano para agregar al fichero aulas.txt (Máx. 500KB)
            </label>
            <input type="file" name="archivo" id="archivo" accept=".txt">
            <?php
            if (isset($_POST["agregar"]) && $error_form) {
                if ($_FILES["archivo"]["name"] == "") {
                    echo "<span class='error'>No has selccionado ningún archivo</span>";
                } else if ($_FILES["archivo"]["error"]) {
                    echo "<span class='error'>Error en la suvida del fichero al servidor</span>";
                } else if ($_FILES["archivo"]["type"] != "text/plain") {
                    echo "<span class='error'>Este tipo de archivo no está permitido</span>";
                } else if ($_FILES["archivo"]["size"] > 500 * 1024) {
                    echo "<span class='error'>El archivo no debe pesar más de 500KB</span>";
                }
            }
            ?>
        </P>
        <p>
            <button type="submit" name="agregar" id="argregar">Agregar</button>
            <button type="submit" name="cv" id="cv">Crear/Vaciar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["agregar"]) && !$error_form) {
        @$file = fopen("Aulas/aulas.txt", "r+");
        if (!$file) {
            echo "<p><strong>No se ha podido leer el fichero aulas.txt</strong></p>";
        } else {
            $archivo = file_get_contents($_FILES["archivo"]["tmp_name"]);
            fputs($file, $archivo.PHP_EOL.file_get_contents("Aulas/aulas.txt").PHP_EOL);

            echo "<h2>El fichero 'aulas.txt' tras esta operación tiene el siguiente contenido:</h2>";
            echo "<textarea cols='100' rows='20'>" . file_get_contents("Aulas/aulas.txt") . "</textarea>";
        }


        fclose($file);
    }
    if (isset($_POST["cv"])) {
        @$file = fopen("Aulas/aulas.txt", "w");
        if (!$file) {
            echo "<h2>No tienes permisos en el servidor para crear <em>aulas.txt</em></h2>";
        } else {
            echo "<h2>Se ha creado con éxito el archivo <em>aulas.txt</em></h2>";
        }

        fclose($file);
    }
    ?>
</body>

</html>