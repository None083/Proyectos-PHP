<?php
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
    require "vistas/vista_logueado.php";
}else{
    require "vistas/vista_login.php";
}

