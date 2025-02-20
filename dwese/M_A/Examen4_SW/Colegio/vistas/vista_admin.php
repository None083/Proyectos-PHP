<?php

if(isset($_POST["btnBorrar"]))
{
    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/quitarNota/".$_POST["alumno"];
    $datos_env["cod_asig"]=$_POST["asignatura"];
    $respuesta=consumir_servicios_JWT_REST($url,"DELETE",$headers,$datos_env);
    $json_borrar=json_decode($respuesta,true);
    if(!$json_borrar)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_borrar["error"]))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_borrar["error"]."</p>"));
    }

    if(isset($json_borrar["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:".$salto);
        exit;
    }
    if(isset($json_borrar["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:".$salto);
        exit;
    }
    

    $_SESSION["mensaje_accion"]="Asignatura descalificada con éxito";
    $_SESSION["alumno"]=$_POST["alumno"];
    header("Location:index.php");
    exit;

}

if(isset($_SESSION["alumno"]))
{
    $_POST["alumno"]=$_SESSION["alumno"];
    unset($_SESSION["alumno"]);
}

if(isset($_POST["btnCambiar"]))
{
    $error_form=$_POST["nota"]==""|| !is_numeric($_POST["nota"])|| $_POST["nota"]<0 || $_POST["nota"]>10;
    if(!$error_form)
    {
        
        $headers[]="Authorization: Bearer ".$_SESSION["token"];
        $url=DIR_SERV."/cambiarNota/".$_POST["alumno"];
        $datos_env["cod_asig"]=$_POST["asignatura"];
        $datos_env["nota"]=$_POST["nota"];
        $respuesta=consumir_servicios_JWT_REST($url,"PUT",$headers,$datos_env);
        $json_cambiar=json_decode($respuesta,true);
        if(!$json_cambiar)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
        }
        if(isset($json_cambiar["error"]))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_cambiar["error"]."</p>"));
        }

        if(isset($json_cambiar["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:".$salto);
            exit;
        }
        if(isset($json_cambiar["mensaje_baneo"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:".$salto);
            exit;
        }



    
        $_SESSION["mensaje_accion"]="Nota cambiada con éxito";
        $_SESSION["alumno"]=$_POST["alumno"];
        header("Location:index.php");
        exit;
    }
}

if(isset($_POST["btnCalificar"]))
{
    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/ponerNota/".$_POST["alumno"];
    $datos_env["cod_asig"]=$_POST["asignatura"];
    $respuesta=consumir_servicios_JWT_REST($url,"POST",$headers,$datos_env);
    $json_poner=json_decode($respuesta,true);
    if(!$json_poner)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_poner["error"]))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_poner["error"]."</p>"));
    }

    if(isset($json_poner["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:".$salto);
        exit;
    }
    if(isset($json_poner["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:".$salto);
        exit;
    }

    $_SESSION["mensaje_accion"]="Asignatura calificada con un cero. Cambie la nota si lo estima necesario";
    $_SESSION["asignatura"]=$_POST["asignatura"];
    $_SESSION["alumno"]=$_POST["alumno"];
    header("Location:index.php");
    exit;
}



if(isset($_POST["alumno"]))
{
    
    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/notasAlumno/".$_POST["alumno"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_notas_alumnos=json_decode($respuesta,true);
    if(!$json_notas_alumnos)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_notas_alumnos["error"]))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_notas_alumnos["error"]."</p>"));
    }

    if(isset($json_notas_alumnos["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:".$salto);
        exit;
    }
    if(isset($json_notas_alumnos["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:".$salto);
        exit;
    }
    


    $url=DIR_SERV."/asignaturasNoEvalAlumno/".$_POST["alumno"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_asig_no_eval_alumnos=json_decode($respuesta,true);
    if(!$json_asig_no_eval_alumnos)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_asig_no_eval_alumnos["error"]))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_asig_no_eval_alumnos["error"]."</p>"));
    }

    if(isset($json_asig_no_eval_alumnos["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:".$salto);
        exit;
    }
    if(isset($json_asig_no_eval_alumnos["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:".$salto);
        exit;
    }

}

$headers[]="Authorization: Bearer ".$_SESSION["token"];
$url=DIR_SERV."/alumnos";
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_alumnos=json_decode($respuesta,true);
if(!$json_alumnos)
{
     session_destroy();
     die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
}
if(isset($json_alumnos["error"]))
{
     session_destroy();
     die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_alumnos["error"]."</p>"));
}

if(isset($json_alumnos["no_auth"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:".$salto);
    exit;
}
if(isset($json_alumnos["mensaje_baneo"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:".$salto);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
        table, td, th{
            border:1px solid black;
        }
        table{
            border-collapse:collapse;text-align: center;
        }
        th{
            background-color:#CCC
        }
        .error{color:red}
        .mensaje{font-size:1.25em; color:blue}
    </style>
</head>
<body>
    <h1>Nota de los Alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"];?></strong> - <form class="enlinea" action="../index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    if(count($json_alumnos["alumnos"])<=0)
    {
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";
    }
    else
    {
        
        ?>
        <form action="index.php" method="post">
            <p>
                <label for="alumno">Seleccione un Alumno: </label>
                <select name="alumno" id="alumno">
                <?php
                foreach($json_alumnos["alumnos"] as $tupla)
                {
                    if(isset($_POST["alumno"]) && $_POST["alumno"]==$tupla["cod_usu"])
                    {
                        echo "<option selected value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";
                        $nombre_alumno=$tupla["nombre"];
                    }
                    else
                        echo "<option value='".$tupla["cod_usu"]."'>".$tupla["nombre"]."</option>";    
                }
   
                ?>
                </select>
                <button type="submit" name="btnVerNotas">Ver Notas</button>
            </p>
        </form>
        <?php
        if(isset($_POST["alumno"]))
        {
            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";
           
            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            foreach($json_notas_alumnos["notas"] as $tupla)
            {
                echo "<tr>";
                echo "<td>".$tupla["denominacion"]."</td>";
                if((isset($_POST["btnEditar"]) && $tupla["cod_asig"]==$_POST["asignatura"])|| (isset($_POST["btnCambiar"])  && $tupla["cod_asig"]==$_POST["asignatura"])|| (isset($_SESSION["asignatura"])  && $tupla["cod_asig"]==$_SESSION["asignatura"]))
                {
                    echo  "<td><form action='index.php' method='post'>";
                    echo "<input type='hidden' name='asignatura' value='".$tupla["cod_asig"]."'/>";
                    echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'/>";
                    if(isset($_POST["btnCambiar"]))
                        echo "<input type='text' placeholder='Teclee un valor entre 0 y 10' name='nota' value='".$_POST["nota"]."'/>";
                    else
                        echo "<input type='text' placeholder='Teclee un valor entre 0 y 10' name='nota' value='".$tupla["nota"]."'/>";

                    if(isset($_POST["btnCambiar"]) && $error_form)
                    {
                        
                            echo "<br/><span class='error'>* No has introducido un valor válido de Nota *</span>";
                    
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<button name='btnCambiar' type='submit' class='enlace'>Cambiar</button>";
                    echo " - <button  type='submit' class='enlace'>Atrás</button> ";
                    echo "</form></td>";
                 
                }
                else
                {
                    echo "<td>".$tupla["nota"]."</td>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='asignatura' value='".$tupla["cod_asig"]."'/>";
                    echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'/>";
                    echo "<p>";
                    echo "<button name='btnEditar' type='submit' class='enlace'>Editar</button>";
                    echo " - <button name='btnBorrar' type='submit' class='enlace'>Borrar</button> ";
                    echo "</p>";
                    echo "</form>";
                    echo "</td>";
                }
                
                echo "</tr>";
            }
            echo "</table>";
       
            if(isset($_SESSION["mensaje_accion"]))
            {
                echo "<p class='mensaje'>¡¡ ".$_SESSION["mensaje_accion"]." !!</p>";
                unset($_SESSION["mensaje_accion"]);
            }

            if(count($json_asig_no_eval_alumnos["asignaturas"])<=0)
            {
                echo "<p>A <strong>".$nombre_alumno."</strong> no le quedan asignaturas que calificar</p>";
            }
            else
            {
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'/>";
                echo "<p>";
                echo "<label for='asignatura'>Asignaturas que a <strong></strong> aún le quedan por calificar: </label>";
                echo "<select name='asignatura' id='asignatura'>";
                foreach($json_asig_no_eval_alumnos["asignaturas"] as $tupla)
                {
                    echo "<option value='".$tupla["cod_asig"]."'>".$tupla["denominacion"]."</option>";
                }
                echo "</select>";
                echo "<button type='submit' name='btnCalificar'>Calificar</button>";
                echo "</p>";
                echo "</form>";
                
            }
        }
  
    }
    ?>
   
</body>