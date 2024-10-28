<?php
function mi_is_numeric($caracter)
{
    if ($caracter >= "0" && $caracter <= "9") {
        return true;
    }
    return false;
}
if (isset($_POST["decod"])) {
    $error_texto = $_POST["texto"] == "";
    $error_file = $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1.25 * 1024 * 1024;
    $error_form = $error_texto || $error_file;
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
    <h1>Ejercicio 3. Decodifica una frase</h1>
    <form action="Ejer3.php" method="post" enctype="multipart/form-data">
        <p>Introduzca un texto:
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"]; ?>">
            <?php
            if (isset($_POST["decod"]) && $error_texto) {
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>Seleccione el archivo de claves (.txt y menor 1,25MB):
            <input type="file" name="archivo" id="archivo" accept="text/plain">
            <?php
            if (isset($_POST["decod"]) && $error_file) {
                echo "<span class='error'>Error con el archivo</span>";
            }
            ?>
        </p>
        <button type="submit" name="decod" id="decod">Decodificar</button>
    </form>
    <?php
    if (isset($_POST["decod"]) && !$error_form) {
        @$file = fopen("claves_polybios.txt", "r");
        $texto = $_POST["texto"];
        $texto_final = "";
        $i = 0;
        while (!feof($file)) {
            $array[] = fgets($file);
        }
        while (isset($texto[$i])) {
            if (mi_is_numeric($texto[$i]) && mi_is_numeric($texto[$i + 1])) {
                if ($texto[$i] == "0" && $texto[$i + 1] == "0") {
                    $texto_final .= "J";
                } else {
                    $linea = ord($texto[$i]) - ord("0"); //también sirve restar 48
                    $caracter = ord($texto[$i + 1]) - ord("0");
                    $array_linea = explode(";", $array[$linea]);
                    $texto_final .= $array_linea[$caracter][0];
                }
                $i++;
            } else {
                $texto_final .= $texto[$i];
            }
            $i++;
        }
        echo $texto_final;
        fclose($file);
    }
    ?>
</body>

</html>