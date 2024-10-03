<div id="contenedor-form">
    <h1>Romanos a árabes - Formulario</h1>
    <form action="index.php" method="post">
        <p>Dime un número en numeros romanos y lo convertiré en cifras árabes.</p>
        <p>Número: <input type="text" name="string" id="string" value="<?php if (isset($_POST["string"])) echo $_POST["string"]; ?>">
            <?php
            if (isset($_POST["convertir"]) && $errores_form) {
                if ($error_string) {
                    echo "<span class='error'> Campo obligatorio </span>";
                } else if ($error_longitud_minima) {
                    echo "<span class='error'> Debe introducir al menos tres caracteres </span>";
                } else {
                    echo "<span class='error'> Debe introducir sólo números romanos </span>";
                }
            }
            ?>
        </p>
        </p>
        <button type="submit" name="convertir">Convertir</button>
    </form>
</div>