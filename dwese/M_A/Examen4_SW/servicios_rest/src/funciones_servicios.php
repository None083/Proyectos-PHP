<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_exam_colegio3");
define("PASSWORD_API","PASSWORD_DE_MI_APLICACION");



function validateToken()
{
    
    $headers = apache_request_headers();
    if(!isset($headers["Authorization"]))
        return false;//Sin autorizacion
    else
    {
        $authorization = $headers["Authorization"];
        $authorizationArray=explode(" ",$authorization);
        $token=$authorizationArray[1];
        try{
            $info=JWT::decode($token,new Key(PASSWORD_API,'HS256'));
        }
        catch(\Throwable $th){
            return false;//Expirado
        }

        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
            return $respuesta;
        }

        try{
            $consulta="select * from usuarios where cod_usu=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$info->data]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
            $sentencia=null;
            $conexion=null;
            return $respuesta;
        }
        if($sentencia->rowCount()>0)
        {
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
         
            $payload['exp']=time()+3600;
            $payload['data']= $respuesta["usuario"]["cod_usu"];
            $jwt = JWT::encode($payload,PASSWORD_API,'HS256');
            $respuesta["token"]=$jwt;
        }
            
        else
            $respuesta["mensaje_baneo"]="El usuario no se encuentra registrado en la BD";

        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
}

function login($usario,$clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usario,$clave]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    
    
        $payload=['exp'=>time()+3600,'data'=> $respuesta["usuario"]["cod_usu"]];
        $jwt = JWT::encode($payload,PASSWORD_API,'HS256');
        $respuesta["token"]=$jwt;
    }
        
    else
        $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";


    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


function obtener_alumnos()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


function obtener_asignaturas_no_eval($cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from asignaturas where cod_asig NOT IN (select asignaturas.cod_asig from asignaturas,notas where asignaturas.cod_asig=notas.cod_asig and cod_usu=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["asignaturas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function obtener_notas_alumno($cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select asignaturas.*, notas.nota from asignaturas,notas where asignaturas.cod_asig=notas.cod_asig and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function quitar_nota($cod_asig,$cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="delete from notas where cod_asig=? and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_asig,$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["mensaje"]="Asignatura descalificada con éxito";
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


function actualizar_nota($cod_asig,$cod_usu,$nota)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="update notas set nota=? where cod_asig=? and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$nota,$cod_asig,$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["mensaje"]="Asignatura cambiada con éxito";
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function poner_nota($cod_asig,$cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="insert into notas (cod_asig,cod_usu,nota) values(?,?,'0')";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_asig,$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
    
    $respuesta["mensaje"]="Asignatura calificada con éxito";
    
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
?>
