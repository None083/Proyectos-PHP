<?php
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$url = DIR_SERV . "/obtenerLibros";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_libros = json_decode($respuesta, true);

if (!$json_libros) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_libros["error"])) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_libros["error"] . "</p>"));
}

if (isset($json_libros["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if (isset($json_libros["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnBorrar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/borrarLibro/" . urlencode($_POST["btnBorrar"]);
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrar = json_decode($respuesta, true);
    if (!$json_borrar) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_borrar["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_libros["error"] . "</p>"));
    }

    if (isset($json_borrar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_borrar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje"] = "Libro borrado con éxito";
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnCrear"])) {
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]);
    if (!$error_referencia) {

        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/libros/referencia/" . urlencode($_POST["referencia"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_referencia = $json_repetido["repetido"];
    }

    $error_titulo = $_POST["titulo"] == "";
    if (!$error_titulo) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/libros/titulo/" . urlencode($_POST["titulo"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
        }


        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_titulo = $json_repetido["repetido"];
    }

    $error_autor = $_POST["autor"] == "";
    if (!$error_autor) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/libros/autor/" . urlencode($_POST["autor"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
        }


        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_autor = $json_repetido["repetido"];
    }

    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;

    $error_form = $error_referencia || $error_autor || $error_titulo || $error_descripcion || $error_precio;

    if (!$error_form) {

        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/crearLibro";
        unset($_POST["btnContNuevo"]);
        $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers, $_POST);
        $json_insertar = json_decode($respuesta, true);
        if (!$json_insertar) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
        }

        if (isset($json_insertar["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<p>" . $json_insertar["error"] . "</p>"));
        }

        if (isset($json_insertar["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if (isset($json_insertar["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje"] = "Libro creado con éxito";
        header("Location:index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["lector"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    echo "<h2>Listado de los Libros</h2>";

    echo "<table>";
    echo "<tr><th>Referencia</th><th>Título</th><th>Acción</th></tr>";
    foreach ($json_libros["libros"] as $tupla) {
        echo "<tr><td>" . $tupla["referencia"] . "</td><td>" . $tupla["titulo"] . "</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='btnBorrar' value='" . $tupla["referencia"] . "'>Borrar</button> - <button class='enlace' type='submit' name='btnEditar'>Editar</button></form></td></tr>";
    }
    echo "</table>";
    ?>
    <h3>Agregar un nuevo libro</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="referencia">Referencia: </label>
            <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"]; ?>">
            <?php
            if (isset($_POST["btnCrear"]) && $error_form) {
                if ($_POST["referencia"] == "") {
                    echo "<span class='error'>No se pueden dejar campos vacíos</span>";
                } else if (!is_numeric($_POST["referencia"])) {
                    echo "<span class='error'>La referencia debe tener un valor numérico</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="titulo">Titulo: </label>
            <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>">
            <?php
            if (isset($_POST["btnCrear"]) && $error_form) {
                if ($_POST["titulo"] == "") {
                    echo "<span class='error'>No se pueden dejar campos vacíos</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="autor">Autor: </label>
            <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"]; ?>">
            <?php
            if (isset($_POST["btnCrear"]) && $error_form) {
                if ($_POST["autor"] == "") {
                    echo "<span class='error'>No se pueden dejar campos vacíos</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripcion: </label>
            <input type="text" name="descripcion" id="descripcion" value="<?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?>">
            <?php
            if (isset($_POST["btnCrear"]) && $error_form) {
                if ($_POST["descripcion"] == "") {
                    echo "<span class='error'>No se pueden dejar campos vacíos</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="precio">Precio: </label>
            <input type="text" name="precio" id="precio" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"]; ?>">
            <?php
            if (isset($_POST["btnCrear"]) && $error_form) {
                if ($_POST["precio"] == "") {
                    echo "<span class='error'>No se pueden dejar campos vacíos</span>";
                } else if (!is_numeric($_POST["precio"])) {
                    echo "<span class='error'>El precio debe tener un valor numérico</span>";
                }
            }
            ?>
        </p>

        <button type="submit" name="btnCrear" value="">Agregar</button>
    </form>

</body>

</html>