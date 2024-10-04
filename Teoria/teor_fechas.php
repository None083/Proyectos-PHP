<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Fechas en PHP</title>
</head>
<body>
    <h1>Teoría de Fechas</h1>
    <?php
    echo "<p>".time()."</p>"; //segundos desde 1970
    //si no le pongo segundo argumento coge time()
    $fecha = date("d/m/Y H:i:s"); //Y 4 digitos, y 2 digitos
    $fecha2 = date("d/m/Y H:i:s", time());
    echo "<p>".$fecha."</p>";
    echo "<p>".$fecha2."</p>";

    //checkdate(mes,dia,año)
    if (checkdate(2, 29, 2005)) {
        echo "<p>La fecha existe</p>";
    }else{
        echo "<p>La fecha no existe</p>";
    }

    // mktime(hora, minuto, segundo, mes, dia, anyo) 
    // dice los segundos desde esa fecha
    echo "<p>".mktime(0,0,0,4,27,2004)."</p>";
    echo "<p>".strtotime("2004/04/27")."</p>";
    echo "<p>".date("d", 1083016800)."</p>";

    echo "<p>".abs(-8)."</p>";
    echo "<p>".floor(9.67)."</p>";
    echo "<p>".ceil(9.67)."</p>";

    ?>
</body>
</html>