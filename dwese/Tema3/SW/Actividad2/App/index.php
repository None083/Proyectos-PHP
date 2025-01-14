<?php
function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

define("DIR_SERV", "http://localhost/Proyectos/dwese/Tema3/SW/Actividad1/servicios_rest");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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

        img {
            height: 100px
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>Productos de la Tienda</title>
</head>

<body>
    <h1>Listado de los Productos</h1>

    <?php

    if (condition) {
        # code...
    }

    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta, true);
    if (!$obj) {
        die("<p>Error consumiendo el Servicio Web <strong>" . $url . "</strong></p></body></html>");
    }

    if (isset($obj->error)) {
        die("<p>" . $obj_error . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>Código</th><th>Nombre</th><th>PVP</th><th><button class='enlace'><strong>+Producto</strong></button></th></tr>";
    foreach ($obj["productos"] as $tupla) {
        echo "<tr>";
        echo "<td><button class='enlace' name='btnDetalle'>" . $tupla["cod"] . "</button></td>";
        echo "<td>" . $tupla["nombre_corto"] . "</td>";
        echo "<td>" . $tupla["PVP"] . "</td>";
        echo "<td><button class='enlace'>Borrar</button>-<button class='enlace'>Editar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>

</html>