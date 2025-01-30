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

        div#contenedor {
            display: flex;
            flex-flow: row wrap;
            width: 100%;
        }

        div.libro {
            margin: 10px;
            width: 30%;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["lector"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
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

    echo "<h2>Listado de los Libros</h2>";
    echo "<div id='contenedor'>";

    foreach ($json_libros["libros"] as $tupla) {
        echo "<div class='libro'><img src='../images/" . $tupla["portada"] . "' alt='Portada del libro'></br>" . $tupla["titulo"] . " - " . $tupla["precio"] . "€</div>";
    }

    echo "</div>";
    ?>
</body>

</html>