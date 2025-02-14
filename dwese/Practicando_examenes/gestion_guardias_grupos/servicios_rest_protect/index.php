<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_CTES_servicios.php";


$app= new \Slim\App;

//obtener la id y el nombre de todos los usuarios
$app->get('/usuarios',function(){
    echo json_encode(obtener_usuarios());
});

//obtener los nombres de los grupos, los dias y las horas de un profesor con id especifica
$app->get('/horario/{id_profesor}',function($request){
    $id_profesor=$request->getAttribute('id_profesor');
    echo json_encode(obtener_horario_profesor($id_profesor));
});

$app->run();
?>
