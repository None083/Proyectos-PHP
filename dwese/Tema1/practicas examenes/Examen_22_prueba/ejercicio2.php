<?php

if (isset($_POST["subir"])) {
    $no_fichero = $_FILES["fichero"]["error"] == UPLOAD_ERR_NO_FILE;
    $error_extension = !$no_fichero && $_FILES["fichero"]["type"] != "text/plain";
    $error_tamanio = !$no_fichero && (!filesize($_FILES["fichero"]["tmp_name"]) || $_FILES["fichero"]["size"] > 1 * 1024 * 1024);

    $error_fichero = $no_fichero || $error_extension || $error_tamanio;
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
        .exito{
            color: green;
        }
    </style>
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Ejercicio 2</h1>
    <form action="ejercicio2.php" method="post" enctype="multipart/form-data">
        <p>Escoja un fichero para subirlo (Máx 1MB):
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
            if (isset($_POST["subir"]) && $error_fichero) {
                if ($no_fichero) {
                    //no pongo nada porque ya aparece un mensaje
                } elseif ($error_extension) {
                    echo "<span class='error'>Error: Solo están permitidos los ficheros de texto (.txt).</span>";
                } elseif ($error_tamanio) {
                    echo "<span class='error'>Error: El tamaño es mayor de 1MB.</span>";
                } else {
                    echo "<span class='error'>Error al subir el fichero.</span>";
                }
            }
            ?>
        </p>
        <input type="submit" name="subir" value="subir">
    </form>
    <?php
    if (isset($_POST["subir"]) && !$error_fichero) {

         if (move_uploaded_file($_FILES["fichero"]["tmp_name"], "Ficheros/archivo.txt")) {
             echo "<p class='exito'>Fichero subido correctamente a la carpeta Ficheros con el nombre archivo.txt.</p>";
         } else {
             echo "<p class='error'>Error: No se pudo mover el fichero a la carpeta de destino.</p>";
         }
    }
    ?>
</body>

</html>