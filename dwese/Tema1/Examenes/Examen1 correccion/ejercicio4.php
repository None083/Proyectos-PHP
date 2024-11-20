<?php
function esta($linea_buscar, $fd)
{
    $respuesta = false;
    while ($linea = fgets($fd)) {
        if ($linea_buscar == $linea) {
            $respuesta = true;
        }
    }
    return $respuesta;
}
if (isset($_POST["agregar"])) {
    $error_form = $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 500 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }
    </style>
    <title>Ejercicio 4</title>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    if (isset($_POST["agregar"]) && !$error_form) {
        @$file = fopen("Aulas/aulas.txt", "r");

        if (!$file) {
            die("<p><strong>No se ha podido leer el fichero aulas.txt</strong></p>");
        }
        @$file2 = fopen($_FILES["archivo"]["tmp_name"], "r");
        $linea2 = fgets($file2);
        fclose($file2);

        $respuesta = "";
        $insertado = false;
        while ($linea1 = fgets($file)) {
            if ($linea2[6] <= $linea1[6] && !$insertado) {
                if ($linea1[6] < $linea2[6]) {
                    $respuesta .= file_get_contents($_FILES["archivo"]["tmp_name"]) . PHP_EOL;
                }
                $insertado = true;
            }
            $respuesta .= $linea1;
            for ($k = 1; $k <= 5; $k++) {
                $respuesta .= fgets($file);
            }
        }

        if (!$insertado) {
            $respuesta .= file_get_contents($_FILES["archivo"]["tmp_name"]) . PHP_EOL;
        }

        file_put_contents("Aulas/aulas.txt", $respuesta);

        echo "<h2>El fichero 'aulas.txt' tras esta operación tiene el siguiente contenido:</h2>";
        echo "<textarea cols='100' rows='20'>" . file_get_contents("Aulas/aulas.txt") . "</textarea>";

        fclose($file);
    }
    if (isset($_POST["cv"])) {
        @$file = fopen("Aulas/aulas.txt", "w");
        if (!$file) {
            echo "<h2>No tienes permisos en el servidor para crear <em>aulas.txt</em></h2>";
        } else {
            echo "<h2>Se ha creado con éxito el archivo <em>aulas.txt</em></h2>";
        }

        fclose($file);
    }
    ?>
</body>

</html>