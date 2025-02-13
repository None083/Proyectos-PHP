<?php
session_name("Gestion_Guardias");
session_start();
require "src/funciones_ctes.php";


if(isset($_POST["btnCerrarSession"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["token"]))
{
    require "src/seguridad.php";
    require "vistas/vista_logueado.php";
}
else
{
    require "vistas/vista_login.php";
}
?>

