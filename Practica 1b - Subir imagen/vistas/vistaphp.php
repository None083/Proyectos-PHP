<?php
echo "<h1>Datos recogidos</h1>";
//var_dump($_POST);
echo "<p><strong>Nombre: </strong>", $_POST["nombre"] . "</p>";
echo "<p><strong>Apellidos: </strong>", $_POST["apellidos"] . "</p>";
echo "<p><strong>Contraseña: </strong>", $_POST["pass"] . "</p>";
echo "<p><strong>DNI: </strong>", $_POST["dni"] . "</p>";
echo "<p><strong>Sexo: </strong>";
if (isset($_POST["sexo"])) {
    echo $_POST["sexo"];
}
echo "</p>";
$numero_unico = md5(uniqid(uniqid(), true));
$ext = tiene_extension($_FILES["foto"]["name"]);
$nombre_imagen = "img_ " . $numero_unico . "." . $ext;

@$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_imagen);
echo "<p><strong>Imagen:</strong></p>";
if (!$var) {
    echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
} else {
    //sudo chmod 777 -R '/opt/lampp/htdocs/Proyectos'

    echo "<p>Nombre orginal: " . $_FILES["foto"]["name"] . "</p>";
    echo "<p>Tipo: " . $_FILES["foto"]["type"] . "</p>";
    echo "<p>Tamaño: " . $_FILES["foto"]["size"] . "</p>";
    echo "<p>Archivo subido temporalmente en: " . $_FILES["foto"]["tmp_name"] . "</p>";
    echo "<img src='images/$nombre_imagen' alt='Imagen subida' name = 'Imagen subida' width='200px' height='auto'>";
}
echo "<p><strong>Nacido en: </strong>", $_POST["ciudad"] . "</p>";
echo "<p><strong>Comentarios: </strong>", $_POST["coment"] . "</p>";
echo "<p><strong>Suscrito: </strong>";
if (isset($_POST["suscribir"])) {
    echo "sí";
} else {
    echo "no";
}
echo "</p>";
