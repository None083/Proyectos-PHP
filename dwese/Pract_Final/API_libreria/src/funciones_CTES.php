<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("PASSWORD_API","Una_clave_para_usar_para_encriptar");
define("TIEMPO_MINUTOS_API",60);
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","root");
define("CLAVE_BD","");
define("NOMBRE_BD","bd_libreria_exam");


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
            $consulta="select * from usuarios where id_usuario=?";
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
         
            $payload['exp']=time()+TIEMPO_MINUTOS_API*60;
            $payload['data']= $respuesta["usuario"]["id_usuario"];
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

function login($datos_login)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where lector=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos_login);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        $payload['exp']=time()+TIEMPO_MINUTOS_API*60;
        $payload['data']= $respuesta["usuario"]["id_usuario"];
        $jwt = JWT::encode($payload,PASSWORD_API,'HS256');
        $respuesta["token"]=$jwt;

    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_libros()
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from libros";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        

   
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_libro($referencia)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from libros where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$referencia]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["libro"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        

   
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function crear_libro($datos_libro)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta="insert into libros(referencia,titulo,autor,descripcion,precio) values(?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_libro);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0)
        $respuesta["mensaje"] = "Libro insertado correctamente en la BD";
    else
        $respuesta["error"] = "Error al insertar el libro";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function actualizar_libro($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="update libros set titulo=?, autor=?, descripcion=?, precio=? where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"]="Libro editado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consultaAQUI. Error:".$e->getMessage();
        return $respuesta;
    }

}

function borrar_libro($referencia)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    }
    catch(PDOException $e){
        $respuesta["error_bd"]="Imposible conectar a la BD. Error:".$e->getMessage();
        return $respuesta;
    }

    try{
       
        $consulta="delete from libros where referencia=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
        $respuesta["mensaje"]="Libro borrado con éxito";
        $sentencia=null;
        $conexion=null;
        return $respuesta;
        
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error_bd"]="Error en la consulta. Error:".$e->getMessage();
        return $respuesta;
    }

}

?>