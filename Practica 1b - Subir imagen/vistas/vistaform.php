<h1>Rellena tu CV</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>Nombre</p>
    <input type="text" name="nombre" id="nombre" placeholder="Introduzca su nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"></p>
    <?php
    if (isset($_POST["enviar"]) && $error_nombre) {
        echo "<span class='error'> * Campo vacío * </span>";
    }
    ?>
    <p>Apellidos</p>
    <input type="text" name="apellidos" id="apellidos" value="<?php if (isset($_POST["apellidos"])) echo $_POST["apellidos"]; ?>">
    <?php
    if (isset($_POST["enviar"]) && $error_apellido) {
        echo "<span class='error'> * Campo vacío * </span>";
    }
    ?>
    <p>Contraseña</p>
    <input type="password" name="pass" id="pass">
    <?php
    if (isset($_POST["enviar"]) && $error_clave) {
        echo "<span class='error'> * Campo vacío * </span>";
    }
    ?>
    <p>DNI</p>
    <input type="text" name="dni" id="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">
    <?php
    if (isset($_POST["enviar"]) && $_POST["dni"] == "") {
        echo "<span class='error'> * Campo vacío * </span>";
    } else if (isset($_POST["enviar"]) && $error_dni) {
        echo "<span class='error'> * El DNI introducido no es válido * </span>";
    }
    ?>
    <p>Sexo</p>
    <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>><label for="mujer">Mujer</label>
    <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>><label for="hombre">Hombre</label>
    <?php
    if (isset($_POST["enviar"]) && $error_sexo) {
        echo "<span class='error'> * Debes elegir un sexo * </span>";
    }
    ?>
    <p>Incluir mi foto: </p> <input type="file" name="Seleccionar archivo" id="foto" accept="image/*">
    <p>Nacido en: </p> <select name="ciudad" id="ciudad">
        <option value="malaga" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "malaga") echo "selected" ?>>Málaga</option>
        <option value="marbella" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "marbella") echo "selected" ?>>Marbella</option>
        <option value="estepona" <?php if (isset($_POST["ciudad"]) && $_POST["ciudad"] == "estepona") echo "selected" ?>>Estepona</option>
    </select>
    <p>Comentarios:</p><textarea name="coment" id="coment" cols="45" rows="8"><?php if (isset($_POST["coment"])) echo $_POST["coment"]; ?></textarea><br>
    <?php
    if (isset($_POST["enviar"]) && $error_comentarios) {
        echo "<span class='error'> * Campo Vacío *</span>";
    }
    ?>
    <p><input type="checkbox" name="suscribir" id="suscribir" <?php if (isset($_POST["suscribir"])) echo "checked" ?>>Suscribirse al boletín de Novedades</p>
    <input type="submit" name="enviar" value="Guardar Cambios"> <input type="submit" name="borrar" value="Borrar los datos introducidos">
</form>