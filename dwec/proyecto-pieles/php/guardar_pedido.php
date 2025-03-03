<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$archivo = 'pedidos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $nuevoPedido = json_decode($json, true);

    if (!$nuevoPedido) {
        echo json_encode(["mensaje" => "Error: Datos inválidos"]);
        exit;
    }

    $pedidos = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) ?: [] : [];
    $pedidos[] = $nuevoPedido;

    if (file_put_contents($archivo, json_encode($pedidos, JSON_PRETTY_PRINT))) {
        echo json_encode(["mensaje" => "Pedido guardado correctamente"]);
    } else {
        echo json_encode(["mensaje" => "Error al guardar el pedido"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($archivo)) {
        echo json_encode(["pedidos" => json_decode(file_get_contents($archivo), true)]);
    } else {
        echo json_encode(["pedidos" => []]);
    }
} else {
    echo json_encode(["mensaje" => "Método no permitido"]);
}
