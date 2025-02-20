<?php
$headers[]="Authorization: Bearer ".$_SESSION["token"];
$url=DIR_SERV."/notasAlumno/".$datos_usu_log["cod_usu"];
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_respuesta=json_decode($respuesta,true);
if(!$json_respuesta)
{
     session_destroy();
     die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
}
if(isset($json_respuesta["error"]))
{
     session_destroy();
     die(error_page("Examen4 DWESE Curso 23-24","<h1>Nota de los Alumnos</h1><p>".$json_respuesta["error"]."</p>"));
}

if(isset($json_respuesta["no_auth"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:".$salto);
    exit;
}
if(isset($json_respuesta["mensaje_baneo"]))
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
    </style>
</head>
<body>
    <h1>Nota de los Alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"];?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Notas del Alumno <?php echo $datos_usu_log["nombre"]?></h2>
    <?php
    echo "<table>";
    echo "<tr><th>Asignatura</th><th>Nota</th></tr>";
    foreach($json_respuesta["notas"] as $tupla)
    {
        echo "<tr>";
        echo "<td>".$tupla["denominacion"]."</td>";
        echo "<td>".$tupla["nota"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>
