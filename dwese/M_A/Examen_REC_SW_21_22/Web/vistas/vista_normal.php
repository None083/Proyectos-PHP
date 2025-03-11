
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
        table{border-collapse:collapse;text-align:center;width:80%;margin:0 auto}
        th{background-color: #CCC;}
        .text_izq{text-align:left}
    </style>
</head>

<body>
    <h1>Examen5 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
   
</body>

</html>