<?php
function mi_explode($separador, $frase)
{
    $aux = [];
    $i = 0;
    $l_frase = strlen($frase);
    while ($i < $l_frase && $frase[$i] == $separador)
        $i++;


    if ($i < $l_frase) {
        $j = 0;
        $aux[$j] = $frase[$i];
        for ($i = $i + 1; $i < $l_frase; $i++) {
            if ($frase[$i] != $separador) {
                $aux[$j] .= $frase[$i];
            } else {
                while ($i < $l_frase && $frase[$i] == $separador)
                    $i++;

                if ($i < $l_frase) {
                    $j++;
                    $aux[$j] = $frase[$i];
                }
            }
        }
    }

    return $aux;
}

if (isset($_POST["codificar"])) {
    $error_texto = $_POST["texto"] == "";
    $error_depla = $_POST["despla"] == "" || $_POST["despla"] < 1 || $_POST["despla"] > 26;
    $error_archivo = $_FILES["archivo"]["error"] || $_FILES[""]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1.25 + 1024 * 1024;
    $error_form = $error_texto || $error_despla || $error_archivo;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejercicio3.php" method="post">
        <p>Introduzca un texto:
            <input type="text" name="texto" id="texto">
        </p>
        <p>Desplazamiento:
            <input type="text" name="despla" id="despla">
        </p>
        <p>Seleccione el archivo de claves:
            <input type="file" name="archivo" id="archivo">
        </p>
        <button type="submit" name="codificar">Codificar</button>
    </form>
    <?php
    if (isset($_POST["codificar"]) && !$error_form) {
        @$file = fopen($_FILES["archivo"]["tmp_name"], "r");
        if (!$file) {
            die("<p>No se ha podido abrir el archiovo</p>");
        }
        $primera_linea = fgets($file);

        while ($linea = fgets($file)) {
            $datos_linea = explode(";", rtrim($linea));
            $claves[$datos_linea[0]] = $datos_linea;
        }
        fclose($file);

        $texto = $_POST["texto"];
        $despla = $_POST["despla"] % 26;
        $respuesta = "";
        for ($i = 0; $i < strlen($texto); $i++) {
            if ($texto[$i] >= "A" && $texto[$i] <= "Z") {
                $respuesta .= $claves[$texto[$i]][$despla];
            } else {
                $respuesta .= $texto[$i];
            }
        }
        echo "<p>El texto introducido codificado sería: </br> </p>";
    }
    ?>
</body>

</html>