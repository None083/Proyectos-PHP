<?php
session_name("Examen2_23_24");
session_start();
require "src/funciones_const.php";

//Conexión con BD
try {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    session_destroy();
    die(error_page("Examen 2", "<p>No se ha podido conectar a la BD: " . $e->getMessage() . "</p>"));
}

// Quitar
if (isset($_POST["btnQuitar"])) {
    try
    {
        $consulta="delete from horario_lectivo where id_horario='".$_POST["btnQuitar"]."'";
        mysqli_query($conexion,$consulta);
        
    }
    catch(Exception $e)
    {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica Examen 2","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }
}

// Consulta para listar usuarios
try {
    $consulta = "select * from usuarios";
    $result_profesores = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Práctica Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

// Consulta para obtener los datos del horario del profesor
if (isset($_POST["profesor"])) {
    try {
        $id_usuario = $_POST["profesor"];
        $consulta = "
                select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as nom_grupo from horario_lectivo
                join grupos on grupos.id_grupo = horario_lectivo.grupo
                where usuario = " . $id_usuario . ";";

        $result_horario = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }

    $resultado = [];
    while ($tupla = mysqli_fetch_assoc($result_horario)) {
        $resultado[] = $tupla;
    }

    mysqli_free_result($result_horario);
}

if (isset($_POST["dia"])) {
    //consulta para tabla de quitar grupo
    try {
        $consulta = "select id_horario, nombre from horario_lectivo, grupos where horario_lectivo.grupo=grupos.id_grupo AND horario_lectivo.dia='" . $_POST["dia"] . "' AND horario_lectivo.hora='" . $_POST["hora"] . "' AND horario_lectivo.usuario='" . $_POST["profesor"] . "'";

        $result_grupos = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }

    //consulta para select de añadir grupo
    try {
        $consulta = "select * from grupos where id_grupo not in (select grupo from horario_lectivo where dia='" . $_POST["dia"] . "' and hora='" . $_POST["hora"] . "' and usuario='" . $_POST["profesor"] . "')";

        $result_grupos_restantes = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Práctica Examen 2", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }
}

mysqli_close($conexion);

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

        th {
            background-color: lightgrey;
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

        .centrado {
            text-align: center
        }

        #tabla_editar {
            width: 30%;
            margin: 0;
            margin-bottom: 1rem;
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
            <select name='profesor' id='profesor'>
                <?php
                while ($tupla = mysqli_fetch_assoc($result_profesores)) {
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $tupla["id_usuario"]) {
                        echo "<option selected value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                        $nombre_profesor = $tupla["nombre"];
                    } else {
                        echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                    }
                }
                mysqli_free_result($result_profesores);
                ?>
            </select>
            <button type="submit" name="verHorario">Ver Horario</button>
        </p>
    </form>
    <?php
    if (isset($_POST["profesor"])) {
        echo "<h3 class='centrado'>Horario del profesor: " . $nombre_profesor . "</h3>";
        $horas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($hora = 0; $hora < count($horas); $hora++) {
            echo "<tr><th>" . $horas[$hora] . "</th>";
            if ($hora == 3) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 0; $dia < 5; $dia++) {
                    $grupos = "";
                    echo "<td>";
                    foreach ($resultado as $value) {
                        if ($value["dia"] == $dia + 1 && $value["hora"] == $hora + 1) {
                            if ($grupos == "") {
                                $grupos = $value["nom_grupo"];
                            } else {
                                $grupos .= " / " . $value["nom_grupo"];
                            }
                        }
                    }
                    echo $grupos;
                    echo "<form action='index.php' method='post'>
                    <button type='submit' class='enlace' name='btnEditar' value='" . $id_usuario . "'>Editar</button>
                    <input type='hidden' name='hora' value='" . ($hora + 1) . "'>
                    <input type='hidden' name='dia' value='" . ($dia + 1) . "'>
                    <input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>

                    </form>";
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        if (isset($_POST["dia"])) {
            $dias_semana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
            if ($_POST["hora"] <= 3) {
                echo "<h2>Editando la " . $_POST["hora"] . "ª hora (" . $horas[$_POST["hora"]] . ") del " . $dias_semana[($_POST["dia"] - 1)] . "</h2>";
            } else {
                echo "<h2>Editando la " . ($_POST["hora"] - 1) . "ª hora (" . $horas[($_POST["hora"] - 1)] . ") del " . $dias_semana[($_POST["dia"] - 1)] . "</h2>";
            }

            echo "<table id='tabla_editar'>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";
            while ($tupla = mysqli_fetch_assoc($result_grupos)) {
                echo "<tr><td>" . $tupla["nombre"] . "</td><td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>";
                echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'/>";
                echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                echo "<button type='submit' class='enlace' name='btnQuitar' value='" . $tupla["id_horario"] . "'>Quitar</button>";
                echo "</form></td></tr>";
            }
            echo "</table>";
            mysqli_free_result($result_grupos);

            echo "<select name='grupo' id='grupo'>";
            while ($tupla = mysqli_fetch_assoc($result_grupos_restantes)) {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            mysqli_free_result($result_grupos_restantes);
        }
    }
    ?>
</body>

</html>