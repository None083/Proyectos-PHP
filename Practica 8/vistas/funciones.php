<?php
const SERVIDOR_BD = "localhost";
const USUARIO_BD = "root";
const CLAVE_BD = "";
const NOMBRE_BD = "bd_cv";

function error_page($title, $body){
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

function repetido($conexion,$tabla,$columna,$valor,$columna_clave=null,$valor_clave=null)
{
    try
    {
        if(isset($columna_clave))
            $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."' AND ".$columna_clave."<>'".$valor_clave."'";
        else
            $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."'";

            
        $usuario_repetido=mysqli_query($conexion,$consulta);
        $respuesta=mysqli_num_rows($usuario_repetido)>0;
    }
    catch(Exception $e)
    {
        $respuesta="No se ha podido realizar la consulta: ".$e->getMessage();
    }

    return $respuesta;
}

function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_valido($dni)
{
    $valido = true;

    if (strlen($dni) != 9) {
        $valido = false;
    } else {
        if (!ctype_alpha($dni[strlen($dni) - 1])) {
            $valido = false;
        } else {
            $numero_dni = substr($dni, 0, -1);
            $letra_dni = strtoupper(substr($dni, -1));

            if (!is_numeric($numero_dni)) {
                return false;
            }

            $letra_valida_dni = LetraNIF((int)$numero_dni);

            if ($letra_dni != $letra_valida_dni) {
                return false;
            }
        }
    }
    return $valido;
}

function tiene_extension($extension)
{
    $array_nombre = explode(".", $extension);
    if (count($array_nombre) <= 1) {
        $respuesta = false;
    } else {
        $respuesta = end($array_nombre);
    }
    return $respuesta;
}