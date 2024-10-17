<?php
if (isset($_POST["enviar"])) {
    #compruebo errores formulario
    $error_extension_valida = $_FILES["texto"]["type"] == "txt/plain";
    $error_tamanio = !filesize($_FILES["texto"]["tmp_name"]) || $_FILES["texto"]["size"] > 25 * 1024 * 1024;

    $error_texto = $_FILES["texto"]["error"] || $error_extension_valida || $error_tamanio;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <form action="ejer4.php" method="post">
        <p>Seleccione un fichero de texto para contar sus palabras (Máx. 25MB):
            <input type="file" name="texto" id="texto" accept=".txt">
            <?php
            if (isset($_POST["contar"]) && $error_texto) {
                if ($_FILES["texto"]["name"] == "") {
                    echo "<span>Debes seleccionar un fichero</span>";
                } else if($_FILES["texto"]["error"]) {
                    echo "<span>Error en la subida del fichero al servidor</span>";
                } else if ($error_extension_valida) {
                    echo "<span>No has seleccionado un fichero de texto</span>";
                }else{
                    echo "<span>Has seleccionado un fichero mayor de 25MB</span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="contar">Contar palabras</button>
    </form>
    <?php
    if (isset($_POST["contar"]) && !$error_texto){
        $contenido_fichero = file_get_contents($_FILES["texto"]["tmp_name"]);
        $words = str_word_count($contenido_fichero);
        echo "<h3>El número de palabras del fichero seleccionado es de: ".$words.".</h3>";
    }
    ?>
</body>

</html>