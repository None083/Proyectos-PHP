<?php
// Copio las constantes y las funciones
require "src/ctes_funciones.php";

// Inicio sesión
session_name("primerLogin");
session_start();

// Botón salir que tiene que estar en cada vista logueada
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    // Si estoy logueado
    require "vistas/seguridad.php";

    if ($datos_usuario_logueado["tipo"] == "admin")
        require "vistas/vista_logueado_admin.php";
    else
        require "vistas/vista_logueado_normal.php";

    
} else if (isset($_POST["login"]) || isset($_POST["btnLogin"])){
    // Si no estoy logueado
    require "vistas/vista_login.php";
} else if (isset($_POST["registro"]) || isset($_POST["btnRegistro"])){
    // Si no estoy logueado
    require "vistas/vista_registro.php";
} else {
    echo '
    <h1>Primer Login</h1>
    <form action="index.php" method="post">
    <button type="submit" name="login">Login</button>
    <button type="submit" name="registro">Registro</button>
    </form>';
}
