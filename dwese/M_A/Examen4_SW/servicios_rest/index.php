<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


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

$app->get('/alumnos',function(){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="tutor")
            {
                echo json_encode(obtener_alumnos());
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
});


$app->get('/notasAlumno/{cod_usu}',function($request){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
           
            echo json_encode(obtener_notas_alumno($request->getAttribute("cod_usu")));
           
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    

        
});


$app->get('/asignaturasNoEvalAlumno/{cod_usu}',function($request){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="tutor")
            {
                echo json_encode(obtener_asignaturas_no_eval($request->getAttribute("cod_usu")));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
    
});


$app->delete('/quitarNota/{cod_usu}',function($request){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="tutor")
            {
                echo json_encode(quitar_nota($request->getParam("cod_asig"),$request->getAttribute("cod_usu")));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
    
});

$app->post('/ponerNota/{cod_usu}',function($request){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="tutor")
            {
                echo json_encode(poner_nota($request->getParam("cod_asig"),$request->getAttribute("cod_usu")));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
    
});

$app->put('/cambiarNota/{cod_usu}',function($request){
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="tutor")
            {
                echo json_encode(actualizar_nota($request->getParam("cod_asig"),$request->getAttribute("cod_usu"),$request->getParam("nota")));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        }
        else
            echo json_encode($test);
    }   
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
    
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
