<?php
if(isset($_POST["btnEditar"]))
{
    if(isset($detalle_usuario))
    {
        $nombre=$detalle_usuario["nombre"];
        $usuario=$detalle_usuario["usuario"];
        $dni=$detalle_usuario["dni"];
        $sexo=$detalle_usuario["sexo"];
        $foto_bd = $detalle_usuario["foto"];
    }
    else
    {
        die("<p>El usuario ya no se encuentra registrado en la BD</p></body></html>");

    }
}
else
{
    $id_usuario=$_POST["btnContEditar"];
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
    $dni=$_POST["dni"];
    $sexo=$_POST["sexo"];
    $foto_bd=$_POST["foto_bd"];
}

?>
<h2>Editando el usuario <?php echo $id_usuario;?></h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre:</label></br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php echo $nombre; ?>">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_nombre) {
            echo "<span class='error'> * Campo obligatorio * </span>";
        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label></br>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php echo $usuario; ?>">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_usuario) {
            if ($_POST["usuario"] == "") {
                echo "<span class='error'> * Campo obligatorio * </span>";
            } else {
                echo "<span class='error'> * Usuario repetido * </span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Clave:</label></br>
        <input type="password" name="clave" id="clave" placeholder="Clave..." value="">
    </p>
    <p>
        <label for="dni">DNI:</label></br>
        <input type="text" name="dni" id="dni" placeholder="DNI..." value="<?php echo $dni; ?>">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_dni) {
            if ($_POST["dni"] == "") {
                echo "<span class='error'> * Campo Vacío *</span>";
            } elseif (!dni_bien_escrito($_POST["dni"])) {
                echo "<span class='error'> * DNI no está bien escrito *</span>";
            } else if (!dni_valido($_POST["dni"])) {
                echo "<span class='error'> * DNI no válido *</span>";
            } else {
                echo "<span class='error'> * DNI repetido *</span>";
            }
        }
        ?>
    </p>
    <p>
        Sexo:</br>
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if($sexo == "hombre") echo "checked"; ?>><label for="hombre">Hombre</label></br>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if($sexo == "mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
    </p>
    <p>
        <label for="foto">Cambiar mi foto (Max. 500KB):</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_foto) {
            if ($_FILES["foto"]["error"])
                echo "<span class='error'>* No se ha subido el archivo seleccionado al servidor *</span>";
            elseif (!tiene_extension($_FILES["foto"]["name"]))
                echo "<span class='error'>* Has seleccionado un fichero sin extensión *</span>";
            elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "<span class='error'>* No has seleccionado un fichero imagen *</span>";
            else
                echo "<span class='error'>* El fichero seleccionado es mayor de 500KB *</span>";
        }
        ?>
    </p>
    <input type="hidden" name="foto_bd" value="<?php echo $foto_bd ?>">
    <p>
        <button type="submit" name="btnContEditar" value="<?php echo $id_usuario;?>">Guardar</button>
        <button type="submit">Atrás</button>
    </p>
</form>