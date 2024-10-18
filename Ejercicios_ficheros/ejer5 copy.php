<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th,
        tr {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        td,
        th {
            padding: 5px;
        }
    </style>
    <title>Ejercicio 5</title>
</head>

<body>
    <h1>Ejercicio 5</h1>
    <?php
    @$file = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if ($file) {
        echo "<table>";
        echo "<caption>PIB per cápita de los países de la Unión Europea</caption>";
        $linea = fgets($file);
        $datos_linea = explode("\t", $linea);
        $n_col = count($datos_linea);
        echo "<tr>";
        for ($i = 0; $i < $n_col; $i++) {
            echo "<th>" . $datos_linea[$i] . "</th>";
        }
        echo "</tr>";
        while ($linea = fgets($file)) {
            $datos_linea = explode("\t", $linea);
            echo "<tr>";
            echo "<th>" . $datos_linea[0] . "</th>";
            for ($i = 1; $i < $n_col; $i++) {
                if (isset($datos_linea[$i])) {
                    echo "<td>" . $datos_linea[$i] . "</td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($file);
    } else {
        die("No se pudo abrir el archivo.");
    }
    ?>
</body>

</html>