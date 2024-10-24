<?php
function mi_explode($texto, $delimitador)
{
    $array = [];
    $palabra = "";

    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] != $delimitador) {
            $palabra .= $texto[$i];
        } else if (!empty($palabra)) {
            $array[] = $palabra;
            $palabra = "";
        }
    }
    if (!empty($palabra)) {
        $array[] = $palabra;
    }
    return $array;
}
if (isset($_POST["contar"])) {
    $error_vacio = $_POST["texto"] == "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Ejercicio 2. Longitud de las palabras extraídas</h1>
    <form action="Ejer2.php" method="post">
        <p>Introduzca un texto:
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"]; ?>">
            <?php
            if (isset($_POST["contar"]) && $error_vacio) {
                echo "<span>Campo vacío</span>";
            }
            ?>
        </p>
        <p>Elija el separador:
            <select name="separador" id="separador">
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected"; ?>>Coma (,)</option>
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected"; ?>>Punto y coma (;)</option>
                <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected"; ?>>Espacio ( )</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected"; ?>>Dos puntos (:)</option>
            </select>
        </p>
        <button type="submit" name="contar" id="contar">Contar</button>
    </form>
    <?php
    if (isset($_POST["contar"]) && !$error_vacio) {
        echo "<h2>Respuesta</h2>";
        $array_palabras = mi_explode($_POST["texto"], $_POST["separador"]);
        echo "<ol>";
        for ($i = 0; $i < count($array_palabras); $i++) {
            echo "<li> " . $array_palabras[$i] . " ( " . strlen($array_palabras[$i]) . " )</li>";
        }
        echo "</ol>";
    }
    ?>
</body>

</html>