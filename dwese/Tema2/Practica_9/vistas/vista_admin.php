<?php

try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die(error_page("Práctica 9", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}
//a partir de aqui tengo conxion con mi bd

if (isset($_POST["btnContBorrar"])) {
    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
        if ($_POST["nombre_foto_bd"] != NOMBRE_IMAGEN_DEFECTO_BD) {
            unlink("Img/" . $_POST["nombre_foto_bd"]);
        }
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        header("Location:index.php");
        exit;
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Práctica 9", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnDetalles"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"])) {
    if (isset($_POST["btnDetalles"])) {
        $id_usuario = $_POST["btnDetalles"];
    } else {
        $id_usuario = $_POST["id_usuario"];
    }

    try {
        $consulta = "select * from usuarios where id_usuario='" . $id_usuario . "'";
        $result_detalle_usuario = mysqli_query($conexion, $consulta);
        $detalle_usuario = mysqli_fetch_assoc($result_detalle_usuario);
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Práctica 9", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnContCrear"])) {

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

if (isset($_POST["btnContEditar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["btnContEditar"]);
        if (is_string($error_usuario)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 9", "<p>" . $error_usuario . "</p>"));
        }
    }

    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"], "id_usuario", $_POST["btnContEditar"]);
        if (is_string($error_dni)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 9", "<p>" . $error_dni . "</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);

    $errores_form_editar = $error_nombre || $error_usuario || $error_dni || $error_foto;

    if (!$errores_form_editar) {
        try {
            if ($_POST["clave"] == "") {
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', dni='" . strtoupper($_POST["dni"]) . "', sexo='" . $_POST["sexo"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            } else {
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', clave='" . md5($_POST["clave"]) . "', dni='" . strtoupper($_POST["dni"]) . "', sexo='" . $_POST["sexo"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            }
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Practica 9", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        if ($_FILES["foto"]["name"] != "") {
            $array_nombre = explode(".", $_FILES["foto"]["name"]);
            $ext = end($array_nombre);
            $nombre_nuevo = "img_" . $_POST["btnContEditar"] . "." . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_nuevo);
            if ($var) {
                if ($nombre_nuevo != $_POST["foto_bd"]) {
                    try {
                        $consulta = "update usuarios set foto='" . $nombre_nuevo . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
                        mysqli_query($conexion, $consulta);
                        if ($_POST["foto_bd"] != NOMBRE_IMAGEN_DEFECTO_BD)
                            unlink("Img/" . $_POST["foto_bd"]);
                    } catch (Exception $e) {
                        unlink("Img/" . $nombre_nuevo);
                        $_SESSION["mensaje_accion"] = "Usuario insertado con éxito, pero con la imagen por defecto.";
                    }
                }
            } else {
                $_SESSION["mensaje_accion"] = "Usuario editado con éxito, pero con la imagen por defecto";
            }
        }
        $_SESSION["mensaje_accion"] = "Usuario editado con éxito";
        header("Location:index.php");
        exit;
    }
}

//consulta para listar usuarios
try {
    $consulta = "select * from usuarios";
    $datos_usuario = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    die(error_page("Práctica 9", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 90%;
            margin: 0 auto;
        }

        .enlace {
            background: none;
            color: blue;
            cursor: pointer;
            border: none;
            text-decoration: underline;
        }

        .mensaje {
            font-size: 1.25rem;
            color: blue;
        }

        .error {
            color: red;
        }
        .enLinea{
            display:inline
        }
        .enlace{
            background: none;
            border:none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>CRUD - PRÁCTICA 9</title>
</head>

<body>
    <h1>Práctica 9</h1>
    <div>
        Bienvenido - <strong><?php echo $datos_usuario_log["usuario"]; ?></strong>
        <form action="index.php" class="enlinea" method="post">
            <button type="submit" class="enlace" name="btnCerrarSesion">Cerrar sesión</button>
        </form>
    </div>
    <?php

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if (isset($_POST["btnDetalles"])) {
        require "vistas/vista_detalles.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_borrar.php";
    }

    if (isset($_POST["btnCrear"]) || (isset($_POST["btnContCrear"]) && $errores_form_crear)) {
        require "vistas/vista_crear.php";
    }

    if (isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"]) && $errores_form_editar)) {
        require "vistas/vista_editar.php";
    }

    require "vistas/vista_tabla.php";
    ?>
</body>

</html>