<?php
    if (!isset($_POST["enviar"])) {
        header(header: "Location:index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida de datos</title>
</head>
<body>
    <h1>Datos recogidos</h1>

    <?php
        if (isset($_POST["enviar"])) {
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
            
        }
    ?>
</body>
</html>