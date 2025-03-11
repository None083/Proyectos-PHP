<?php

//peticion obtener tabla
$app->get('/tabla', function () {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin")
                echo json_encode(obtener_tabla());
            else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

//funcion obtener tabla
function obtener_tabla()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from tabla";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["tabla"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//consumir servicio obtener tabla
$headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
$url = DIR_SERV . "/tabla";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_tabla = json_decode($respuesta, true);
if (!$json_tabla) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_tabla["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if (isset($json_tabla["error"])) {
    session_destroy();
    die(error_page("Examen5 PHP", "<p>" . $json_tabla["error"] . "</p>"));
}

if (isset($json_tabla["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

//obtener tabla con atributo, multiples resultados
$app->get('/tabla/{atributo}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $atributo = $request->getAttribute("atributo");
                echo json_encode(obtener_tabla_con_atributo($atributo));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function obtener_tabla_con_atributo($atributo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from tabla where atributo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$atributo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["tabla"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//obtener datos de varias tablas con varios atributos
$app->get('/profesores/{dia}/{hora}/{id_grupo}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getAttribute("dia");
                $hora = $request->getAttribute("hora");
                $id_grupo = $request->getAttribute("id_grupo");
                echo json_encode(obtener_profesores($dia, $hora, $id_grupo));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function obtener_profesores($dia, $hora, $id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select usuarios.id_usuario, usuarios.usuario, aulas.nombre from usuarios join horario_lectivo on horario_lectivo.usuario = usuarios.id_usuario join aulas on aulas.id_aula = horario_lectivo.aula where horario_lectivo.dia=? and horario_lectivo.hora=? and grupo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["profesores"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//hice una funcion ya que lo iba a usar varias veces
function servicio_mostrar_profesores($dia, $hora, $id_grupo)
{
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/profesores/" . $dia . "/" . $hora . "/" . $id_grupo;
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores = json_decode($respuesta, true);
    if (!$json_profesores) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_profesores["error"] . "</p>"));
    }

    if (isset($json_profesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    return $json_profesores;
}

//borrar entrada de una tabla con atributos
$app->delete('/borrarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getAttribute("dia");
                $hora = $request->getAttribute("hora");
                $id_grupo = $request->getAttribute("id_grupo");
                $id_usuario = $request->getAttribute("id_usuario");
                echo json_encode(borrar_profesor($dia, $hora, $id_grupo, $id_usuario));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function borrar_profesor($dia, $hora, $id_grupo, $id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "delete from horario_lectivo where dia=? and hora=? and grupo=? and usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo, $id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El profesor con id: " . $id_usuario . " se ha quitado de la tabla horario_lectivo";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

if (isset($_POST["btnQuitar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/borrarProfesor/" . urlencode($_POST["dia"]) . "/" . urlencode($_POST["hora"]) . "/" . urlencode($_POST["grupo"]) . "/" . urlencode($_POST["id_usuario"]);
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrar = json_decode($respuesta, true);
    if (!$json_borrar) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_borrar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_borrar["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_borrar["error"] . "</p>"));
    }

    if (isset($json_borrar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje"] = "¡¡ Profesor quitado con éxito !!";
}

//insetar sin ocultar url
$app->post('/insertarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}/{id_aula}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getAttribute("dia");
                $hora = $request->getAttribute("hora");
                $id_grupo = $request->getAttribute("id_grupo");
                $id_usuario = $request->getAttribute("id_usuario");
                $id_aula = $request->getAttribute("id_aula");
                echo json_encode(insertar_profesor($dia, $hora, $id_grupo, $id_usuario, $id_aula));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

function insertar_profesor($dia, $hora, $id_grupo, $id_usuario, $id_aula)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No ha podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into horario_lectivo (dia, hora, grupo, usuario, aula) values (?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_grupo, $id_usuario, $id_aula]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No ha podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El profesor con id: " . $id_usuario . " se ha insertado en la tabla horario_lectivo";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//insertar ocultando url
$app->post('/insertarProfesor', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $dia = $request->getParam("dia");
                $hora = $request->getParam("hora");
                $id_grupo = $request->getParam("grupo");
                $id_usuario = $request->getParam("profesor");
                $id_aula = $request->getParam("aula");
                echo json_encode(insertar_profesor($dia, $hora, $id_grupo, $id_usuario, $id_aula));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

//consumir servicio insertar ocultando url
if (isset($_POST["btnAgregar"])) {
    $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
    $url = DIR_SERV . "/insertarProfesor";
    $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers, $_POST);
    $json_agregar = json_decode($respuesta, true);
    if (!$json_agregar) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>Error consumiendo el servicio rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_agregar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_agregar["error"])) {
        session_destroy();
        die(error_page("Examen5 PHP", "<p>" . $json_agregar["error"] . "</p>"));
    }

    if (isset($json_agregar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje"] = "¡¡ Profesor agregado con éxito !!";
}

//tabla horario guardias grupos de un profesor
$horario = $json_horario["horario"];
$horas = ["", "8:15-9:15", "9:15-10:15", "10:15-11:15", "11:15-11:45", "11:45-12:45", "12:45-13:45", "13:45-14:45"];
echo "<table>";
echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
for ($hora = 1; $hora <= 7; $hora++) {
    echo "<tr>";
    echo "<td>" . $horas[$hora] . "</td>";
    if ($hora == 4) {
        echo "<td colspan='5'>Recreo</td>";
    } else {
        for ($dia = 1; $dia <= 5; $dia++) {
            echo "<td>";
            foreach ($horario as $tupla) {

                if ($tupla["dia"] == $dia && $tupla["hora"] == $hora) {
                    echo $tupla["grupo"] . "<br>";
                }
            }
            //para que el aula no se repita
            foreach ($horario as $tupla) {
                if ($tupla["dia"] == $dia && $tupla["hora"] == $hora) {
                    echo $tupla["aula"];
                    break;
                }
            }
            echo "</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";

//otra version de la tabla
$dias[1] = "Lunes";
$dias[] = "Martes";
$dias[] = "Miércoles";
$dias[] = "Jueves";
$dias[] = "Viernes";

$horas[1] = "8:15 - 9:15";
$horas[] = "9:15 - 10:15";
$horas[] = "10:15 - 11:15";
$horas[] = "11:15 - 11:15";
$horas[] = "11:45 - 12:45";
$horas[] = "12:45 - 13:45";
$horas[] = "13:45 - 14:45";

echo "<table class='text_centrado'>";
echo "<tr>";
echo "<th></th>";
for ($k = 1; $k <= count($dias); $k++)
    echo "<th>" . $dias[$k] . "</th>";
echo "</tr>";

for ($hora = 1; $hora <= count($horas); $hora++) {
    echo "<tr>";
    echo "<td>" . $horas[$hora] . "</td>";
    if ($hora == 4) {
        echo "<td colspan='5'>RECREO</td>";
    } else {
        for ($dia = 1; $dia <= count($dias); $dia++) {
            if (isset($horario_grupo[$dia][$hora]))
                echo "<td>" . $horario_grupo[$dia][$hora];
            else
                echo "<td>";

            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' name='dia' value='" . $dia . "'>";
            echo "<input type='hidden' name='hora' value='" . $hora . "'>";
            echo "<input type='hidden' name='grupos' value='" . $_POST["grupos"] . "'>";
            echo "<button type='submit' class='enlace' name='btnEditar'>Editar</button>";
            echo "</form>";

            echo "</td>";
        }
    }

    echo "</tr>";
}
echo "</table>";

//mensaje
if (isset($_SESSION["mensaje"])) {
    echo "<p>" . $_SESSION["mensaje"] . "</p>";
    unset($_SESSION["mensaje"]);
}

//select desplegable
/*
<Form method="post" action="index.php">
    <p>
        <label for="grupo">Elija el grupo: </label>
        <select name="grupo" id="grupo">
            <?php
            foreach ($json_grupos["grupos"] as $tupla) {
                if (isset($_POST["grupo"]) && $_POST["grupo"] == $tupla["id_grupo"]) {
                    echo "<option value='" . $tupla["id_grupo"] . "' selected>" . $tupla["nombre"] . "</option>";
                } else {
                    echo "<option value='" . $tupla["id_grupo"] . "'>" . $tupla["nombre"] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="btnHorario">Ver Horario</button>
    </p>
</Form>
*/
//titulillo de editar guardia profesor
echo "<h3>Editando la " . $_POST["hora"] . "º Hora (" . $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h3>";

//tabla de dos columnas
echo "<table>";
echo "<tr><th>Profesor (Aula)</th><th>Acción</th></tr>";
foreach ($datos_celda["profesores"] as $datos) {
    echo "<tr><td>" . $datos["usuario"] . " (" . $datos["nombre"] . ")</td><td><form method='post'><button type='submit' name='btnQuitar' >Quitar</button><input type='hidden' name='grupo' value='" . $id_grupo . "'/><input type='hidden' name='dia' value='" . $dia . "'/><input type='hidden' name='hora' value='" . $hora . "'/><input type='hidden' name='id_usuario' value='" . $datos["id_usuario"] . "'/></form></td></tr>";
}
echo "</table>";

$app->post('/producto/insertar',function($request){

    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $datos[]=$request->getParam("cod");
                $datos[]=$request->getParam("nombre");
                $datos[]=$request->getParam("nombre_corto");
                $datos[]=$request->getParam("descripcion");
                $datos[]=$request->getParam("PVP");
                $datos[]=$request->getParam("familia");

                echo json_encode(insertar_producto($datos));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));



    
});

function insertar_producto($datos)
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
        $consulta="insert into producto (cod, nombre, nombre_corto,descripcion,PVP, familia) values (?,?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }
   
    $respuesta["mensaje"]="El producto con cod: ".$datos[0]." se ha insertado correctamente";
   

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

$app->put('/producto/actualizar/{codigo}',function($request){

    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $datos[]=$request->getParam("nombre");
                $datos[]=$request->getParam("nombre_corto");
                $datos[]=$request->getParam("descripcion");
                $datos[]=$request->getParam("PVP");
                $datos[]=$request->getParam("familia");
                $datos[]=$request->getAttribute("codigo");

                echo json_encode(actualizar_producto($datos));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

    
    
});

function actualizar_producto($datos)
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
        $consulta="update producto set nombre=?, nombre_corto=?, descripcion=?, PVP=?, familia=? where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }
   
    $respuesta["mensaje"]="El producto con cod: ".end($datos)." se ha actualizado correctamente";
   

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){

    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $tabla=$request->getAttribute("tabla");
                $columna=$request->getAttribute("columna");
                $valor=$request->getAttribute("valor");
                echo json_encode(repetido_insertando($tabla, $columna,$valor));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    
});

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

function repetido_insertando($tabla,$columna,$valor)
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
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=?" ;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"]=$sentencia->rowCount()>0;
        
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function repetido_editando($tabla,$columna,$valor,$columna_id,$valor_id)
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
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=? and ".$columna_id."<>?" ;
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_id]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"]=$sentencia->rowCount()>0;
        
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

if(isset($_POST["btnContNuevo"]))
{
    $error_cod=$_POST["cod"]=="" || strlen($_POST["cod"])>12;
    if(!$error_cod)
    {

        $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
        $url=DIR_SERV."/repetido/producto/cod/".urlencode($_POST["cod"]);
        $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
        $json_repetido=json_decode($respuesta,true);
        if(!$json_repetido)
        {
            session_destroy();
            die(error_page("Actividad 6","<p>Error consumiendo el servico rest: <strong>".$url."</strong></p>"));
        }


        if(isset($json_repetido["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if(isset($json_repetido["error"]))
        {
            session_destroy();
            die(error_page("Actividad 6","<p>".$json_repetido["error"]."</p>"));
        }

        if(isset($json_repetido["mensaje_baneo"]))
        {
            session_unset();//Me deslogueo
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_cod=$json_repetido["repetido"];
    }

    $error_nombre_corto=$_POST["nombre_corto"]=="";
    if(!$error_nombre_corto)
    {
        $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
        $url=DIR_SERV."/repetido/producto/nombre_corto/".urlencode($_POST["nombre_corto"]);
        $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
        $json_repetido=json_decode($respuesta,true);
        if(!$json_repetido)
        {
            session_destroy();
            die(error_page("Actividad 6","<p>Error consumiendo el servico rest: <strong>".$url."</strong></p>"));
        }


        if(isset($json_repetido["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if(isset($json_repetido["error"]))
        {
            session_destroy();
            die(error_page("Actividad 6","<p>".$json_repetido["error"]."</p>"));
        }

        if(isset($json_repetido["mensaje_baneo"]))
        {
            session_unset();//Me deslogueo
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_nombre_corto=$json_repetido["repetido"];
    }
    $error_descripcion=$_POST["descripcion"]=="";
    $error_PVP=$_POST["PVP"]=="" || !is_numeric($_POST["PVP"]) || $_POST["PVP"]<=0;

    $error_form=$error_cod || $error_nombre_corto || $error_descripcion || $error_PVP;

    if(!$error_form)
    {
        //inserto y salto con mensaje

        $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
        $url=DIR_SERV."/producto/insertar";
        unset($_POST["btnContNuevo"]);
        $respuesta=consumir_servicios_JWT_REST($url,"POST",$headers,$_POST);
        $json_insertar=json_decode($respuesta,true);
        if(!$json_insertar)
        {
            session_destroy();
            die(error_page("Actividad 6","<p>Error consumiendo el servico rest: <strong>".$url."</strong></p>"));
        }

        if(isset($json_insertar["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if(isset($json_insertar["error"]))
        {
            session_destroy();
            die(error_page("Actividad 6","<p>".$json_insertar["error"]."</p>"));
        }

        if(isset($json_insertar["mensaje_baneo"]))
        {
            session_unset();//Me deslogueo
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje"]="¡¡ Producto insertado con éxito !!";
        header("Location:index.php");
        exit;

    }

}

if(isset($_POST["btnContEditar"]))
{
   

    $error_nombre_corto=$_POST["nombre_corto"]=="";
    if(!$error_nombre_corto)
    {
        $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
        $url=DIR_SERV."/repetido/producto/nombre_corto/".urlencode($_POST["nombre_corto"])."/cod/".urlencode($_POST["cod"]);
        $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
        $json_repetido=json_decode($respuesta,true);
        if(!$json_repetido)
        {
            session_destroy();
            die(error_page("Actividad 6","<p>Error consumiendo el servico rest: <strong>".$url."</strong></p>"));
        }

        if(isset($json_repetido["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if(isset($json_repetido["error"]))
        {
            session_destroy();
            die(error_page("Actividad 6","<p>".$json_repetido["error"]."</p>"));
        }

        if(isset($json_repetido["mensaje_baneo"]))
        {
            session_unset();//Me deslogueo
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_nombre_corto=$json_repetido["repetido"];
    }
    $error_descripcion=$_POST["descripcion"]=="";
    $error_PVP=$_POST["PVP"]=="" || !is_numeric($_POST["PVP"]) || $_POST["PVP"]<=0;

    $error_form=$error_nombre_corto || $error_descripcion || $error_PVP;

    if(!$error_form)
    {
        //edito y salto con mensaje
        $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
        $url=DIR_SERV."/producto/actualizar/".urlencode($_POST["cod"]);
        unset($_POST["btnContEditar"]);
        unset($_POST["cod"]);
        $respuesta=consumir_servicios_JWT_REST($url,"PUT",$headers,$_POST);
        $json_actualizar=json_decode($respuesta,true);
        if(!$json_actualizar)
        {
            session_destroy();
            die(error_page("Actividad 6","<p>Error consumiendo el servico rest: <strong>".$url."</strong></p>"));
        }

        if(isset($json_actualizar["no_auth"]))
        {
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        if(isset($json_actualizar["error"]))
        {
            session_destroy();
            die(error_page("Actividad 6","<p>".$json_actualizar["error"]."</p>"));
        }

        if(isset($json_actualizar["mensaje_baneo"]))
        {
            session_unset();//Me deslogueo
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje"]="¡¡ Producto actualizado con éxito !!";
        header("Location:index.php");
        exit;

    }

}