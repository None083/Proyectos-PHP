<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría subir ficheros</title>
</head>

<body>
    <h1>Teoría subir ficheros</h1>
    <form action="teor_ficheros.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="">Seleccione un archivo de imagen (Máx 500KB): </label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </p>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>
    <?php
    if (!$_FILES["foto"]["error"] == 0) {
        //echo "S_FILES['foto'] existe";
        //echo var_dump($_FILES["foto"]);
        echo "Se ha subido con éxito el archivo";
    } else {
        echo "No se ha subido con éxito el archivo";
    }
    ?>
</body>

</html>