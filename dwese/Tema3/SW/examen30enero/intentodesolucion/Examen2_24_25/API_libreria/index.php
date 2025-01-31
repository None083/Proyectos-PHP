<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app = new \Slim\App;

$app->get('/logueado', function () {

    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});


$app->post('/login', function ($request) {

    $datos_login[] = $request->getParam("lector");
    $datos_login[] = $request->getParam("clave");


    echo json_encode(login($datos_login));
});

$app->get('/obtenerLibros', function () {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            echo json_encode(obtener_libros());
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

$app->delete('/borrarLibro/{referencia}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $referencia = $request->getAttribute("referencia");
                echo json_encode(borrar_libro($referencia));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

$app->post('/crearLibro', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $datos[] = $request->getParam("referencia");
                $datos[] = $request->getParam("titulo");
                $datos[] = $request->getParam("autor");
                $datos[] = $request->getParam("descripcion");
                $datos[] = $request->getParam("precio");

                echo json_encode(crear_libro($datos));
            } else {
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
            }
        else {
            echo json_encode($test);
        }
    else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {

    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $tabla = $request->getAttribute("tabla");
                $columna = $request->getAttribute("columna");
                $valor = $request->getAttribute("valor");
                echo json_encode(repetido_insertando($tabla, $columna, $valor));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

$app->run();
