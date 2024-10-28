<form action="ejercicio4.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="archivo">
            Seleccione un fichero de texto plano para agregar al fichero aulas.txt (Máx. 500KB)
        </label>
        <input type="file" name="archivo" id="archivo" accept="text/plain">
        <?php
        if (isset($_POST["subir"]) && $error_form) {
            if ($_FILES["archivo"]["name"] == "") {
                echo "<span class='error'>No has selccionado ningún archivo</span>";
            } else if ($_FILES["archivo"]["error"]) {
                echo "<span class='error'>Error en la suvida del fichero al servidor</span>";
            } else if ($_FILES["archivo"]["type"] != "text/plain") {
                echo "<span class='error'>Este tipo de archivo no está permitido</span>";
            } else if ($_FILES["archivo"]["size"] > 500 * 1024) {
                echo "<span class='error'>El archivo no debe pesar más de 500KB</span>";
            }
        }
        ?>
    </P>
    <p>
        <button type="submit" name="subir" id="subir">Subir</button>
    </p>
</form>