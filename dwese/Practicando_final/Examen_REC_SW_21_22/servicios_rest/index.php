<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/conexion_PDO',function($request){

    echo json_encode( conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode( conexion_mysqli(), JSON_FORCE_OBJECT);
});

$app->get('/logueado',function(){
    $test=validateToken();
    if(is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->post('/login',function($request){
  
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave)); 
});

$app->get('/grupos',function(){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_grupos());
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->get('/horario/{id_grupo}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $id_grupo=$request->getAttribute("id_grupo");
                echo json_encode(obtener_horario($id_grupo));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->get('/profesores/{dia}/{hora}/{id_grupo}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $dia=$request->getAttribute("dia");
                $hora=$request->getAttribute("hora");
                $id_grupo=$request->getAttribute("id_grupo");
                echo json_encode(obtener_profesores($dia,$hora,$id_grupo));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->delete('/borrarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $dia=$request->getAttribute("dia");
                $hora=$request->getAttribute("hora");
                $id_grupo=$request->getAttribute("id_grupo");
                $id_usuario=$request->getAttribute("id_usuario");
                echo json_encode(borrar_profesor($dia, $hora, $id_grupo, $id_usuario));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

});

$app->get('/horarioProfesor/{id_usuario}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="normal")
            {
                $id_usuario=$request->getAttribute("id_usuario");
                echo json_encode(horario_profesor($id_usuario));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->run();
?>
