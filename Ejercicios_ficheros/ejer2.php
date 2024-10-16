<?php
if (isset($_POST["mostrar"])) {

    $numero = $_POST["numero"];

    $error_vacio = $numero == "";
    $error_es_numero = !is_numeric($numero);
    $error_num_valido = $numero < 1 || $numero > 10;
    $error_tabla_existe = !file_exists("Tablas/tabla_" . $numero . ".txt");

    $errores_form = $error_vacio || $error_es_numero || $error_num_valido || $error_tabla_existe;
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
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejer2.php" method="post">
        <p>Muestra una tabla de multiplicar:
            <input type="text" name="numero" id="numero">
            <?php
            if (isset($_POST["mostrar"]) && $errores_form) {
                if ($error_vacio) {
                    echo "<span class='error'> * Campo vacío * </span>";
                } else if ($error_es_numero) {
                    echo "<span class='error'> * Debe escribir un número * </span>";
                } else if ($error_num_valido) {
                    echo "<span class='error'> * El número debe estar entre el 1 y 10 inclusives * </span>";
                } else {
                    echo "<span class='error'> * La tabla no existe, prueba con otro número * </span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="mostrar">Mostrar tabla</button>
    </form>
    <?php
    if (isset($_POST["mostrar"])) {
        $numero = (int)$_POST["numero"];

        if (file_exists("Tablas/tabla_" . $numero . ".txt")) {
            @$file = fopen("Tablas/tabla_" . $numero . ".txt", "r");
            while (!feof($file)) {
                $linea = fgets($file);
                echo "<p>" . $linea . "</p>";
            }
            fclose($file);
        }
    }
    ?>
</body>

</html>