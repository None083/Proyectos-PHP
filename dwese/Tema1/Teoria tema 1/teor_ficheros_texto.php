<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Ficheros de Texto</title>
</head>

<body>
    <?php
    @$file = fopen("prueba.txt", "r");
    //abrir fichero, r lectura, w escritura, a añadir
    //w: si existe borra el contenido y empieza a escribir en la primera linea
    //si no existe crea un archivo nuevo
    //r+ lee y sirve para escribir también
    if (!$file) {
        die("<p>No se ha podido abrir el fichero 'prueba.txt'</p>");
    }

    while (!feof($file)) {
        $linea = fgets($file);
        echo "<p>" . $linea . "</p>";
    }

    echo "<h2>Fin del fichero</h2>";

    fseek($file, 0);

    echo "<h2>Vuelvo a recorrer el fichero</h2>";

    while (!feof($file)) {
        $linea = fgets($file);
        echo "<p>" . $linea . "</p>";
    }

    echo "<h2>Fin del fichero</h2>";

    fclose($file);

    @$file = fopen("prueba.txt", "a");
    if (!$file) {
        die("<p>No se ha podido abrir el fichero 'prueba.txt'</p>");
    }

    fputs($file, PHP_EOL . "Cuarta línea.");
    fwrite($file, PHP_EOL . "Quinta línea.");

    fclose($file);

    echo "<h2>Lectura de un fichero nuevo</h2>";

    $todo = file_get_contents("prueba.txt");

    echo "<pre>".$todo."</pre>";
    echo nl2br($todo);
    echo "<h3>Lectura de una web</h3>";
    $web = file_get_contents("https://www.google.es");
    echo nl2br($web);
    //file_exists("Tablas/".);

    //sudo chmod 777 -R '/opt/lampp/htdocs/Proyectos' permisos

    ?>
</body>

</html>