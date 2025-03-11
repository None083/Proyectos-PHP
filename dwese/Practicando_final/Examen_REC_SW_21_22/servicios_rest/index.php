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

$app->get('/profesores',function(){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_todos_profesores());
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

$app->get('/profesoresLibres/{dia}/{hora}/{id_grupo}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $dia=$request->getAttribute("dia");
                $hora=$request->getAttribute("hora");
                $id_grupo=$request->getAttribute("id_grupo");
                echo json_encode(obtener_profesores_libres($dia,$hora,$id_grupo));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->get('/aulas',function(){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
                echo json_encode(obtener_aulas());
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});
/*
$app->post('/insertarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}/{id_aula}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $dia=$request->getAttribute("dia");
                $hora=$request->getAttribute("hora");
                $id_grupo=$request->getAttribute("id_grupo");
                $id_usuario=$request->getAttribute("id_usuario");
                $id_aula=$request->getAttribute("id_aula");
                echo json_encode(insertar_profesor($dia,$hora,$id_grupo,$id_usuario, $id_aula));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});
*/
$app->post('/insertarProfesor',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $dia=$request->getParam("dia");
                $hora=$request->getParam("hora");
                $id_grupo=$request->getParam("grupo");
                $id_usuario=$request->getParam("profesor");
                $id_aula=$request->getParam("aula");
                echo json_encode(insertar_profesor($dia,$hora,$id_grupo,$id_usuario, $id_aula));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->put('/profesor/editar/{id_usuario}',function($request){

    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $datos[]=$request->getParam("usuario_profe");
                $datos[]=md5($request->getParam("clave_profe"));
                $datos[]=$request->getAttribute("id_usuario");

                echo json_encode(editar_profesor($datos));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

});

//repetido editando
$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}',function($request){

    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $tabla=$request->getAttribute("tabla");
                $columna=$request->getAttribute("columna");
                $valor=$request->getAttribute("valor");
                $columna_id=$request->getAttribute("columna_id");
                $valor_id=$request->getAttribute("valor_id");
                echo json_encode(repetido_editando($tabla, $columna,$valor,$columna_id, $valor_id));
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
