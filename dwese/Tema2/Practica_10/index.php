<?php
session_name("Practica_10");
session_start();
require "src/funciones_constantes.php";

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
        
        require "vistas/vista_admin.php";
    }
} else {
    require "vistas/vista_login.php";
}