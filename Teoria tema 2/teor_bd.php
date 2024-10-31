<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, td, th{
            border: 1px solid black;
        }
        table{
            border-collapse: collapse;
            
        }
    </style>
    <title>Teoría BD</title>
</head>

<body>
    <h1>Teoría BD</h1>
    <?php
    const SERVIDOR_BD = "localhost";
    const USUARIO_BD = "jose";
    const CLAVE_BD = "josefa";
    const NOMBRE_BD = "bd_teoria";
    try {
        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido conecatra a la BD: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<h2>Conexión bien</h2>";

    try {
        $consulta = "select * from t_alumnos";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<h2>Consulta bien</h2>";

    $n_tuplas = mysqli_num_rows($resultado);
    echo "<p>El número de alumnos en la tabla t_alumnos es: " . $n_tuplas . "</p>";


    echo "<h3>Mostrando las tuplas</h3>";
    $tupla = mysqli_fetch_assoc($resultado);
    echo "El nombre del primer alumno obtenido es: ". $tupla["nombre"] ."</p>";
    $tupla = mysqli_fetch_row($resultado);
    echo "El telefono del segundo alumno obtenido es: ". $tupla[2] ."</p>";
    $tupla = mysqli_fetch_object($resultado);
    echo "El CP del tercer alumno obtenido es: ". $tupla->cp ."</p>";
    mysqli_data_seek($resultado,1);
    $tupla = mysqli_fetch_array($resultado);

    //cuando deje de consultar se libera
    //mysqli_free_result($resultado);

    echo "El nombre del segundo alumno obtenido es: ". $tupla[1] .", y el teléfono: " . $tupla["telefono"] ."</p>";

    mysqli_data_seek($resultado,0);

    echo "<table>";
    echo "<tr><th>Código</th><th>Nombre</th><th>Teléfono</th><th>CP</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr><td>".$tupla["cod_alu"]."</td><td>".$tupla["nombre"]."</td><td>".$tupla["telefono"]."</td><td>".$tupla["cp"]."</td></tr>";
    }
    echo "</table>";

    mysqli_data_seek($resultado,0);

    try {
        $consulta2 = "select t_alumnos.nombre, t_notas.nota from t_alumnos
        join t_notas on t_alumnos.cod_alu = t_notas.cod_alu
        where t_alumnos.cod_alu = 100";
        $resultado2 = mysqli_query($conexion, $consulta2);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<h2>Consulta notas bien</h2>";
    $tupla2 = mysqli_fetch_assoc($resultado2);

    echo "<table>";
    echo "<tr><th>Nombre</th><th>Asignatura</th><th>Nota</th></tr>";
    while ($tupla2 = mysqli_fetch_assoc($resultado)) {
        echo "<tr><td>".$tupla2["nombre"]."</td><td>".$tupla2["cod_asig"]."</td><td>".$tupla["nota"]."</td></tr>";
    }
    echo "</table>";




    

    mysqli_close($conexion);
    echo "<h2>Cierre de conexión</h2>";
    ?>
</body>

</html>