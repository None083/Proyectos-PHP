<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría string</title>
    <style>
        
    </style>
</head>

<body>
    <?php
    //substr
    $texto1 = "Hola me llamo Juan";
    echo "<p>".$texto1[0]."</p>";
    echo "<p>".substr($texto1, 7, 2)."</p>";
    echo "<p>".substr($texto1, -3, 2)."</p>";
    echo "<p>".substr($texto1, 7)."</p>";
    echo "<p>".substr($texto1, -3)."</p>";

    //Longitud de un string
    echo "<p>La longitud del texto '" .$texto1. "' es: " .strlen($texto1)."</p>";
    
    //divide por un separador las palabras del string y crea un array
    $array = explode(" ", $texto1);
    print_r($array);

    



    ?>
</body>

</html>