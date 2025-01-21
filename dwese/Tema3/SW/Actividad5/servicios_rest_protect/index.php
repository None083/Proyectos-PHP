<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_ctes.php";

$app= new \Slim\App;

$app->get('/logueado', function () {
    $test = validateToken();
    if (is_array($test)) {
        echo json_encode(($test));
    }else{
        echo json_encode(array("no_auth" => "A joderse"));
    }
});

$app->post("/login",function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));
});

$app->run();

?>