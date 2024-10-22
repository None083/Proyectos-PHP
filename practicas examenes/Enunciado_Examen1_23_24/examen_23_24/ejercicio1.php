<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h1>Ejercicio 1. Genreador de "claves_cesar.txt"</h1>
    <form action="ejercicio1.php" method="post">
        <button type="submit" name="generar" id="generar">Generar</button>
        <?php
        echo "<h2>Respuesta</h2>";
        @$file = fopen("claves_cesar.txt", "w");
        if (!$file) {
            die("<p>No se ha podido abrir el fichero 'claves_cesar.txt'</p>");
        }
        $primera_linea = "Letra/Desplazamiento";
        const NUM_LETRAS = 26;
        for ($i=0; $i <= NUM_LETRAS; $i++) { 
            $primera_linea .= ";" . $i + 1;
        }
        

        fclose($file);
        ?>
    </form>
</body>
</html>