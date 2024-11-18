<?php
const SERVIDOR_BD = "localhost";
const USUARIO_BD = "root";
const CLAVE_BD = "";
const NOMBRE_BD = "bd_cv";

const NOMBRE_IMAGEN_DEFECTO_BD = "no_imagen.jpg";

function error_page($title, $body)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
}