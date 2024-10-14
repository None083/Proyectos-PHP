<?php

function tiene_extension($extension)
{
    $array_nombre = explode(".", $extension);
    if (count($array_nombre) <= 1) {
        $respuesta = false;
    } else {
        $respuesta = end($array_nombre);
    }
    return $respuesta;
}

if (isset($_POST["btnEnviar"])) {
    $error_foto = $_FILES["foto"]["error"]
        || !tiene_extension($_FILES["foto"]["name"])
        || !getimagesize($_FILES["foto"]["tmp_name"])
        || $_FILES["foto"]["size"] > 500 * 1024;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error{
            color: red;
        }
    </style>
    <title>Teoría subir ficheros</title>
</head>

<body>
    <h1>Teoría subir ficheros</h1>
    <form action="teor_ficheros_req.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="">Seleccione un archivo de imagen (Máx 500KB): </label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
                if (isset($_POST["btnEnviar"]) && $error_foto) {
                    if ($_FILES["foto"]["name"]== "") {
                        echo "<span class='error'>* Debes seleccionar un fichero *</span>";
                    }elseif ($_FILES["foto"]["name"]) {
                        echo "<span class='error'>* No se ha subido el archivo seleccionado al servidor *</span>";
                    }else if (!tiene_extension($_FILES["foto"]["name"])) {
                        echo "<span class='error'>* Has elegido un fichero sin extensión *</span>";
                    }else if (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'>* No has seleccionado un fichero de tipo imagen *</span>";
                    }else{
                        echo "<span class='error'>* El fichero seleccionado es mayor de 500kb *</span>";
                    }
                }
            
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_foto) {
        //echo "S_FILES['foto'] existe";
        //echo var_dump($_FILES["foto"]);
        $numero_unico=md5(uniqid(uniqid(), true));
        $ext = tiene_extension($_FILES["foto"]["name"]);
        $nombre_imagen = "img_ ".$numero_unico.".".$ext;

        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/".$nombre_imagen);
        echo "<h1>Información de la imagen subida</h1>";
        if (!$var) {
            echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
        }else{
            //sudo chmod 777 -R '/opt/lampp/htdocs/Proyectos/Teoria'

            echo "<p><strong>Nombre orginal: </strong>".$_FILES["foto"]["name"]."</p>";
            echo "<p><strong>Tipo: </strong>".$_FILES["foto"]["type"]."</p>";
            echo "<p><strong>Tamaño: </strong>".$_FILES["foto"]["size"]."</p>";
            echo "<p><strong>Archivo subido temporalmente en: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
            echo "<img src='images/$nombre_imagen' alt='Imagen subida' name = 'Imagen subida'>";
            echo "<p>La imagen ha sido subida correctamente</p>";
         }
        
    } 
    ?>
</body>

</html>