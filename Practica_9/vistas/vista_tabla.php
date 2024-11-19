<?php
echo "<h3>Listado de los usuarios</h3>";
echo "<table>";
echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button type='submit' name='btnCrear' class='enlace' title='Crear usuario' alt='Crear usuario'><strong>Usuario+</strong></button></form></th></tr>";
while ($tupla = mysqli_fetch_assoc($datos_usuario)) {
    echo "<tr>";
    echo "<td>" . $tupla["id_usuario"] . "</td>";
    echo "<td><form action='index.php' method='post'><img src='Img/" . $tupla["foto"] . "' alt='Foto usuario' title='Foto Usuario' width='100px' height='auto'></form></td>";
    echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnDetalles' title='Ver detalles' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</form></td>";
    echo "<td>
    <form action='index.php' method='post'>
    <input name='id_usuario' type='hidden' value='" . $tupla["id_usuario"]."'>
    <button type='submit' class='enlace' name='btnBorrar' title='Borrar usuario' alt='Borrar usuario'>Borrar</button> - 
    <button type='submit' class='enlace' name='btnEditar' title='Editar usuario' alt='Editar usuario'>Editar</button>
    </form>
    </td>";
    echo "</tr>";
}
echo "</table>";
