<?php
if (isset($_POST["btnContCrear"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        try {
            @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Práctica 9", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
        }

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

        if (!isset($conexion)) {
            try {
                @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 9", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
            }
        }

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

        $_SESSION["mensaje_registro"] = "Usuario registrado con éxito.";
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
                    $_SESSION["mensaje_registro"] = "Usuario registrado con éxito, pero con la imagen por defecto.";
                }
            } else {
                $_SESSION["mensaje_registro"] = "Usuario registrado con éxito, pero con la imagen por defecto.";
            }
        }

        mysqli_close($conexion);
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["clave"] = md5($_POST["clave"]);
        $_SESSION["ultm_accion"] = time();
        header("Location:index.php");
        exit();
    }
    if (isset($conexion)) {
        mysqli_close($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 9</title>
</head>
<body>
    <?php
    require "vista_crear.php";
    ?>
</body>
</html>