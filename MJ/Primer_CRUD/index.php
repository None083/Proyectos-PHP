<?php
session_start();

require "src/funciones_ctes.php";

try
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    mysqli_set_charset($conexion,"utf8");
}
catch(Exception $e)
{
    die(error_page("Primer CRUD","<p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
}

//A partir de aquí tengo conexión con mi BD


if(isset($_POST["btnContEditar"]))
{
    //Compruebo errores
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>".$error_usuario."</p>"));
        }
    }

    $error_email=$_POST["email"]==""||!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        $error_email=repetido($conexion,"usuarios","email",$_POST["email"],"id_usuario",$_POST["btnContEditar"]);
        if(is_string($error_email))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>".$error_email."</p>"));
        }
    }

    $error_form_editar=$error_nombre||$error_usuario||$error_email;

    //Si no hay errores edito en la tabla e informo de la acción
    if(!$error_form_editar)
    {
        //Edito y mensaje
        try
        {
            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContEditar"]."'";

            mysqli_query($conexion,$consulta);
            $_SESSION["mensaje_accion"]="Usuario editado con éxito";
            header("Location:index.php");
            exit;
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }
    }

}



if(isset($_POST["btnContAgregar"]))
{
    //Compruebo errores
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>".$error_usuario."</p>"));
        }
        
    }
    $error_clave=$_POST["clave"]=="";
    $error_email=$_POST["email"]==""||!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        $error_email=repetido($conexion,"usuarios","email",$_POST["email"]);
        if(is_string($error_email))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>".$error_email."</p>"));
        }
    }

    $error_form_agregar=$error_nombre||$error_usuario||$error_clave||$error_email;

    //Si no hay errores inserto en la tabla e informo de la acción
    if(!$error_form_agregar)
    {
        //inserto BD y mensaje de acción
        try
        {
            $consulta="insert into usuarios (nombre,usuario,clave,email) values('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
            $resultado_agregar=mysqli_query($conexion,$consulta);
            $_SESSION["mensaje_accion"]="Usuario insertado con éxito";
            header("Location:index.php");
            exit;
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }
    }

}


//Obtengo los detalles del usuario tanto al pulsar detalles cómo en el borrar cómo en Editar
if(isset($_POST["btnDetalles"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"]))
{
    if(isset($_POST["btnDetalles"]))
        $id_usuario=$_POST["btnDetalles"];
    elseif(isset($_POST["btnBorrar"]))
        $id_usuario=$_POST["btnBorrar"];
    else
        $id_usuario=$_POST["btnEditar"];

    try
    {
        $consulta="select * from usuarios where id_usuario='".$id_usuario."'";
        $detalle_usuario=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Primer CRUD","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }
}


if(isset($_POST["btnContBorrar"]))
{
    try
    {
        $consulta="delete from usuarios where id_usuario='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion,$consulta);
        $_SESSION["mensaje_accion"]="Usuario borrado con éxito";
        header("Location:index.php");
        exit;
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Primer CRUD","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }
}


///Por último hago la consulta para listar los usuarios de la tabla principal
try
{
    $consulta="select * from usuarios";
    $datos_usuarios=mysqli_query($conexion,$consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die(error_page("Primer CRUD","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
}

mysqli_close($conexion);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD</title>
    <style>
        table,td, th{border:1px solid black}
        table{border-collapse:collapse; text-align: center;}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        .btn_img{border:none;background:none;cursor:pointer}
        .mensaje{font-size:1.25rem; color:blue}
        .error{color:red}
    </style>
</head>
<body>
    <h1>Listado de los Usuarios</h1>
    <?php

    require "vistas/vista_tabla_principal.php";

    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        //unset($_SESSION["mensaje_accion"]);
        //session_unset();
        session_destroy();
    }
        

    if(isset($_POST["btnBorrar"]))
        require "vistas/vista_borrar.php";

    if(isset($_POST["btnDetalles"]))
        require "vistas/vista_detalles.php";

    if(isset($_POST["btnAgregar"]) || (isset($_POST["btnContAgregar"]) && $error_form_agregar))
        require "vistas/vista_agregar.php";

    if(isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"])&& $error_form_editar))
        require "vistas/vista_editar.php";
    ?>
</body>
</html>