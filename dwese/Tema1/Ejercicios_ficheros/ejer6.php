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
        button{
            margin-bottom: 1rem;
        }
    </style>
    <title>Ejercicio 6</title>
</head>

<body>
    <h1>Ejercicio 6</h1>
    <form action="ejer6.php" method="post">
        <p>Escoge un país para mostrar su PIB per cápita:
            <select name="pais" id="pais">
                <?php
                @$file = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
                if ($file) {
                    while (!feof($file)) {
                        $linea = trim(fgets($file)); //elimino espacios y saltos de línea

                        if (!empty($linea)) {
                            $array = explode("\t", $linea);
                            $linea_pais = str_replace("_", ",", $array[0]); //cambio los guiones bajos por comas
                            $array_pais = explode(",", $linea_pais);

                            if (isset($array_pais[4])) {
                                echo "<option value='" . $array_pais[4] . "'>" . $array_pais[4] . "</option>";
                            }
                        }
                    }
                    fclose($file);
                } else {
                    echo "No se pudo abrir el archivo.";
                }
                ?>
            </select>
        </p>
        <button type="submit" name="mostrar">Mostrar PIB</button>
    </form>
    <?php
    if (isset($_POST["mostrar"])) {
        $pais_seleccionado = $_POST["pais"];

        @$file = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
        if ($file) {
            echo "<table>";

            $cabecera = fgets($file);
            if (!empty($cabecera)) {
                $array_cabecera = explode("\t", trim($cabecera));
                echo "<tr>";
                foreach ($array_cabecera as $columna) {
                    echo "<th>" . htmlspecialchars($columna) . "</th>";
                }
                echo "</tr>";
            }

            while (!feof($file)) {
                $linea = trim(fgets($file));

                if (!empty($linea)) {
                    $array_linea = explode("\t", $linea);
                    $linea_pais = str_replace("_", ",", $array_linea[0]);
                    $array_pais = explode(",", $linea_pais);

                    if (isset($array_pais[4]) && $array_pais[4] == $pais_seleccionado) {
                        echo "<tr>";
                        foreach ($array_linea as $indice => $dato) {
                            echo "<td>" . htmlspecialchars($dato) . "</td>";
                        }
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
            fclose($file);
        } else {
            echo "No se pudo abrir el archivo.";
        }
    }
    ?>
</body>

</html>