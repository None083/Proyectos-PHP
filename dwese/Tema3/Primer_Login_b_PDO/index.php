<?php
session_name("Primer_Login_b_PDO");
session_start();
require "src/funciones.php";

if (isset($_POST["btnCerrarSesion"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {
    //control de baneo
    $salto="index.php";
    require "src/seguridad.php";

    //muestro vista después de login
    if ($datos_usuario_log["tipo"] == "normal") {
        require "vistas/vista_normal.php";
    } else {
        $conexion=null;
        header("Location:admin/index.php");
        exit;
    }
    $conexion=null;
} else {
    require "vistas/vista_login.php";
}

