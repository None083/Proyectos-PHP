<?php

require __DIR__ . '/Slim/autoload.php';

require '../App/src/funciones_ctes.php';

$app = new \Slim\App;

$app->get('/productos', function () {
    echo json_encode(obtener_productos());
});

$app->get('/producto/{cod}', function ($request) {
    $cod = $request->getAttribute("codigo");
    echo json_encode(obtener_producto($cod));
});

$app->post('/producto/insertar', function ($request) {
    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");
    echo json_encode(insertar_producto($datos));
});

$app->put('/producto/actualizar/{codigo}', function ($request) {
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");
    $datos[] = $request->getAttribute("codigo");
    echo json_encode(actualizar_producto($datos));
});

$app->get('/producto/borra/r{codigo}', function ($request) {
    $cod = $request->getAttribute("codigo");
    echo json_encode(borrar_producto($cod));
});

$app->get('/familias', function () {
    echo json_encode(obtener_familias());
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {
    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");
    echo json_encode(repetido_insertando($tabla, $columna, $valor));
});

$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}', function ($request) {
    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");
    $valor = $request->getAttribute("columna_id");
    $valor = $request->getAttribute("valor_id");
    echo json_encode(repetido_editando($tabla, $columna, $valor, $columna_id, $valor_id));
});

$app->run();
