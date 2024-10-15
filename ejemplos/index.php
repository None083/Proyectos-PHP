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
        
        if (isset($p)){
            $c=$p+$a;
        }else{
            $c=$a;
        }
        echo "<p>".$c."</p>"; # va a dar error, pero aun asi muestra la operacion dandole un 0 a la variable sin declarar

        switch ($variable) {
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }
        if ($a+$b>10) {
            echo "<p>La suma de a + b es mayor que 10</p>";
        }else{
            echo "<p>La suma de a + b no es mayor que 10</p>";
        }

        for ($i=0; $i < 5; $i++) { 
            echo "<p>".$i."</p>";
        }
        echo "<p>Despues de bucle for la i vale ".$i."</p>";
        $i=0;
        while ($i >5) {
            echo "<p>".$i."</p>";
        }
    ?>
</body>
</html>