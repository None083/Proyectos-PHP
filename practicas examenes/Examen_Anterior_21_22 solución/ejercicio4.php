<?php
const DIAS_SEMANA = array("","Lunes","Martes","Miércoles","Jueves","Viernes");
const HORAS=array(1=>"8:15-9:15","9:15-10:15","10:15-11:15","11:15-11:45","11:45-12:45","12:45-13:45","13:45-14:45");

if(isset($_POST["btnSubir"]))
{
    $error_form=$_FILES["fichero"]["error"] || $_FILES["fichero"]["type"]!="text/plain" || $_FILES["fichero"]["size"]>1000 *1024;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4 Exam Anterior</title>
    <style>
        .error{color:red}
        .text_centrado{text-align:center}
        table, td, th{border:1px solid black}
        table{width:85%;margin:0 auto;border-collapse: collapse;}
        th{background-color:#CCC}
    </style>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <?php
    if(isset($_POST["btnSubir"]) && !$error_form)
    {
        @$var=move_uploaded_file($_FILES["fichero"]["tmp_name"],"Horario/horarios.txt");
        if(!$var)
            echo "<p>El fichero seleccionado no ha podido moverse a la carpeta destino</p>";
    }

    @$fd=fopen("Horario/horarios.txt","r");
    if($fd)
    {
        require "vistas/vista_horario.php";

        fclose($fd);
    }
    else
    {
        require "vistas/vista_formulario_fichero.php";
    }
    ?>
</body>
</html>