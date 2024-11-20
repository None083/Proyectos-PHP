<h1>Esta es mi super página</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p><label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" placeholder="Introduzca su nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
    
    <?php
    if (isset($_POST["enviar"]) && $error_nombre) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    ?>
    </p>
    <label for="ciudad">Nacido en: </label> <select name="ciudad" id="ciudad">
        <option value="malaga" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "malaga") echo "selected" ?>>Málaga</option>
        <option value="marbella" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "marbella") echo "selected" ?>>Marbella</option>
        <option value="estepona" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "estepona") echo "selected" ?>>Estepona</option>
    </select>
    <p>
        <label for="sexo">Sexo</label>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>><label for="mujer">Mujer</label>
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>><label for="hombre">Hombre</label>
        <?php
        if (isset($_POST["enviar"]) && $error_sexo) {
            echo "<span class='error'> * Campo obligatorio * </span>";
        }
        ?>
    </p>
    <p>Aficiones:
        <label for="deportes">Deportes</label>
        <input type="checkbox" name="aficiones[]" value="Deportes" id="deportes" <?php if (isset($_POST["aficiones"]) && mi_in_array("Deportes", $_POST["aficiones"])) echo "checked" ?>>
        <label for="lectura">Lectura</label>
        <input type="checkbox" name="aficiones[]" value="Lectura" id="lectura" <?php if (isset($_POST["aficiones"]) && in_array("Lectura", $_POST["aficiones"])) echo "checked" ?>>
        <label for="otros">Otros</label>
        <input type="checkbox" name="aficiones[]" value="Otros" id="otros" <?php if (isset($_POST["aficiones"]) && in_array("Otros", $_POST["aficiones"])) echo "checked" ?>>
    </p>
    <p>Comentarios:</p><textarea name="coment" id="coment" cols="45" rows="8"><?php if (isset($_POST["coment"])) echo $_POST["coment"]; ?></textarea><br>
    <button type="submit" name="enviar">Enviar</button>
</form>