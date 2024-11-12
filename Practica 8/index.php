<?php
session_start();

require "vistas/funciones.php";

try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    mysqli_close($conexion);
    session_destroy();
    die(error_page("Práctica 8", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}
//a partir de aqui tengo conxion con mi bd

if (isset($_POST["btnDetalles"]) || isset($_POST["btnEnviar"]) || isset($_POST["btnBorrar"])) {
    if (isset($_POST["btnDetalles"])) {
        $id_usuario = $_POST["btnDetalles"];
    } else {
        $id_usuario = $_POST["id_usuario"];
    }

    try {
        $consulta = "select * from usuarios where id_usuario='" . $id_usuario . "'";
        $detalle_usuario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnContBorrar"])) {
    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
        $_SESSION["mensaje_accion"] = "Usuario borrado con éxito";
        header("Location:index.php");
        exit;
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Práctica 8", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
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
            die(error_page("Primer CRUD", "<p>" . $error_usuario . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_dni = !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "usuario", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer CRUD", "<p>" . $error_dni . "</p>"));
        }
    }
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);

    $errores_form_crear = $error_nombre || $error_usuario || $error_dni || $error_foto || $error_clave;

    if (!$errores_form_crear) {
        //inserto foto por defecto
        //y si he subido foto, muevo la fotro y actualizo el nombre de la foto en la bd (img_id.extension)
    }
}

//consulta para listar usuarios
try {
    $consulta = "select * from usuarios";
    $datos_usuario = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    die(error_page("Práctica 8", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
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
    </style>
    <title>CRUD - PRÁCTICA 8</title>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje_accion"] . "</p>";
        session_destroy();
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

    require "vistas/vista_tabla.php";
    ?>
</body>

</html>