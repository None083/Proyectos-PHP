<?php
if (isset($_POST["btnContRegistrar"])) {

    try {
        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 9", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
    }

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);
        if (is_string($error_usuario)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 9", "<p>" . $error_usuario . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 9", "<p>" . $error_dni . "</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);

    $errores_form_crear = $error_nombre || $error_usuario || $error_dni || $error_foto || $error_clave;

    if (!$errores_form_crear) {
        //inserto foto por defecto
        //y si he subido foto, muevo la foto y actualizo el nombre de la foto en la bd (img_id.extension)

        try {
            $consulta = "insert into usuarios (nombre, usuario, clave, dni, sexo) values ('" . $_POST["nombre"] . "','" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . strtoupper($_POST["dni"]) . "','" . $_POST["sexo"] . "')";
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 9", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        $_SESSION["mensaje_accion"] = "Usuario insertado con éxito.";
        if ($_FILES["foto"]["name"] != "") {
            $ultm_id = mysqli_insert_id($conexion);
            $array_nombre = explode(".", $_FILES["foto"]["name"]);
            $ext = end($array_nombre);
            $nombre_nuevo = "img_" . $ultm_id . "." . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_nuevo);
            if ($var) {
                try {
                    $consulta = "update usuarios set foto='" . $nombre_nuevo . "' where id_usuario='" . $ultm_id . "'";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    unlink("Img/" . $nombre_nuevo);
                    $_SESSION["mensaje_accion"] = "Usuario insertado con éxito, pero con la imagen por defecto.";
                }
            } else {
                $_SESSION["mensaje_accion"] = "Usuario insertado con éxito, pero con la imagen por defecto.";
            }
        }

        header("Location:index.php");
        exit();
    }
}
?>

<h2>Registro de usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre:</label></br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
        <?php
        if (isset($_POST["btnContRegistrar"]) && $error_nombre) {
            echo "<span class='error'> * Campo obligatorio * </span>";
        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label></br>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php
        if (isset($_POST["btnContRegistrar"]) && $error_usuario) {
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
        <?php
        if (isset($_POST["btnContAgregar"]) && $error_clave) {
            echo "<span class='error'>* Campo vacío *</span>";
        }
        ?>
    </p>
    <p>
        <label for="dni">DNI:</label></br>
        <input type="text" name="dni" id="dni" placeholder="DNI..." value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">
        <?php
        if (isset($_POST["btnContRegistrar"]) && $error_dni) {
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
        <input type="radio" name="sexo" id="hombre" value="hombre" checked><label for="hombre">Hombre</label></br>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
    </p>
    <p>
        <label for="foto">Incluir mi foto (Max. 500KB):</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <?php
        if (isset($_POST["btnContRegistrar"]) && $error_foto) {
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
    <p>
        <button type="submit" name="btnContRegistrar">Guardar</button>
        <button type="submit">Atrás</button>
    </p>
</form>