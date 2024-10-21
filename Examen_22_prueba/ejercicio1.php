<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer 1</title>
</head>

<body>
    <form action="ejer1.php" method="post">
        <p>Cuenta los caracteres del texto introducido:</p>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"] ?>">
        <button type="submit" name="contar">Contar</button>
    </form>
    <?php
    if (isset($_POST["contar"])) {
        $texto = $_POST["texto"];
        function mi_strlen($texto)
        {
            $cont = 0;
            while (isset($texto[$cont])) {
                $cont++;
            }
            return $cont;
        }
        echo "<p>El texto tiene " .mi_strlen($texto). " caracteres</p>";
    }
    
    ?>
</body>

</html>