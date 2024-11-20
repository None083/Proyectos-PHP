<?php
function mi_explode($texto, $separador)
{
    $array = [];
    $palabra = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] != $separador) {
            $palabra .= $texto[$i];
        } else if ($palabra != "") {
            $array[] = $palabra;
            $palabra = "";
        }
    }
    if ($palabra != "") {
        $array[] = $palabra;
        $palabra = "";
    }
    return $array;
}

function mi_is_numeric($caracter){
    if ($caracter >= 0 && $caracter <=9) {
        return true;
    }
    return false;
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
    <title>Ejercicio 3</title>
</head>

<body>
    <h1>Ejercicio 3</h1>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">
                Seleccione un fichero de texto plano para agregar al fichero aulas.txt (Máx. 500KB)
            </label>
            <input type="file" name="archivo" id="archivo" accept="text/plain">
            <?php
            if (isset($_POST["agregar"]) && $error_form) {
                if ($_FILES["archivo"]["type"] != "text/plain") {
                    echo "<span class='error'>Este tipo de archivo no está permitido</span>";
                } else if ($_FILES["archivo"]["size"] > 500 * 1024) {
                    echo "<span class='error'>El archivo no debe pesar más de 500KB</span>";
                }
            }
            ?>
        </P>
        <p>
            <button type="submit" name="agregar" id="argregar">Agregar</button>
            <button type="submit" name="cv" id="cv">Crear/Vaciar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["agregar"]) && !$error_form) {
        @$file = fopen("Aulas/aulas.txt", "a");
        if (!$file) {
            die("<p><strong>No se ha podido leer el fichero aulas.txt</strong></p>");
        }
        $array_file = mi_explode(file_get_contents("Aulas/aulas.txt"), ";");
        $array_archivo = mi_explode(file_get_contents($_FILES["archivo"]["tmp_name"]), ";");

        if ($array_file[0] != $array_archivo[0]) {
            $num_semana = 0;
            for ($i=0; $i < strlen($array_archivo[0]); $i++) { 
                if (mi_is_numeric($array_file[0][$i])) {
                    $num_semana = $array_file[0][$i];
                }
            }

            //Sé el numero de semana, ahora tendría que mirar donde colocar el nuevo archivo

            $archivo = file_get_contents($_FILES["archivo"]["tmp_name"]);
            for ($i = 0; $i < strlen($archivo); $i++) {
                fwrite($file, $archivo[$i]);

                if ($archivo[$i] == strlen($archivo) - 1) {
                    fwrite($file, "\n");
                }
            }
            fwrite($file, "\n\n");
        }

        echo "<h2>El fichero 'aulas.txt' tras esta operación tiene el siguiente contenido:</h2>";
        echo "<textarea cols='100' rows='20'>" . file_get_contents("Aulas/aulas.txt") . "</textarea>";

        fclose($file);
    }
    if (isset($_POST["cv"])) {
        @$file = fopen("Aulas/aulas.txt", "r");
        if (!$file) {
            @$file = fopen("Aulas/aulas.txt", "w");
        } else {
            @$file = fopen("Aulas/aulas.txt", "w");
            fwrite($file, "");
        }

        fclose($file);
    }
    ?>
</body>

</html>