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

        td,
        th {
            padding: 5px;
        }

        button {
            margin-bottom: 1rem;
        }
    </style>
    <title>Ejercicio - Mostrar PIB por país</title>
</head>

<body>
    <h1>Mostrar PIB per cápita por país</h1>
    
    <?php
    // Abrir el archivo
    @$file = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$file) {
        die("No se pudo abrir el archivo.");
    }

    // Leer la primera línea (cabecera con los años)
    $linea = fgets($file);
    $datos_primera_linea = explode("\t", trim($linea)); // Usar trim para eliminar posibles saltos de línea

    // Almacenar todos los países y sus datos en un array
    $paises = [];
    while ($linea = fgets($file)) {
        $paises[] = explode("\t", trim($linea)); // Guardar cada país y sus datos
    }

    // Cerrar el archivo
    fclose($file);
    ?>

    <!-- Formulario con select para escoger el país -->
    <form action="ejer6 copy.php" method="post">
        <p>Escoge un país para mostrar su PIB per cápita:
            <select name="pais" id="pais">
                <?php
                foreach ($paises as $index => $datos_pais) {
                    // Extraer el nombre del país
                    $datos_primera_columna = explode(",", $datos_pais[0]);
                    $nombre_pais = trim(end($datos_primera_columna)); // Obtener el nombre del país
                    // Verificar si el país fue seleccionado
                    if (isset($_POST["pais"]) && $_POST["pais"] == $index) {
                        echo "<option selected value='$index'>$nombre_pais</option>";
                    } else {
                        echo "<option value='$index'>$nombre_pais</option>";
                    }
                }
                ?>
            </select>
        </p>
        <button type="submit" name="mostrar">Mostrar PIB</button>
    </form>

    <?php
    if (isset($_POST["mostrar"])) {
        $pais_seleccionado = $_POST["pais"]; // Obtener el índice del país seleccionado

        // Obtener los datos del país seleccionado desde el array almacenado
        if (isset($paises[$pais_seleccionado])) {
            $datos_pais_seleccionado = $paises[$pais_seleccionado];
            $datos_primera_columna = explode(",", $datos_pais_seleccionado[0]);
            $nombre_pais = trim(end($datos_primera_columna)); // Nombre del país seleccionado

            echo "<h2>PIB per cápita de $nombre_pais</h2>";
            echo "<table>";
            echo "<tr>";
            // Mostrar los años (cabecera)
            for ($i = 1; $i < count($datos_primera_linea); $i++) {
                echo "<th>" . $datos_primera_linea[$i] . "</th>";
            }
            echo "</tr>";
            
            // Mostrar los datos del PIB per cápita para cada año
            echo "<tr>";
            for ($i = 1; $i < count($datos_primera_linea); $i++) {
                echo "<td>" . (isset($datos_pais_seleccionado[$i]) ? $datos_pais_seleccionado[$i] : "N/A") . "</td>";
            }
            echo "</tr>";
            echo "</table>";
        } else {
            echo "<p>No se encontraron datos para el país seleccionado.</p>";
        }
    }
    ?>

</body>

</html>
