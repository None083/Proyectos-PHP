<div id="contenedor-form">
    <h1>Quita acentos - Formulario</h1>
    <form action="index.php" method="post">
        <p>Escribe un texto y le quitaré los acentos.</p>
        <p>Texto:
            <?php
            if (isset($_POST["convertir"]) && $errores_form) {
                if ($error_string) {
                    echo "<span class='error'> Campo obligatorio </span>";
                } else if ($error_longitud_minima) {
                    echo "<span class='error'> Debe introducir al menos tres caracteres </span>";
                } else {
                    echo "<span class='error'> Debe introducir sólo letras </span>";
                }
            }
            ?>
        </p>
        <textarea name="string" id="string" cols="35" rows="5"><?php if (isset($_POST["string"])) echo $_POST["string"]; ?></textarea>
        <br>
        <button type="submit" name="convertir">Quitar acentos</button>
    </form>
</div>