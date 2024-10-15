<?php
    echo "<h1>Datos recogidos</h1>";
    //var_dump($_POST);
    echo "<p><strong>Nombre: </strong>",$_POST["nombre"]."</p>";
    echo "<p><strong>Apellidos: </strong>",$_POST["apellidos"]."</p>";
    echo "<p><strong>Contraseña: </strong>",$_POST["pass"]."</p>";
    echo "<p><strong>DNI: </strong>",$_POST["dni"]."</p>";
    echo "<p><strong>Sexo: </strong>";
    if (isset($_POST["sexo"])) {
        echo $_POST["sexo"];
    }
    echo "</p>";  
    echo "<p><strong>Nacido en: </strong>",$_POST["ciudad"]."</p>";
    echo "<p><strong>Comentarios: </strong>",$_POST["coment"]."</p>";
    echo "<p><strong>Suscrito: </strong>";
    if (isset($_POST["suscribir"])) {
        echo "sí";
    }  else{
        echo "no";
    }
    echo "</p>";
?>