<?php
// Comprobar errores
if (isset($_POST["btnRegistro"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "";
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    // Si no hay errores
    if (!$error_form) {
        // Añado al usuario en la bd
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        try {
            $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["clave"] = md5($_POST["clave"]);
        $_SESSION["ultima_accion"] = time();
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        header("Location: index.php");
        exit();

    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Primer Login</h1>
    <form action="index.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php
            if (isset($_POST["btnRegistro"]) && $error_nombre) {
                echo '<span class="error"> Campo vacío</span>';
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnRegistro"]) && $error_usuario) {
                echo '<span class="error"> Campo vacío</span>';
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnRegistro"]) && $error_clave) {
                echo '<span class="error"> Campo vacío</span>';
            }
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
            <?php
            if (isset($_POST["btnRegistro"]) && $error_email) {
                echo '<span class="error"> Campo vacío</span>';
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnRegistro">Continuar</button>
            <button type="submit" name="btnSalir">Volver</button>
        </p>
    </form>
</body>

</html>

<?php
if (isset($_SESSION["seguridad"])) {
    echo "<p class='error'>" . $_SESSION["seguridad"] . "</p>";
    session_destroy();
}
?>