<h1>Rellena tu CV</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p><p>Nombre</p>
    <input type="text" name="nombre" id="nombre" placeholder="Introduzca su nombre" value="<?php if(isset($_POST["nombre"])echo $_POST["nombre"];) ?>" required></p>
    <?php
        if (isset($_POST["enviar"])&&$error_nombre) {
            echo "<span class="error">"Compo vacío"</span>";
        }
    ?>
    <p>Apellidos</p>
    <input type="text" name="apellidos" id="apellidos" value="<?php if(isset($_POST["apellidos"])echo $_POST["apellidos"];) ?>">
    <?php
        if (isset($_POST["enviar"])&&$error_apellido) {
            echo "<span class="error">"Compo vacío"</span>";
        }
    ?>
    <p>Contraseña</p>
    <input type="password" name="pass" id="pass" required>
    <?php
        if (isset($_POST["enviar"])&&$error_clave) {
            echo "<span class="error">"Compo vacío"</span>";
        }
    ?>
    <p>DNI</p>
    <input type="text" name="dni" id="dni" value="<?php if(isset($_POST["dni"])echo $_POST["dni"];) ?>">
    <?php
        if (isset($_POST["enviar"])&&$error_dni) {
            echo "<span class="error">"Compo vacío"</span>";
        }
    ?>
    <p>Sexo</p>
    <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer</label>
    <input type="radio" name="sexo" id="hombre" value="hombre"><label for="hombre">Hombre</label>
    <?php
        if (isset($_POST["enviar"])&&$error_sexo) {
            echo "<span class="error">"Compo vacío"</span>";
        }
    ?>
    <p>Incluir mi foto: </p> <input type="file" name="Seleccionar archivo" id="foto" accept="image/*">
    <p>Nacido en: </p> <select name="ciudad" id="ciudad">
        <option value="malaga">Málaga</option>
        <option value="marbella">Marbella</option>
        <option value="estepona">Estepona</option>
    </select>
    <p>Comentarios:</p><textarea name="coment" id="coment" cols="45" rows="8"></textarea><br>
    <input type="checkbox" name="suscribir" id="suscribir"><p>Suscribirse al boletín de Novedades</p>
    <input type="submit" name="enviar" value="Guardar Cambios"> <input type="reset" value="Borrar los datos introducidos">
</form>