<h1>Esta es mi super página</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>Nombre</p>
    <input type="text" name="nombre" id="nombre" placeholder="Introduzca su nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"></p>
    <?php
    if (isset($_POST["enviar"]) && $error_nombre) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    ?>
    <p>Nacido en: </p> <select name="ciudad" id="ciudad">
        <option value="malaga" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "malaga") echo "selected" ?>>Málaga</option>
        <option value="marbella" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "marbella") echo "selected" ?>>Marbella</option>
        <option value="estepona" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "estepona") echo "selected" ?>>Estepona</option>
    </select>
    <p>Sexo</p>
    <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>><label for="mujer">Mujer</label>
    <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>><label for="hombre">Hombre</label>
    <?php
    if (isset($_POST["enviar"]) && $error_sexo) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    ?>
    <p>Aficiones: <label for="deportes">Deportes</label><input type="checkbox" name="aficiones[]" value="Deportes" <?php if (isset($_POST["aficiones"])) echo "checked" ?>>
        <label for="lectura">Lectura</label><input type="checkbox" name="aficiones[]" value="Lectura" <?php if (isset($_POST["aficiones"])) echo "checked" ?>>
        <label for="otros">Otros</label><input type="checkbox" name="aficiones[]" value="Otros" <?php if (isset($_POST["aficiones"])) echo "checked" ?>>
    </p>
    <p>Comentarios:</p><textarea name="coment" id="coment" cols="45" rows="8"><?php if(isset($_POST["coment"])) echo $_POST["coment"];?></textarea><br>
    <input type="submit" name="enviar" value="Enviar">
</form>