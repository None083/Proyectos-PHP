<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>
<body>
    <h1>Teoría PDO</h1>
    <?php
    define("SERVIDOS_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro");

    try {
        $conexion = new PDO("mysql:host=".SERVIDOS_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>");
    }
    
    echo "<h2>Conectado</h2>";

    $usuario = "juanito";
    $clave = md5("123456");

    try {
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die("<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>");
    }

    if ($sentencia->rowCount()<=0) {
        echo "<p>No hay usuarios con esas credenciales en la BD</p>";
    }else{
        $tupla=$sentencia->fetch(PDO::FETCH_ASSOC);//PDO::FETCH_NUM, PDO::FETCH_OBJECT
        echo "<p>El nombre del usuario logueado es: <strong>" . $tupla["nombre"] . "</strong></p>";
    }

    //con varios resultados
    try {
        $consulta="select * from usuarios";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die("<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>");
    }

    if ($sentencia->rowCount()<=0) {
        echo "<p>No hay usuarios en la BD</p>";
    }else{
        $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_NUM, PDO::FETCH_OBJECT
        echo "<h3>Listado de los usuarios</h3>";
        echo "<ol>";
        foreach ($usuarios as $tupla) {
           echo "<li>".$tupla["nombre"]."</li>";
        }
        echo "</ol>";
    }

    


    //cerramos sentencia
    $sentencia = null;
    //Cerramos conexión
    $conexion = null;
    ?>
</body>
</html>