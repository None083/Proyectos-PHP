<div id="contenedor-form">
    <h1>Palíndromos / capicuas - Formulario</h1>
    <form action="index.php" method="post">
        <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
        <p>Palabra o número: <input type="text" name="string" id="string" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
            <?php
            if (isset($_POST["comprobar"]) && $errores_form) {
                if ($error_string) {
                    echo "<span class='error'> Campo obligatorio </span>";
                } else if ($error_longitud_minima) {
                    echo "<span class='error'> Debe introducir al menos tres letras </span>";
                } else {
                    echo "<span class='error'> Debe introducir sólo números o sólo letras </span>";
                }
            }
            ?>
        </p>
        </p>
        <button type="submit" name="comprobar">Comprobar</button>
    </form>
</div>