<div id="contenedor-form">
    <h1>Frases palíndromas - Formulario</h1>
    <form action="index.php" method="post">
        <p>Dime una frase y te diré si es una frase palíndroma.</p>
        <p>Frase: <input type="text" name="string" id="string" value="<?php if (isset($_POST["string"])) echo $_POST["string"]; ?>">
            <?php
            if (isset($_POST["comprobar"]) && $errores_form) {
                if ($error_string) {
                    echo "<span class='error'> Campo obligatorio </span>";
                } else if ($error_longitud_minima) {
                    echo "<span class='error'> Debe introducir al menos tres letras </span>";
                } else {
                    echo "<span class='error'> Debe introducir sólo letras </span>";
                }
            }
            ?>
        </p>
        </p>
        <button type="submit" name="comprobar">Comprobar</button>
    </form>
</div>