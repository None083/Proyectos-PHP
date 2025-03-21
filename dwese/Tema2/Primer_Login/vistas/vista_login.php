<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $errores_form_login = $error_usuario || $error_clave;
    if (!$errores_form_login) {
        //consulta la bd y si está inicio sesion y salto a index
        try {
            @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Práctica 8", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
        }
        //me he conectado

        try {
            $consulta = "select usuario from usuarios where usuario='".$_POST["usuario"]."' AND clave='".md5($_POST["clave"])."'";
            $resultado = mysqli_query($conexion, $consulta);
            $n_tuplas = mysqli_num_rows($resultado);
            mysqli_free_result($resultado);
            if ($n_tuplas > 0) {

                mysqli_close($conexion);
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = md5($_POST["clave"]);
                $_SESSION["ultm_accion"]=time();
                header("Location:index.php");
                exit;

            } else {
                $error_usuario = true;
            }
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }
        .mensaje{
            color:blue;
            font-size:1.25rem
        }
    </style>
    <title>Primer Login</title>
</head>

<body>
    <h1>Primer Login</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario y/o contraseña incorrectos  *</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Clave:</label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p><button type="submit" name="btnLogin">Login</button></p>
    </form>
    <?php
    if(isset($_SESSION["mensaje_seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>

</html>