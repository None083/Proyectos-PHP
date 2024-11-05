<?php
const SERVIDOR_BD = "localhost";
const USUARIO_BD = "jose";
const CLAVE_BD = "josefa";
const NOMBRE_BD = "bd_foro";

function error_page($title, $body)
{
    return '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>
</head>
<body>' . $body . '</body>
</html>';
}


try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die(error_page("Primer CRUD", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}

if (isset($_POST["btnDetalles"])) {
    try {
        $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalles"] . "'";
        $detalle_usuario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnBorrar"])) {
    try {
        $consulta = "select * from usuarios where id_usuario='" . $_POST["btnBorrar"] . "'";
        $detalle_usuario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

try {
    $consulta = "select * from usuarios";
    $datos_usuario = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    mysqli_close($conexion);
    die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}


mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .btn_imagen {
            border: none;
            background: none;
            cursor: pointer;
            color: red;
            font-weight: bold;
        }

        .volver {
            background-color: lightblue;

        }

        .borrar {
            background-color: lightcoral;
            margin-right: 1rem;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    echo "<table>";
    echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";

    while ($tupla = mysqli_fetch_assoc($datos_usuario)) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' title='Ver detalles' type='submit' name='btnDetalles' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</form></td>";
        echo "<td><form action='index.php' method='post'><button class='btn_imagen' type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button></td>";
        echo "<td>Editar</td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_free_result($datos_usuario);

    if (isset($_POST["btnDetalles"])) {

        if (mysqli_num_rows($detalle_usuario) > 0) {

            $tupla_detalles = mysqli_fetch_assoc($detalle_usuario);

            echo "<h2>Detalles del usuario " . $_POST["btnDetalles"] . "</h2>";

            echo "<p>";
            echo "<strong>Nombre: </strong>" . $tupla_detalles["nombre"] . "</br>";
            echo "<strong>Nombre: </strong>" . $tupla_detalles["usuario"] . "</br>";
            echo "<strong>Clave: </strong></br>";
            echo "<strong>Nombre: </strong>" . $tupla_detalles["email"] . "</br>";
            echo "</p>";
        } else {
            echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
        }
        mysqli_free_result($detalle_usuario);
    }
    if (isset($_POST["btnBorrar"])) {
        if (mysqli_num_rows($detalle_usuario) > 0) {
            $tupla_detalles = mysqli_fetch_assoc($detalle_usuario);
            echo "<h2>¿Desea borrar a " . $tupla_detalles["nombre"] . "?</h2>";
            echo "<form action='index.php' method='post'><button type='submit' class='borrar' name='btn_borrar_def'>Borrar</button>";
            echo "<button type='submit' class='volver' name='btn_volver'>Volver</button></form>";
        } else {
            echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
        }
        mysqli_free_result($detalle_usuario);
    }
    if (isset($_POST["btn_borrar_def"])) {
        echo "<p>Hola</p>";
        /*try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnBorrar"] . "'";
            $detalle_usuario = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }*/
    }

    ?>
</body>

</html>