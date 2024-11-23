<?php
session_start();
require "src/funciones_const.php";

//Conexión con BD
try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die(error_page("Examen 2", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}

// Consulta para obtener los datos del horario del profesor
if (isset($_POST["verHorario"])) {
    try {
        $id_usuario = $_POST["select_usuarios"];
        $consulta = "
                select horario_lectivo.dia, horario_lectivo.hora, grupos.id_grupo, grupos.nombre, usuarios.id_usuario from usuarios
                join horario_lectivo on horario_lectivo.usuario = usuarios.id_usuario
                join grupos on grupos.id_grupo = horario_lectivo.grupo
                where id_usuario = " . $id_usuario . ";";

        $result_horario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        die(error_page("Práctica examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}


// Consulta para listar usuarios
try {
    $consulta = "select * from usuarios";
    $datos_usuario = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    die(error_page("Práctica 8", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 90%;
            margin: 0 auto;
        }
        .enlace {
            background: none;
            color: blue;
            cursor: pointer;
            border: none;
            text-decoration: underline;
        }
    </style>
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <p>
            Horario del profesor:
            <?php
            echo "<select name='select_usuarios' id='select_usuarios'>";
            while ($tupla = mysqli_fetch_assoc($datos_usuario)) {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            ?>
            <button type="submit" name="verHorario">Ver Horario</button>
        </p>
    </form>
    <?php
    if (isset($_POST["verHorario"]) || isset($_POST["btnEditar"])) {
        $resultado = [];
        while ($tupla = mysqli_fetch_assoc($result_horario)) {
            $resultado[] = $tupla;
        }
        $horas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($hora = 0; $hora < count($horas); $hora++) {
            echo "<tr><th>" . $horas[$hora] . "</th>";
            if ($hora == 3) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 0; $dia < 5; $dia++) {
                    $grupos="";
                    echo "<td>";
                    foreach ($resultado as $value) {
                        if ($value["dia"] == $dia + 1 && $value["hora"] == $hora + 1) {
                            if ($grupos == "") {
                                $grupos = $value["nombre"];
                            }else{
                                $grupos .= " / " . $value["nombre"];
                            }
                        }
                    }
                    echo $grupos;
                    echo "<form action='index.php' method='post'><button type='submit' class='enlace' name='btnEditar' value='".$value["id_usuario"]."'>Editar</button><input type='hidden' name='hora' value='".$hora."'><input type='hidden' name='dia' value='".$dia."'></form>";
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        if (isset($_POST["btnEditar"])) {
            echo $_POST["hora"];
        }
    }
    ?>
</body>

</html>