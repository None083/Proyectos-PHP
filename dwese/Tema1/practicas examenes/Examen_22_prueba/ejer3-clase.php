<?php
/*
function mi_explode($separador, $texto){
    $palabra = "";
    $array = [];
    for ($i=0; $i < strlen($texto); $i++) { 
        if ($texto[$i] != $separador) {
            $palabra .= $texto[$i];
        }else{
            $array[] = $palabra;
            $palabra = "";
        }
    }
    $array[] = $palabra;
    return $array;
}
*/
function mi_explode($separador, $texto)
{
    $aux = [];
    $i = 0;
    $l_frase = strlen($texto);
    while ($i < $l_frase && $texto[$i] == $separador) {
        $i++;
    }
    if ($i < $l_frase) {
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($i = $i + 1; $i < $l_frase; $i++) {
            if ($texto[$i] != $separador) {
                $aux[$j] .= $texto[$i];
            }else{
                while ($i < $l_frase && $texto[$i] == $separador) {
                    $i++;
                }
                if ($i < $l_frase) {
                    $j++;
                    $aux[$j] = $texto[$i];
                }
            }
        }
    }
    return $aux;
}
if (isset($_POST["contar"])) {
    $error_form = $_POST["texto"] == "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer 2</title>
</head>

<body>
    <form action="ejer3-clase.php" method="post">
        <p>
            <label for="fichero">Elija un separador:</label>
            <select name="separador" id="separador">
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected" ?>>;</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected" ?>>:</option>
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected" ?>>,</option>
                <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected" ?>>espacio</option>
            </select>
        </p>
        <p>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
            <?php
            if (isset($_POST["subir"]) && $error_form) {
                echo "<span>Campo vacío</span>";
            }
            ?>
        </p>
        <button type="submit" name="contar">Contar</button>
    </form>
    <?php
    if (isset($_POST["contar"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        print_r(mi_explode($_POST["separador"], $_POST["texto"]));
    }
    ?>
</body>

</html>