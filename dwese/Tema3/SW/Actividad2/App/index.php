<?php
require "src/funciones_ctes.php";

if (isset($_POST["btn_detalles"])) {
    $url = DIR_SERV . "/producto/" . $_POST["btn_detalles"];
    $respuesta = consumir_servicios_REST($url, "GET");
    $json_detalles = json_decode($respuesta, true);
    if (!$json_detalles) {
        die(error_page("Actividad2", "<p>Error consumiendo el servicio rest: " . $url . "</p>"));
    }
    if (isset($json_detalles["error"])) {
        die(error_page("Actividad2", "<p>" . $json_detalles["error"] . "</p>"));
    }
}

//Esto se va a hacer siempre
$url = DIR_SERV . "/productos";
$respuesta = consumir_servicios_REST($url, "GET");
$json_productos = json_decode($respuesta, true);
if (!$json_productos) {
    die(error_page("Actividad2", "<p>Error consumiendo el servicio rest: " . $url . "</p>"));
}
if (isset($json_productos["error"])) {
    die(error_page("Actividad2", "<p>" . $json_productos["error"] . "</p>"));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .centrado {
            width: 85%;
            margin: 1em auto;
        }

        .txt_centrado {
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            text-align: center
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>Actividad 2</title>
</head>

<body>
    <h1 class="centrado txt_centrado">Listado de los Productos</h1>

    <?php

    if (isset($_POST["btn_detalles"])) {
        echo "<div class='centrado'>";
        echo "<h2>Información del producto: " . $_POST["btn_detalles"] . "</h2>";
        if (isset($json_detalles["mensaje"])) {
            echo "<p>El producto ya no se encuentra en la bd</p>";
        } else {
            echo "<p>";
            echo "<strong>Nombre:</strong> " . $json_detalles["producto"]["nombre"] . "<br>";
            echo "<strong>Nombre corto:</strong> " . $json_detalles["producto"]["nombre_corto"] . "<br>";
            echo "<strong>Descripción:</strong> " . $json_detalles["producto"]["descripcion"] . "<br>";
            echo "<strong>PVP:</strong> " . $json_detalles["producto"]["PVP"] . "<br>";
            echo "<strong>Familia:</strong> " . $json_detalles["producto"]["nombre_familia"] . "<br>";
            echo "</p>";
        }
        echo "<form action='index.php' method='post'><button type='submit'>Volver</button></form>";
        echo "</div>";
    }

    echo "<table>";
    echo "<tr><th>Código</th><th>Nombre</th><th>PVP (€)</th><th><button class='enlace'><strong>+Producto</strong></button></th></tr>";
    foreach ($json_productos["productos"] as $tupla) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btn_detalles' value='" . $tupla["cod"] . "' type='submit'>" . $tupla["cod"] . "</button></form></td>";
        echo "<td>" . $tupla["nombre_corto"] . "</td>";
        echo "<td>" . $tupla["PVP"] . "</td>";
        echo "<td><button class='enlace'>Borrar</button>-<button class='enlace'>Editar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>

</html>