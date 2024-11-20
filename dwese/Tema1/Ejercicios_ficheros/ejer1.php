<?php
if (isset($_POST["crear"])) {

    $numero = $_POST["numero"];

    $error_vacio = $numero == "";
    $error_es_numero = !is_numeric($numero);
    $error_num_valido = $numero < 1 || $numero > 10;
    $error_tabla_existe = file_exists("Tablas/tabla_" . $numero . ".txt");

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
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejer1.php" method="post">
        <p>Crea una tabla de multiplicar:
            <input type="text" name="numero" id="numero">
            <?php
            if (isset($_POST["crear"]) && $errores_form) {
                if ($error_vacio) {
                    echo "<span class='error'> * Campo vacío * </span>";
                } else if ($error_es_numero) {
                    echo "<span class='error'> * Debe escribir un número * </span>";
                } else if ($error_num_valido) {
                    echo "<span class='error'> * El número debe estar entre el 1 y 10 inclusives * </span>";
                } else {
                    echo "<span class='error'> * La tabla ya existe, prueba con otro número * </span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="crear">Crear tabla</button>
    </form>
    <?php
    if (isset($_POST["crear"])) {
        $numero = (int)$_POST["numero"];

        if (!file_exists("Tablas/tabla_" . $numero . ".txt")) {
            @$file = fopen("Tablas/tabla_" . $numero . ".txt", "w");
            for ($i = 0; $i <= 10; $i++) {
                
                if ($i == 0) {
                    fwrite($file, $numero . " x " . $i . " = " . $numero * $i);
                } else {
                    fwrite($file, PHP_EOL . $numero . " x " . $i . " = " . $numero * $i);
                }
            }
            fclose($file);
            echo "<p><strong>Tabla del " . $numero . " creada con éxito.</strong></p>";
        }
    }
    ?>
</body>

</html>