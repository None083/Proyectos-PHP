<?php
session_name("Pract_9");
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

    if ($datos_usuario_log["tipo"] == "normal") {
        require "vistas/vista_normal.php";
    }else{
        require "vistas/vista_admin.php";
    }

    
    //mysqli_close($conexion);
}else{
    require "vistas/vista_login.php";
}

