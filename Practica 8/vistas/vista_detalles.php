<?php
echo "<h2>Detalles del usuario " . $id_usuario . "</h2>";
if (isset($detalle_usuario)) {
    echo "<p>";
    echo "<strong>Foto: </strong></br><img src='Img/" . $detalle_usuario["foto"] . "' alt='Foto usuario' title='Foto usuario' width='200px' height='auto'><br/>";
    echo "<strong>Nombre: </strong>" . $detalle_usuario["nombre"] . "<br/>";
    echo "<strong>Usuario: </strong>" . $detalle_usuario["usuario"] . "<br/>";
    echo "<strong>Contraseña: </strong><br/>";
    echo "<strong>DNI: </strong>" . $detalle_usuario["dni"] . "<br/>";
    echo "<strong>Sexo: </strong>" . $detalle_usuario["sexo"] . "<br/>";
    echo "</p>";
}else{
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}