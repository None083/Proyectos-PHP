<?php
echo "<h2>Borrado del usuario " . $_POST["id_usuario"] . "</h2>";
if (mysqli_num_rows($detalle_usuario) > 0) {
    $tupla_detalles = mysqli_fetch_Assoc($detalle_usuario);
    echo "<p>¿Estás seguro de que quieres borrar al usuario <strong>".$tupla_detalles["nombre"]."</strong>?</p>";
    echo "<form action='index.php' method='post'>";
    echo "<button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
    echo "<button type='submit'>Atrás</button>";
    echo "</form>";
}
