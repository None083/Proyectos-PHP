<?php
    require "src/func_ctes.php";

    if (isset($_POST["entrar"])) {
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $errores_form_login = $error_usuario || $error_clave;
        if (!$errores_form_login) {
            try {
                @$conexion = mysqli_connect($HOST_BD, $USER_BD, $CLAVE_BD, $NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die($error_page("Video Club", "<p>Ha ocurrido un error en la conexión: " . $e -> getMessage() . "</p>"));
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Club</title>
</head>

<body>
    <h1>Video Club</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario">
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
        </p>
        <button type="submit" name="entrar">Entrar</button>
        <button type="submit" name="registrar">Registrarse</button>
    </form>
</body>

</html>
