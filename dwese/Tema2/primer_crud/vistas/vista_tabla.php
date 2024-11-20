<?php
echo "<table>";
    echo "<tr>
        <th>Nombre de Usuario</th>
        <th>Borrar</th>
        <th>Editar</th>
    </tr>";

    while ($tupla = mysqli_fetch_assoc($datos_usuario)) {
    echo "<tr>";
        echo "<td>
            <form action='index.php' method='post'><button class='enlace' title='Ver detalles' type='submit' name='btnDetalles' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</form>
        </td>";
        echo "<td>
            <form action='index.php' method='post'><button class='btn_imagen' type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button></form>
        </td>";
        echo "<td><form action='index.php' method='post'><button class='btn_editar' type='submit' name='btnEditar' value='" . $tupla["id_usuario"] . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "<tr>
        <td colspan='3'>
            <form action='index.php' method='post'><button type='submit' class='btn_agregar' name='btnAgregar'>Agregar usuario</button></form>
        </td>
    </tr>";

echo "</table>";
mysqli_free_result($datos_usuario);
?>