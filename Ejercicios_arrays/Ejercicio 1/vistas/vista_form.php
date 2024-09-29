<div id="contenedor-form">
<h1>Ripios - Formulario</h1>
<form action="Ejer1.php" method="post">
    <p>Dime dos palabras y te diré si riman o no.</p>
    <p>Primera palabra: <input type="text" name="primera" id="primera" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"]; ?>">
    <?php
    if (isset($_POST["comparar"]) && $error_primera) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    ?>
    </p>
    <p>Segunda palabra: <input type="text" name="segunda" id="segunda" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"]; ?>">
    <?php
    if (isset($_POST["comparar"]) && $error_segunda) {
        echo "<span class='error'> * Campo obligatorio * </span>";
    }
    ?>
    </p>
    <button type="submit" name="comparar">Comparar</button>
</form>
</div>