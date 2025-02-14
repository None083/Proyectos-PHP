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

    $datos_login[] = $request->getParam("usuario");
    $datos_login[] = $request->getParam("clave");


    echo json_encode(login($datos_login));
});

/*
Obtener todos los datos de un usuario, mediane una petición GET. En caso de error por la BD el JSON 
devuelto será: { “error” : “Error....”}. Si el usuario no se encuentra registrado en la base de datos el JSON 
será: {“mensaje”: “El usuario no se encuentra registrado en la BD”}, en otro caso el JSON será: { “usuario” : 
{...}}
URL de la petición: http://localhost/Proyectos/Examen_Rec_SW_24_25/usuario/{id_usuario}, dónde 
id_usuario es un atributo pasado por la URL.
*/

$app->get('/usuario/{id_usuario}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        $id_usuario = $request->getAttribute("id_usuario");
        echo json_encode(obtener_Usuario($id_usuario));
    } else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

/* 
Obtener todos los datos de todos los usuarios que están de guardia un día a una hora mediante una petición 
GET.  En caso de error por la BD el JSON devuelto será: { “error” : “Error....”}, en otro caso el JSON será: 
{ “usuarios” :[{...}, {...},...,{...}]}
URL de la petición: http://localhost/Proyectos/Examen_Rec_SW_24_25/servicios_rest/usuariosGuardia/{dia}/{hora}, 
dónde dia y hora son dos atributos pasados por la URL.
*/
$app->get('/usuariosGuardia/{dia}/{hora}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        $dia[] = $request->getParam("dia");
        $hora[] = $request->getParam("hora");
        echo json_encode(obtener_usuarios_guardia($dia, $hora));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

/*
Obtener  todos  los  días  y  horas  que  un  usuario  está  de  guardia  mediante  una  petición  GET. En caso 
de error por la BD el JSON devuelto será: { “error” : “Error....”}, en otro caso el JSON será: { “de_guardia” : 
[ {dia1,hora1},{dia2,hora2} ,..., {diaN,horaN} ] }
URL de la petición:http://localhost/Proyectos/Examen_Final_Rec_Junio_23_24/servicios_rest/deGuardia/{id_usuario}, 
dónde id_usuario es un atributo pasado por la URL.
*/
$app->get('/deGuardia/{id_usuario}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        $id_usuario[] = $request->getParam("id_usuario");
        echo json_encode(obtener_dias_horas_guardia($id_usuario));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->run();
