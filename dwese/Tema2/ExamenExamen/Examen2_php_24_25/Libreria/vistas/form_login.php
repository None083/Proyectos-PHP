<form action="index.php" method="post">
    <p>
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        <?php
        if (isset($_POST["entrar"]) && $errores_form_login) {
            if ($_POST["usuario"] == "") {
                echo "<span>Campo vacío</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña: </label>
        <input type="password" name="clave" id="clave">
        <?php
        if (isset($_POST["entrar"]) && $errores_form_login) {
            if ($_POST["clave"] == "") {
                echo "<span>Campo vacío</span>";
            }
        }
        ?>
    </p>
    <button type="submit" name="entrar">Entrar</button>
</form>