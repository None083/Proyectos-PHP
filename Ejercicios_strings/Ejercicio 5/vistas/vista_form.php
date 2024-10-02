<div id="contenedor-form">
    <h1>Árabes a romanos - Formulario</h1>
    <form action="index.php" method="post">
        <p>Dime un número y lo convertiré en números romanos.</p>
        <p>Número: <input type="text" name="string" id="string" value="<?php if (isset($_POST["string"])) echo $_POST["string"]; ?>">
            <?php
            if (isset($_POST["convertir"]) && $errores_form) {
                if ($error_string) {
                    echo "<span class='error'> Campo obligatorio </span>";
                } else if ($error_longitud_minima) {
                    echo "<span class='error'> Debe introducir al menos tres caracteres </span>";
                } else if($error_todo_num){
                    echo "<span class='error'> Debe introducir sólo números </span>";
                }else{
                    echo "<span class='error'> El número no debe ser mayor de 5000 </span>";
                }
            }
            ?>
        </p>
        </p>
        <button type="submit" name="convertir">Convertir</button>
    </form>
</div>