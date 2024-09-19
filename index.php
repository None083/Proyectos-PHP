<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primera Web PHP</title>
</head>
<body>
    <?php
        $texto1="Juan";
        $texto2="Maria";
        $a=8;
        $b=10;
        echo "<h1>Mi primera web</h1>";
        echo "<h2>Iniciar xampp</h2>";
        echo "<p>sudo /opt/lampp/lampp start</p>";
        echo "<p>".$texto1." y ".$texto2."</p>";
        echo "<p>El resultado de sumar ".$a." + ".$b." es igual a ".($a+$b)."</p>";
    ?>
</body>
</html>