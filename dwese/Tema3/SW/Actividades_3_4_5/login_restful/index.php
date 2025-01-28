<?php

require "src/funciones_ctes.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// a) Mediante una petición GET, obtener todos los datos de todos los usuarios. En caso de error por la BD el JSON devuelto será: { “error” : “Error….”}, en otro caso el JSON será: { “usuarios” : [[…], [...],…,[…]]}
$app->get('/usuarios', function () {
    echo json_encode(obtener_usuarios());
});

// b) Crear un nuevo usuario mediante una petición POST en la que aportaremos los datos del usuario mediante un array asociativo con los siguientes índices: “nombre”, “usuario”, “clave” y “email”). En caso de error por la BD el JSON devuelto será: { “error”: “Error….”}, en otro caso el JSON devolverá la clave con la cual el nuevo usuario ha sido insertado en la BD: { “ult_id” : id_usuario}
// aparentemente si vas a insertar una nueva tupla, se necesita un request
$app->post('/usuario/crearUsuario', function ($request) {
    $datos["nombre"] = $request->getParam("nombre");
    $datos["usuario"] = $request->getParam("usuario");
    $datos["clave"] = $request->getParam("clave");
    $datos["email"] = $request->getParam("email");

    echo json_encode(insertar_usuario($datos));
});

// c) Solicitar autenticación de un usuario mediante una petición POST en la que aportaremos los datos necesarios para la autenticación (usuario y clave encriptada en MD5) mediante un array asociativo con los índices: “usuario” y “clave”. En caso de error por la BD el JSON devuelto será: { “error” : “Error….”}, en caso de que el usuario no se encuentre registrado el JSON será: { “mensaje” : “Usuario no se encuentra registrado en ….”} y en el caso de que se encuentre registrado, el JSON será: { “usuario” : […]}



$app->run();
