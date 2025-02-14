<?php

require __DIR__ . '/Slim/autoload.php';
require "src/funciones_CTES_servicios.php";


$app= new \Slim\App;

$app->post('/login',function($request){
  
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));
    
});

$app->get('/logueado',function(){
    $test=validateToken();
    if(is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

/*Mediante una petición GET, obtener todos los datos de un usuario. Para ello aportaremos la clave 
de sesión mediante un array asociativo con índice “api_session”. En caso de error por la BD el JSON 
devuelto será: {“error” : “Error....”}. Si el usuario no se encuentra registrado en la base de datos el JSON 
será: {“mensaje”: “El usuario con (id_usuario) no se encuentra registrado en la BD”}, en otro caso el JSON 
será: { “usuario” : {...}}
URL de la petición:  
http://localhost/Proyectos/Examen_REC_DWESE/servicios_rest/usuario/{id_usuario}, dónde id_usuario es 
un atributo numérico pasado por la url .
*/

$app->get('/usuario/{id_usuario}',function($request){
    $test=validateToken();
    if(is_array($test)){
        $id_usuario=$request->getAttribute("id_usuario");
        echo json_encode(getUsuario($id_usuario));
    }else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

/* 
Mediante una petición GET, obtener todos los datos de todos los usuarios que están de guardia un 
día a una hora. Para ello aportaremos la clave de sesión mediante un array asociativo con índice 
“api_session”. En caso de error por la BD el JSON devuelto será: {“error” : “Error....”}, en otro caso el JSON 
será: { “usuarios” : [{...}, {...},...,{...}]}  URL de la petición:  
http://localhost/Proyectos/Examen_REC_DWESE/servicios_rest/usuariosGuardia/{dia}/{hora}, dónde dia y 
hora son dos atributos numéricos pasados por la url.
*/

$app->get('/usuariosGuardia/{dia}/{hora}',function($request){
    $test=validateToken();
    if(is_array($test)){
        $dia=$request->getAttribute("dia");
        $hora=$request->getAttribute("hora");
        echo json_encode(getUsuariosGuardia($dia,$hora));
    }else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->run();
?>
