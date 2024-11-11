<h2>Creando un nuevo usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre:</label></br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
        <?php
        if(isset($_POST["btnContCrear"]) && $errores_form_crear){

        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label></br>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php
        if(isset($_POST["btnContCrear"]) && $errores_form_crear){

        }
        ?>
    </p>
    <p>
        <label for="clave">Clave:</label></br>
        <input type="text" name="clave" id="clave" placeholder="Clave..." value="<?php if(isset($_POST["clave"])) echo $_POST["clave"]; ?>">
        <?php
        if(isset($_POST["btnContCrear"]) && $errores_form_crear){

        }
        ?>
    </p>
    <p>
        <label for="dni">DNI:</label></br>
        <input type="text" name="dni" id="dni" placeholder="DNI..." value="<?php if(isset($_POST["dni"])) echo $_POST["dni"]; ?>">
        <?php
        if(isset($_POST["btnContCrear"]) && $errores_form_crear){

        }
        ?>
    </p>
    <p>
        Sexo:</br>
        <input type="radio" name="sexo" id="hombre" value="hombre" checked><label for="hombre">Hombre</label></br>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
    </p>
    <p>
        <label for="foto">Incluir mi foto (Max. 500KB):</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <?php
        if(isset($_POST["btnContCrear"]) && $errores_form_crear){

        }
        ?>
    </p>
    <p>
        <button type="submit" name="btnContCrear">Guardar</button>
        <button type="submit">Atrás</button>
    </p>
</form>