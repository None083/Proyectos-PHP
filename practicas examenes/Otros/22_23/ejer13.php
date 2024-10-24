<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer 1</title>
</head>

<body>
    <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
    <form action="ejer13.php" method="post">
        <button type="submit" name="generar" id="generar">Generar</button>
    </form>
    <?php
    if (isset($_POST["generar"])) {
        echo "<h2>Respuesta</h2>";
        @$file = fopen("claves_polybios.txt", "w");
        $primera_linea = "i/j;1;2;3;4;5\n";
        $letra = ord("A");
        fwrite($file, $primera_linea);

        for ($i = 1; $i <= 5; $i++) {
            fwrite($file, $i);
            for ($j = 1; $j <= 5; $j++) {
                if ($letra == ord("J")) {
                    $letra++;
                }
                fwrite($file, ";" . chr($letra));
                $letra++;
            }
            fwrite($file, "\n");
        }
        fclose($file);
    }
    ?>
</body>

</html>