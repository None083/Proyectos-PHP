<?php
session_name("examen_rec_sw_23_24_2025");
session_start();
require "src/ctes_funciones.php";

if (isset($_POST["btnCerrarSesion"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["token"])) {
    //El usuario se ha logueado al menos una vez correctamente
    //Primero compruebo si se ha baneado
    require "src/seguridad.php";

    require "vistas/vista_normal.php";
} else {
    //El usuario no se ha logueado aún
    require "vistas/vista_login.php";
}
