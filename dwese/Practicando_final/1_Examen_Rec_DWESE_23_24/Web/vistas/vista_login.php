<?php
if(isset($_POST["btnLogin"]))
{
    //compruebo errores
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form_login=$error_usuario || $error_clave;
    if(!$error_form_login)
    {
        $url=DIR_SERV."/login";
        $datos_env["usuario"]=$_POST["usuario"];
        $datos_env["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url,"POST",$datos_env);
        $json_login=json_decode($respuesta,true);
        if(!$json_login)
        {
            session_destroy();
            die(error_page("Login con SW","<p>Error consumiendo el Servicio Web: <strong>".$url."</strong></p>"));
        }

        if(isset($json_login["error"]))
        {
            session_destroy();
            die(error_page("Login con SW","<p>".$json_login["error"]."</p>"));
        }

        if(isset($json_login["usuario"]))
        {
            $_SESSION["ultm_accion"]=time();
            $_SESSION["token"]=$json_login["token"];
            header("Location:index.php");
            exit;
        }
        else
            $error_usuario=true;


    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen5 PHP</title>
</head>
<body>
    <h1>Examen5 PHP</h1>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='seguridad'>".$_SESSION["seguridad"]."</p>";
        unset($_SESSION["seguridad"]);
    }
    ?>
    <form action="index.php" method="post">
        <div>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* ".$obj->mensaje." *</span>";
            }
            ?>
        </div>
        <div>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" value=""/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </div>
        <div>
            <button name="btnLogin">Login</button>
        </div>
    </form>
    <?php
    if(isset($_SESSION["mensaje_seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_seguridad"]."</p>";
        unset($_SESSION["mensaje_seguridad"]);
    }
    ?>
</body>
</html>