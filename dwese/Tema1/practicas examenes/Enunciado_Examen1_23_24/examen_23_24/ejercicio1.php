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
    </form>
    <?php
    const NUM_LETRAS = 26;
    if (isset($_POST["generar"])) {

        echo "<h2>Respuesta</h2>";
        @$file = fopen("claves_cesar.txt", "w");
        if (!$file) {
            die("<p>No se ha podido abrir el fichero 'claves_cesar.txt'</p>");
        }
        $primera_linea = "Letra/Desplazamiento";
        for ($i = 0; $i <= NUM_LETRAS; $i++) {
            $primera_linea .= ";" . $i + 1;
        }
        fputs($file, $primera_linea . PHP_EOL);

        for ($i = ord("A"); $i <= ord("Z"); $i++) {
            $linea = chr($i);
            for ($j = 1; $j <= NUM_LETRAS; $j++) {
                if ($i + $j <= ord("Z")) {
                    $linea .= ";" . chr($i + $j);
                } else {
                    $linea .= ";" . chr(ord("A") - 1 + ($i + $j) - ord("Z"));
                }
            }
            fputs($file, $linea . PHP_EOL);
        }
        fclose($file);
        echo "<textarea>".file_get_contents("claves_cesar.txt")."</textarea>";
        echo "<p>Fichero generado con éxito</p>";
    }
    ?>
</body>

</html>