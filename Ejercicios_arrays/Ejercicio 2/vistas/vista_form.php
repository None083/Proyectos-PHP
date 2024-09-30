<div id="contenedor-form">
<h1>Palíndromos / capicuas - Formulario</h1>
<form action="Ejer1.php" method="post">
    <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
    <p>Palabra o número: <input type="text" name="string" id="string" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
    <?php
    if (isset($_POST["comprobar"]) && $error_string) {
        echo "<span class='error'> Campo obligatorio </span>";
    }
    if (isset($_POST["comprobar"]) && $error_longitud_minima){
        echo "<span class='error'> Debes introducir al menos tres letras </span>";
    }
    ?>
    </p>
    </p>
    <button type="submit" name="comprobar">Comprobar</button>
</form>
</div>