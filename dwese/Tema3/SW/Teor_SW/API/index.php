<?php

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->get('/saludo', function () {

    $respuesta["mensaje"] = "Hola que tal?";
    echo json_encode($respuesta);
});

$app->get('/saludo/{nombre}', function ($request) {
    $nombre = $request->getAttribute("nombre");
    $respuesta["mensaje"] = "Hola que tal, " . $nombre . "?";
    echo json_encode($respuesta);
});

$app->post('/saludo', function ($request) {

    $nombre = $request->getParam("nombre");
    $respuesta["mensaje"] = "Hola que tal, " . $nombre . "?";
    echo json_encode($respuesta);
});

//delete('/borrar_saludo/{id}')
$app->delete('/borrar_saludo/{id}', function ($request) {
    $id = $request->getAttribute("id");
    $respuesta["mensaje"] = "Saludo con id " . $id . " borrado";
    echo json_encode($respuesta);
});

//put('/cambiar_saludo/{id}')
//por debajo un nombre
$app->put('/cambiar_saludo/{id}', function ($request) {
    $id = $request->getAttribute("id");
    $nombre = $request->getParam("nombre");
    $respuesta["mensaje"] = "Saludo con id " . $id . " cambiado a " . $nombre;
    echo json_encode($respuesta);
});


$app->run();
