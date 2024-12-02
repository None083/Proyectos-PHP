<?php
const HOST_BD = "localhost";
const USER_BD = "root";
const CLAVE_BD = "";
const NOMRE_BD = "videoclub_exam";

function error_page($titulo, $mensaje){
    return "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width', initial-scale='1.0'>
        <title>".$titulo."</title>
    </head>
    <body>
        ".$mensaje."
    </body>
    </html>";
}

?>
