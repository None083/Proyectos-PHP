<?php
echo "<h2>Borrado del usuario " . $_POST["id_usuario"] . "</h2>";
if (isset($detalle_usuario)) {
    echo "<p>¿Estás seguro de que quieres borrar al usuario <strong>".$detalle_usuario["nombre"]."</strong>?</p>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='hidden' name='nombre_foto_bd' value='".$detalle_usuario["foto"]."'/>";
    echo "<button type='submit' name='btnContBorrar' value='".$id_usuario."'>Continuar</button>";
    echo "<button type='submit'>Atrás</button>";
    echo "</form>";
}else{
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}
