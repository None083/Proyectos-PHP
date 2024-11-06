<?php
const SERVIDOR_BD = "localhost";
//const USUARIO_BD = "jose";
const USUARIO_BD = "root";
//const CLAVE_BD = "josefa";
const CLAVE_BD = "";
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

if(isset($_POST["btnAgregar"]))
{
    //Compruebo errores
    //Si no los hay inserto en la tabla e informo de la acción
    require "vistas/vista_errores.php";
    
}

if (isset($_POST["btnDetalles"]) || isset($_POST["btnBorrar"])) {
    if (isset($_POST["btnDetalles"])) {
        $id_usuario = $_POST["btnDetalles"];
    } else {
        $id_usuario = $_POST["btnBorrar"];
    }
    try {
        $consulta = "select * from usuarios where id_usuario='" . $id_usuario . "'";
        $detalle_usuario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST["btnBorrarDef"])) {
    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnBorrarDef"] . "'";
        mysqli_query( $conexion, $consulta);
        $mensaje_accion = "Usuario borrado con exito";
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

        .enlace:hover {
            color: darkblue;
            font-weight: 600;
        }

        .btn_imagen {
            border: none;
            background: none;
            cursor: pointer;
            color: red;
            font-weight: 600;
        }

        .btn_imagen:hover {
            color: darkred;
            font-weight: 900;
        }

        .volver {
            background-color: lightblue;

        }

        .borrar {
            background-color: lightcoral;
            margin-right: 1rem;
        }

        .btn_agregar {
            border: none;
            background: none;
            cursor: pointer;
            color: green;
            font-weight: 600;
        }

        .btn_agregar:hover {
            color: darkgreen;
            font-weight: 900;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    
    require "vistas/vista_tabla.php";

    if (isset($_POST["btnDetalles"])) {
        require "vistas/vista_detalle.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_borrar.php";
    }

    if (isset($_POST["btnAgregar"])) {
        require "vistas/vista_agregar.php";
    }

    ?>
</body>

</html>