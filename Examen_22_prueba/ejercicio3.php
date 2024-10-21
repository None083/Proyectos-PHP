<?php
if (isset($_POST["contar"])) {
    $texto = $_POST["texto"];
    $error_vacio = $texto == "";
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
    <form action="ejercicio3.php" method="post">
        <p>Escribe un texto utilizando uno de los separadores indicados abajo:
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST['texto'])) echo $_POST['texto'] ?>">
            <?php
            if (isset($_POST["contar"]) && $error_vacio) {
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>Indica el separador utilizado para poder contar las palabras:
            <select name="separador" id="separador">
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected" ?>>Coma (,)</option>
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected" ?>>Punto y coma (;)</option>
                <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected" ?>>Espacio ( )</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected" ?>>Dos puntos (:)</option>
            </select>
        </p>
        <input type="submit" value="Contar palabras" name="contar">
    </form>
    <?php
    if (isset($_POST["contar"]) && !$error_vacio) {
        $separador = $_POST["separador"];
        $array = [];
        $palabra = "";
        $cont = 0;
        for ($i = 0; $i < strlen($texto); $i++) {
            if ($texto[$i] != $separador) {
                $palabra .= $texto[$i];
            } else {
                if (isset($palabra[0])) {
                    $array[] = $palabra;
                    $palabra = "";
                    $cont++;
                }
            }
        }
        if (isset($palabra[0])) {
            $array[] = $palabra;
            $cont++;
        }
        
        //var_dump($array);
        echo "<p><strong>El texto contiene ".$cont." palabras.</strong></p>";
    }
    ?>
</body>

</html>