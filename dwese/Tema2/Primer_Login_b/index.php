<?php
session_name("Primer_Login_b");
session_start();
require "src/funciones.php";

if (isset($_POST["btnCerrarSesion"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {
    //control de baneo
    require "src/seguridad.php";

    //muestro vista después de login
    if ($datos_usuario_log["tipo"] == "normal" || isset($_POST["btnContRegistrar"])) {
        require "vistas/vista_normal.php";
    } else {
        mysqli_close($conexion);
        header("Location:admin/index.php");
        exit;
    }
    mysqli_close($conexion);
} else {
    require "vistas/vista_login.php";
}

