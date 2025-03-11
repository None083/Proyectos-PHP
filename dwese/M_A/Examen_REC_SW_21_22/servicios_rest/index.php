<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app= new \Slim\App;

$app->get('/logueado',function(){

    $test=validateToken();
    if(is_array($test))
    {
        echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio"));  
});


$app->post('/login',function($request){
    
    $datos_login[]=$request->getParam("usuario");
    $datos_login[]=$request->getParam("clave");


    echo json_encode(login($datos_login));
});


$app->get('/grupos',function(){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_grupos());
            else
                echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 
        else
            echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 

    
});


$app->get('/horario/{id_grupo}',function($request){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_horario_grupo($request->getAttribute("id_grupo")));
            else
                echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 
        else
            echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 

    
});

$app->get('/profesores/{dia}/{hora}/{id_grupo}',function($request){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_profesores($request->getAttribute("dia"),$request->getAttribute("hora"),$request->getAttribute("id_grupo")));
            else
                echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 
        else
            echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 

    
});

$app->get('/profesoresLibres/{dia}/{hora}/{id_grupo}',function($request){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_profesores_libres($request->getAttribute("dia"),$request->getAttribute("hora"),$request->getAttribute("id_grupo")));
            else
                echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 
        else
            echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio")); 

    
});


$app->run();

?>