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
        }
        td, th{
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
        $aux = 0;

        while (!feof($file)) {
            $linea = fgets($file);
            $array_linea = explode("\t", $linea);

            if ($aux == 0) {
                echo "<tr>";
                foreach ($array_linea as $cabecera) {
                    echo "<th>" . $cabecera . "</th>";
                }
                echo "</tr>";
                $aux = 1;
            } else {
                echo "<tr>";
                foreach ($array_linea as $indice => $dato) {
                    if ($indice == 0) {
                        echo "<td><strong>" . $dato . "</strong></td>";
                    } else {
                        echo "<td>" . $dato . "</td>";
                    }
                }
                echo "</tr>";
            }
        }

        echo "</table>";
        fclose($file);
    } else {
        echo "No se pudo abrir el archivo.";
    }
    ?>
</body>

</html>