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
    echo json_encode(obtener_libros());
});

/* 
Crear un nuevo libro mediante una petición POST en la que aportaremos los datos mediante un array asociativo con los siguientes índices: “referencia”, “titulo”, “autor”, “descripción” y “precio”. En caso de error por la BD el JSON devuelto será: { “error” : “Error….”}, en otro caso el JSON será: { “mensaje” : “Libro insertado correctamente en la BD”}
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/crearLibro
debe estar protegido
*/
$app->post('/crearLibro', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        $datos_libro[] = $request->getParam("referencia");
        $datos_libro[] = $request->getParam("titulo");
        $datos_libro[] = $request->getParam("autor");
        $datos_libro[] = $request->getParam("descripcion");
        $datos_libro[] = $request->getParam("precio");

        echo json_encode(crear_libro($datos_libro));
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->run();
