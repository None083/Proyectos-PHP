<?php
echo "<h2>Detalles del usuario " . $_POST["btnDetalles"] . "</h2>";
if (mysqli_num_rows($detalle_usuario) > 0) {
    $tupla_detalles = mysqli_fetch_assoc($detalle_usuario);
    echo "<p>";
    echo "<strong>Foto: </strong></br><img src='Img/" . $tupla_detalles["foto"] . "' alt='Foto usuario' title='Foto usuario' width='200px' height='auto'><br/>";
    echo "<strong>Nombre: </strong>" . $tupla_detalles["nombre"] . "<br/>";
    echo "<strong>Usuario: </strong>" . $tupla_detalles["usuario"] . "<br/>";
    echo "<strong>Contraseña: </strong><br/>";
    echo "<strong>DNI: </strong>" . $tupla_detalles["dni"] . "<br/>";
    echo "<strong>Sexo: </strong>" . $tupla_detalles["sexo"] . "<br/>";
    echo "</p>";
}else{
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}

mysqli_free_result($detalle_usuario);