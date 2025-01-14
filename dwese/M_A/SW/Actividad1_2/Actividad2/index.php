<?php
require "src/funciones_ctes.php";

if (isset($_POST["btnDetalles"])) {
    $url = DIR_SERV . "/producto/" . $_POST["btnDetalles"];
    $respuesta = consumir_servicios_REST($url, "GET");
    $json_detalles = json_decode($respuesta, true);
    if (!$json_detalles)
        die(error_page("Actividad 2", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));

    if (isset($json_detalles["error"]))
        die(error_page("Actividad 2", "<p>" . $json_detalles["error"] . "</p>"));
}


//Esto se va a hacer siempre
$url = DIR_SERV . "/productos";
$respuesta = consumir_servicios_REST($url, "GET");
$json_productos = json_decode($respuesta, true);
if (!$json_productos)
    die(error_page("Actividad 2", "<p>Error consumiendo el servico rest: <strong>" . $url . "</strong></p>"));

if (isset($json_productos["error"]))
    die(error_page("Actividad 2", "<p>" . $json_productos["error"] . "</p>"));

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 2</title>
    <style>
        .centrado {
            width: 85%;
            margin: 1em auto
        }

        .txt_centrado {
            text-align: center
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            border-collapse: collapse
        }

        th {
            background-color: #CCC
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
    </style>
</head>

<body>
    <h1 class="centrado txt_centrado">Listado de los productos</h1>
    <?php

    if (isset($_POST["btnDetalles"])) {
        echo "<div class='centrado'>";
        echo "<h2>Información del Producto: " . $_POST["btnDetalles"] . "</h2>";
        if (isset($json_detalles["mensaje"]))
            echo "<p>El producto seleccionado ya no se encuentra en la BD</p>";
        else {
            echo "<p>";
            echo "<strong>Nombre: </strong>" . $json_detalles["producto"]["nombre"] . "<br/>";
            echo "<strong>Nombre corto: </strong>" . $json_detalles["producto"]["nombre_corto"] . "<br/>";
            echo "<strong>Descripción: </strong>" . $json_detalles["producto"]["descripcion"] . "<br/>";
            echo "<strong>PVP: </strong>" . $json_detalles["producto"]["PVP"] . " €<br/>";
            echo "<strong>Familia: </strong>" . $json_detalles["producto"]["nombre_familia"];
            echo "</p>";
        }
        echo "<form action='index.php' method='post'><button>Volver</button></form>";
        echo "</div>";
    }



    echo "<table class='centrado txt_centrado'>";
    echo "<tr><th>COD</th><th>Nombre</th><th>PVP (€)</th><th>Producto+</th></tr>";
    foreach ($json_productos["productos"] as $tupla) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalles' value='" . $tupla["cod"] . "' type='submit'>" . $tupla["cod"] . "</button></form></td>";
        echo "<td>" . $tupla["nombre_corto"] . "</td>";
        echo "<td>" . $tupla["PVP"] . "</td>";
        echo "<td>Borrar - Editar</td>";
        echo "</tr>";
    }
    echo "</table>"
    ?>
</body>

</html>