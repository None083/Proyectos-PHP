<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            border-collapse: collapse
        }

        th {
            background-color: #CCC
        }
        
    </style>
    <title>Gestor de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <p>Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
    <form action="index.php" method="post"><button type="submit" name="btnSalir">Salir</button></form>
    </p>
    <h2>Equipos de Guardia del IES Mar de Alborán</h2>
    <table>
        <tr>
            <th></th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
        </tr>
        <?php
        for ($i = 0; $i < 6; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 6; $j++) {
                if ($j === 0) {
                    echo "<td>" . $i + 1 . "ª hora</td>";
                } else {
                    echo "<td><form action='index.php' method='post'><button type='submit' name='btnEquipo' value='" . $i . "'>Equipo" . ($i * 5) + $j . "</button><input type='hidden' name='hora' value='" . $j . "'/></form></td>";
                }
            }
            echo "</tr>";
            if ($i === 2) {
                echo "<tr><td colspan='6'>RECREO</td></tr>";
            }
        }
        ?>
    </table>
    <?php
    if (isset($_POST["btnEquipo"])) {
        echo "dia: " . $_POST["btnEquipo"] . ", hora: " . $_POST["hora"];
        $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
        $url = DIR_SERV . "/usuariosGuardia/" . urlencode($_POST["btnEquipo"]) . "/" . urldecode($_POST["hora"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_usuarios_guardia = json_decode($respuesta, true);
    
        echo "<table>";
        echo "<tr><th>Profesores de Guardia</th><th>Información de profesor con id: ";
        if (isset($_POST["btnProfesor"])) {
            echo $_POST["btnProfesor"];
        }
        echo "</th></tr>";
    
        echo "<tr>";
        echo "<td>";
        foreach ($json_usuarios_guardia["usuario"] as $tupla) {
            echo "<form action='index.php' method='post'>";
            echo "<button type='submit' name='btnProfesor' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button>";
            echo "<input type='hidden' name='btnEquipo' value='" . $_POST["btnEquipo"] . "'>";
            echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'>";
            echo "</form>";
        }
        echo "</td>";
    
        if (isset($_POST["btnProfesor"])) {
            $selected_profesor_id = $_POST["btnProfesor"];
            $headers[] = 'Authorization: Bearer ' . $_SESSION["token"];
            $url = DIR_SERV . "/usuario/" . urlencode($selected_profesor_id);
            $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
            $json_usuario_seleccionado = json_decode($respuesta, true);
    
            echo "<td>";
            echo "<p>Nombre: " . $json_usuario_seleccionado["usuario"]["nombre"] . "</p>";
            echo "<p>Usuario: " . $json_usuario_seleccionado["usuario"]["usuario"] . "</p>";
            echo "<p>Contraseña: </p>";
            echo "<p>Email: " . $json_usuario_seleccionado["usuario"]["email"] . "</p>";
            echo "</td>";
        }
    
        echo "</tr>";
        echo "</table>";
    }
    
    ?>
</body>

</html>