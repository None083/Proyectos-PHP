<div id="contenedor-form">
<h1>Ripios - Formulario</h1>
<form action="index.php" method="post">
    <p>Dime dos palabras y te diré si riman o no.</p>
    <p>Primera palabra: <input type="text" name="primera" id="primera" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
    <?php
    if (isset($_POST["comparar"]) && $error_primera) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    if (isset($_POST["comparar"]) && $error_longitud_minima_primera ){
        echo "<span class='error'> Debes introducir al menos tres letras </span>";
    }
    if (isset($_POST["comparar"]) && $error_todo_letras_primera ){
        echo "<span class='error'> Solo está permitido escribir letras </span>";
    }
    ?>
    </p>
    <p>Segunda palabra: <input type="text" name="segunda" id="segunda" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"]; ?>">
    <?php
    if (isset($_POST["comparar"]) && $error_segunda) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    if (isset($_POST["comparar"]) && $error_longitud_minima_segunda ){
        echo "<span class='error'> Debes introducir al menos tres letras </span>";
    }
    if (isset($_POST["comparar"]) && $error_todo_letras_segunda ){
        echo "<span class='error'> Solo está permitido escribir letras </span>";
    }
    ?>
    </p>
    <button type="submit" name="comparar">Comparar</button>
</form>
</div>