<?php
session_name("examen2_24_25");
session_start();

require "src/funciones_constantes.php";

try {
    @$conexion = mysqli_connect(HOST_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    session_destroy();
    die(error_page("Examen 2", "Ha ocurrido un error en la conexión con la BD: " . $e->getMessage()));
}

$tipo_usuario = "";

if (isset($_POST["entrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $errores_form_login = $error_usuario || $error_clave;

    try {
        $consulta = "select * from usuarios where lector='" . $_POST["usuario"] . "' AND clave='" . md5($_POST["clave"]) . "'";
        $resultado = mysqli_query($conexion, $consulta);

        $tupla = mysqli_fetch_assoc($resultado);
        $tipo_usuario = $tupla["tipo"];
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

try {
    $consulta = "select * from libros";
    $listado_libros = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    die(error_page("Examen 2", "No se ha podido realizar la consulta: " . $e->getMessage()));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        div#listado-libros {
            display: flex;
            flex-flow: row wrap;
        }

        div.libro {
            width: 30%;
            height: auto;
            margin-bottom: 1rem;
        }
    </style>
    <title>Examen 2</title>
</head>

<body>
    <h1>Librería</h1>
    <?php

    if (isset($_POST["entrar"]) && !$errores_form_login) {
        if ($tipo_usuario === "normal") {
            require "vistas/usuario_normal.php";
        }
        if ($tipo_usuario === "admin") {
            require "admin/gest_libros.php";
        }
    } else {
        require "vistas/form_login.php";
    }
    ?>

    <h2>Listado de los Libros</h2>
    <div id="listado-libros">
        <?php
        while ($tupla = mysqli_fetch_assoc($listado_libros)) {
            echo "<div class='libro'>";
            echo $tupla["portada"] . "</br>";
            //echo "<img src='Images/".$tupla["portada"]."' alt='Portada libro'>"; no sé por qué no funciona
            echo $tupla["titulo"] . " - ";
            echo $tupla["precio"] . " €";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>