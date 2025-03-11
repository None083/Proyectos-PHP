<?php



if(isset($_POST["grupos"]))
{
    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/horario/".$_POST["grupos"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_horario=json_decode($respuesta,true);
    if(!$json_horario)
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_horario["error"]))
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>".$json_horario["error"]."</p>"));
    }

    if(isset($json_horario["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_horario["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    foreach($json_horario["horario"] as $tupla)
    {
        if(isset($horario_grupo[$tupla["dia"]][$tupla["hora"]]))
            $horario_grupo[$tupla["dia"]][$tupla["hora"]].="<br>".$tupla["usuario"]." (".$tupla["aula"].")";
        else
            $horario_grupo[$tupla["dia"]][$tupla["hora"]]=$tupla["usuario"]." (".$tupla["aula"].")";
    }
    
}

if(isset($_POST["dia"]))
{
    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/profesores/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["grupos"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_profesores_grupo=json_decode($respuesta,true);
    if(!$json_profesores_grupo)
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_profesores_grupo["error"]))
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>".$json_profesores_grupo["error"]."</p>"));
    }

    if(isset($json_profesores_grupo["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_profesores_grupo["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }


    $headers[]="Authorization: Bearer ".$_SESSION["token"];
    $url=DIR_SERV."/profesoresLibres/".$_POST["dia"]."/".$_POST["hora"]."/".$_POST["grupos"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_profesores_grupo_libres=json_decode($respuesta,true);
    if(!$json_profesores_grupo_libres)
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
    }
    if(isset($json_profesores_grupo_libres["error"]))
    {
        session_destroy();
        die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>".$json_profesores_grupo_libres["error"]."</p>"));
    }

    if(isset($json_profesores_grupo_libres["no_auth"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_profesores_grupo_libres["mensaje_baneo"]))
    {
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    
}


$headers[]="Authorization: Bearer ".$_SESSION["token"];
$url=DIR_SERV."/grupos";
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_grupos=json_decode($respuesta,true);
if(!$json_grupos)
{
     session_destroy();
     die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
}
if(isset($json_grupos["error"]))
{
     session_destroy();
     die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>".$json_grupos["error"]."</p>"));
}

if(isset($json_grupos["no_auth"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if(isset($json_grupos["mensaje_baneo"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen5 PHP</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
        table, td, th{border:1px solid black}
        table{border-collapse:collapse;width:80%;margin:0 auto}
        th{background-color: #CCC;}
        .text_izq{text-align:left}
        .text_centrado{text-align:center}
    </style>
</head>

<body>
    <h1>Examen5 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
   <h2>Horario de los Grupos</h2>
   <?php
    if(count($json_grupos["grupos"])>0)
    {
    ?>    
        <form action="index.php" method="post">
            <p>
                <label for="grupos">Elija un Grupo:</label> 
                <select name="grupos" id="grupos">
                <?php
                    foreach($json_grupos["grupos"] as $tupla)
                    {
                        if(isset($_POST["grupos"]) && $_POST["grupos"]==$tupla["id_grupo"])
                        {
                            echo "<option selected value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
                            $nombre_grupo=$tupla["nombre"];
                        }
                        else
                            echo "<option value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
                    }

                ?>
                </select>
                <button type="submit" name="btnVerHorario">Ver Horario</button>
            </p>
        </form>
    <?php
        if(isset($_POST["grupos"]))
        {
            echo "<h3 class='text_centrado'>Horario del grupo: ".$nombre_grupo."</h3>";


            $dias[1]="Lunes";
            $dias[]="Martes";
            $dias[]="Miércoles";
            $dias[]="Jueves";
            $dias[]="Viernes";

            $horas[1]="8:15 - 9:15";
            $horas[]="9:15 - 10:15";
            $horas[]="10:15 - 11:15";
            $horas[]="11:15 - 11:15";
            $horas[]="11:45 - 12:45";
            $horas[]="12:45 - 13:45";
            $horas[]="13:45 - 14:45";

            echo "<table class='text_centrado'>";
            echo "<tr>";
            echo "<th></th>";
            for($k=1;$k<=count($dias);$k++)
                echo "<th>".$dias[$k]."</th>";
            echo "</tr>";

            for($hora=1; $hora<=count($horas);$hora++)
            {
                echo "<tr>";
                echo "<td>".$horas[$hora]."</td>";
                if($hora==4)
                {
                    echo "<td colspan='5'>RECREO</td>";
                }
                else
                {
                    for($dia=1;$dia<=count($dias);$dia++)
                    {
                        if(isset($horario_grupo[$dia][$hora]))
                            echo "<td>".$horario_grupo[$dia][$hora];
                        else
                            echo "<td>";

                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='dia' value='".$dia."'>";
                        echo "<input type='hidden' name='hora' value='".$hora."'>";
                        echo "<input type='hidden' name='grupos' value='".$_POST["grupos"]."'>";
                        echo "<button type='submit' class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form>";

                        echo "</td>";
                    }
                }
                
                echo "</tr>";
            }
            echo "</table>";

            if(isset($_POST["dia"]))
            {
                if($_POST["hora"]>4)
                    echo "<h2>Editando la ".($_POST["hora"]-1)."º Hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h3>";
                else
                    echo "<h2>Editando la ".$_POST["hora"]."º Hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h3>";
            

                // Sigo con la tabla
                echo "<table class='text_centrado'>";
                echo "<tr><th>Profesor (Aula)</th><th>Acción</th></tr>";
                foreach($json_profesores_grupo["profesores"] as $tupla)
                {
                    echo "<tr>";
                    echo "<td>".$tupla["usuario"]." (".$tupla["aula"].")</td>";
                    echo "<td>Quitar</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
                <form action="index.php" method="post">
                    <p>
                        <label for="profesores">Elija un Grupo:</label> 
                        <select name="profesores" id="profesores">
                        <?php
                            foreach($json_profesores_grupo_libres["profesores_libres"] as $tupla)
                            {
                                
                                    echo "<option value='".$tupla["id_usuario"]."'>".$tupla["usuario"]."</option>";
                            }

                        ?>
                        </select>
                        <button type="submit" name="btnAnyadir">Añadir</button>
                    </p>
                </form>

                <?php
            }
        }
    }
    else
        echo "<p>No hay grupos introducidos en la BD</p>";

    ?>

</body>
</html>