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

if (isset($_POST["btnContEditar"])) {
    //Compruebo errores
    //Si no los hay inserto en la tabla e informo de la acción
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        try {
            $consulta = "select usuario from usuarios where usuario='" . $_POST["usuario"] . "' AND id_usuario<>'" . $_POST["btnContEditar"] . "'";
            $usuario_repetido = mysqli_query($conexion, $consulta);
            $error_usuario = (mysqli_num_rows($usuario_repetido) > 0);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }

    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if (!$error_email) {
        try {
            $consulta = "select email from usuarios where email='" . $_POST["email"] . "' AND id_usuario<>'" . $_POST["btnContEditar"] . "'";
            $email_repetido = mysqli_query($conexion, $consulta);
            $error_email = (mysqli_num_rows($email_repetido) > 0);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }
    $errores_form_editar = $error_usuario || $error_email || $error_nombre;

    //Si no hay errores edito en la tabla e informo de la acción
    if (!$errores_form_editar) {
        //Edito y mensaje
        try {
            if ($_POST["clave"] == "")
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            else
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', clave='" . md5($_POST["clave"]) . "', email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";

            $resultado_editar = mysqli_query($conexion, $consulta);
            $mensaje_accion = "Usuario editado con éxito";
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }
}

if (isset($_POST["btnContAgregar"])) {
    //Compruebo errores
    //Si no los hay inserto en la tabla e informo de la acción
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        try {
            $consulta = "select usuario from usuarios where usuario='" . $_POST["usuario"] . "'";
            $usuario_repetido = mysqli_query($conexion, $consulta);
            $error_usuario = (mysqli_num_rows($usuario_repetido) > 0);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if (!$error_email) {
        try {
            $consulta = "select email from usuarios where email='" . $_POST["email"] . "'";
            $email_repetido = mysqli_query($conexion, $consulta);
            $error_email = (mysqli_num_rows($email_repetido) > 0);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
    }
    $errores_form_agregar = $error_clave || $error_usuario || $error_email || $error_nombre;

    if (!$errores_form_agregar) {
        try {
            $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . $_POST["email"] . "')";

            $resultado_agregar = mysqli_query($conexion, $consulta);
            $mensaje_accion = "Usuario insertado con éxito";
        } catch (Exception $e) {
            // Mostrar mensaje de error en caso de fallo
            die(error_page("Error al agregar usuario", "<p>Error al insertar en la base de datos: " . $e->getMessage() . "</p>"));
        }
    }
}

if (isset($_POST["btnDetalles"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"])) {
    if (isset($_POST["btnDetalles"])) {
        $id_usuario = $_POST["btnDetalles"];
    } else if (isset($_POST["btnBorrar"])) {
        $id_usuario = $_POST["btnBorrar"];
    } else {
        $id_usuario = $_POST["btnEditar"];
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
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con exito";
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Primer CRUD", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

//Debo poner al final la consulta de los usuarios para la tabla, ya que así se refrescará correctamente cuando haga algun cambio
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
        }

        .btn_editar {
            border: none;
            background: none;
            cursor: pointer;
            color: orange;
            font-weight: 600;
        }

        .btn_editar:hover {
            color: orangered;
        }

        .error {
            color: red;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php

    require "vistas/vista_tabla.php";

    if (isset($mensaje_accion)) {
        echo "<p>" . $mensaje_accion . "</p>";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_borrar.php";
    }

    if (isset($_POST["btnDetalles"])) {
        require "vistas/vista_detalle.php";
    }

    if (isset($_POST["btnAgregar"]) || (isset($_POST["btnContAgregar"]) && $errores_form_agregar)) {
        require "vistas/vista_agregar.php";
    }

    if (isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"]) && $errores_form_editar)) {
        require "vistas/vista_editar.php";
    }

    ?>
</body>

</html>