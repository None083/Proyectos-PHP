<?php

session_name("Primer_Login_b_PDO");
session_start();
require "..src/funciones.php";

if (isset($_SESSION["usuario"])) {
    $salto="../index.php";
    require "../src/seguridad.php";

    //Hasta aquí seguridad
    if($datos_usuario_log["tipo"]=="admin")
    {
        require "../vistas/vista_admin.php";
    }
    else
    {
        header("Location:../index.php");
        exit; 
    }
}else{
    header("Location:../index.php");
    exit;
}

?>