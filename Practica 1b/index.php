<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin:0;
        }
    </style>
    <title>Práctica 1</title>
</head>
<body>
<h1>Rellena tu CV</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p><p>Nombre</p>
    <input type="text" name="nombre" id="nombre" placeholder="Introduzca su nombre" required></p>
    
    <p>Apellidos</p>
    <input type="text" name="apellidos" id="apellidos">
    <p>Contraseña</p>
    <input type="password" name="pass" id="pass" required>
    <p>DNI</p>
    <input type="text" name="dni" id="dni">
    <p>Sexo</p>
    <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer</label>
    <input type="radio" name="sexo" id="hombre" value="hombre"><label for="hombre">Hombre</label>
    <p>Incluir mi foto: </p> <input type="file" name="Seleccionar archivo" id="foto" accept="image/*">
    <p>Nacido en: </p> <select name="ciudad" id="ciudad">
        <option value="malaga">Málaga</option>
        <option value="marbella">Marbella</option>
        <option value="estepona">Estepona</option>
    </select>
    <p>Comentarios:</p><textarea name="coment" id="coment" cols="45" rows="8"></textarea><br>
    <input type="checkbox" name="suscribir" id="suscribir"><p>Suscribirse al boletín de Novedades</p>
    <input type="submit" name="enviar" value="Guardar Cambios"> <input type="reset" value="Borrar los datos introducidos">
    

    <?php
        
        if (isset($_POST["enviar"])) {
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
            
        }
    ?>
</form>
    
</body>
</html>