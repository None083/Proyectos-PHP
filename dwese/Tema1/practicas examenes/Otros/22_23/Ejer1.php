<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
    <form action="Ejer1.php" method="post">
        <button type="submit" name="generar" id="generar">Generar</button>
        <?php
        if (isset($_POST["generar"])) {
            $nombre_fichero = "claves_polybios.txt";
            // Abrir el archivo para escritura
            $file = fopen($nombre_fichero, "w");

            // Escribir la primera línea fija en el archivo (cabecera)
            fwrite($file, "i/j;1;2;3;4;5\n");

            // Obtener el valor ASCII de la letra 'A'
            $letra_ascii = ord('A');
            $cont_letras = 0;

            // Generar la matriz 5x5 con números en las filas
            for ($i = 1; $i <= 5; $i++) {
                fwrite($file, $i . ";"); // Escribir el número de la fila seguido por ';'

                for ($j = 1; $j <= 5; $j++) {
                    $letra_actual = chr($letra_ascii + $cont_letras);
                    // Saltar la letra 'J', que debe omitirse
                    if ($letra_actual == 'J') {
                        $cont_letras++;
                        $letra_actual = chr($letra_ascii + $cont_letras); // Pasamos a 'K'
                    }

                    // Escribir la letra correspondiente
                    fwrite($file, $letra_actual);

                    // Evitar añadir el ';' al final de la fila
                    if ($j < 5) {
                        fwrite($file, ";");
                    }

                    // Avanzar a la siguiente letra del alfabeto
                    $cont_letras++;
                }
                fwrite($file, "\n"); // Nueva línea al final de cada fila
            }

            // Cerrar el archivo
            fclose($file);

            // Leer el contenido del archivo y mostrarlo en el textarea
            echo "<h2>Respuesta</h2>";
            echo "<textarea rows='7' cols='20'>";
            echo file_get_contents($nombre_fichero); // Leer el archivo y mostrarlo en el textarea
            echo "</textarea>";
        }
        ?>
    </form>
</body>

</html>