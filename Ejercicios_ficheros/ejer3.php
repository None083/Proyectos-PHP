<?php
if (isset($_POST["mostrar"])) {

    $numero1 = $_POST["numero1"];
    $numero2 = $_POST["numero2"];

    $error_vacio1 = $numero1 == "";
    $error_es_numero1 = !is_numeric($numero1);
    $error_num_valido1 = $numero1 < 1 || $numero1 > 10;
    $error_tabla_existe = !file_exists("Tablas/tabla_" . $numero1 . ".txt");
    $error_vacio2 = $numero2 == "";
    $error_es_numero2 = !is_numeric($numero2);
    $error_num_valido2 = $numero2 < 1 || $numero2 > 10;

    $errores_form = $error_vacio1 || $error_es_numero1 || $error_num_valido1 || $error_tabla_existe;
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
    <form action="ejer3.php" method="post">
        <p>Escoge una tabla de multiplicar:
            <input type="text" name="numero1" id="numero1">
            <?php
            if (isset($_POST["mostrar"]) && $errores_form) {
                if ($error_vacio1) {
                    echo "<span class='error'> * Campo vacío * </span>";
                } else if ($error_es_numero1) {
                    echo "<span class='error'> * Debe escribir un número * </span>";
                } else if ($error_num_valido1) {
                    echo "<span class='error'> * El número debe estar entre el 1 y 10 inclusives * </span>";
                } else if ($error_tabla_existe) {
                    echo "<span class='error'> * La tabla no existe, prueba con otro número * </span>";
                }
            }
            ?>
        </p>
        <p>Escoge un número para mostrar su multiplicación:
            <input type="text" name="numero2" id="numero2">
            <?php
            if (isset($_POST["mostrar"]) && $errores_form) {
                if ($error_vacio2) {
                    echo "<span class='error'> * Campo vacío * </span>";
                } else if ($error_es_numero2) {
                    echo "<span class='error'> * Debe escribir un número * </span>";
                } else if ($error_num_valido2) {
                    echo "<span class='error'> * El número debe estar entre el 0 y 10 inclusives * </span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="mostrar">Mostrar multiplicación</button>
    </form>
    <?php
    if (isset($_POST["mostrar"])) {
        $numero1 = $_POST["numero1"];
        $numero2 = $_POST["numero2"];

        if (file_exists("Tablas/tabla_" . $numero1 . ".txt")) {
            @$file = fopen("Tablas/tabla_" . $numero1 . ".txt", "r");
            while (!feof($file)) {
                $linea = fgets($file);
                $array = explode(" ", $linea);

                if ($array[2] == $numero2) {
                    echo "<p><strong>" . $linea . "</strong></p>";
                    break;
                }
            }
            fclose($file);
        }
    }
    ?>
</body>

</html>