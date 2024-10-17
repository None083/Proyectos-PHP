/* 5. // Realizar una web que abra el fichero con información sobre el PIB per cápita
        // de los países de la Unión Europea y muestre todo el contenido en una tabla, (
        // url: http://dwese.icarosproject.com/PHP/datos_ficheros.txt).
        // NOTA: Los datos del fichero datos_ficheros.txt vienen separados por un
        // tabulador (“\t”) */
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <title>Ejercicio 5</title>
</head>
<body>
    <h1>Ejercicio 5</h1>
    <?php
    @$file = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    while (!feof($file)) {
        $linea = fgets($file);
        echo "<p>" . $linea . "</p>";
    }
    fclose($file);
    ?>
</body>
</html>