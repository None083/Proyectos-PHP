<?php
function obtenerDiaEsp($fecha)
{
    $fecha_recogida = strtotime($fecha);

    $dia_num = date('w', $fecha_recogida);

    $dias_semana = [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado'
    ];

    $dia_esp = $dias_semana[$dia_num];

    return $dia_esp;
}

$nombre_dia = '';

if (isset($_POST["fecha"])) {
    // Si se ha enviado la fecha desde el formulario, se utiliza esa fecha
    $nombre_dia = obtenerDiaEsp($_POST["fecha"]);
} else {
    // Si no se ha enviado ninguna fecha, se utiliza la fecha actual
    $nombre_dia = obtenerDiaEsp(date('Y-m-d'));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: lightgrey;
        }

        #contenedor-form {
            background-color: lightblue;
            border: 2px solid black;
        }

        h1 {
            text-align: center;
            padding: 1rem;
        }

        p,
        button {
            margin-left: 1rem;
            margin-bottom: 1rem;
        }

        #contenedor-resp {
            background-color: lightgreen;
            border: 2px solid black;
            margin-top: 0.5rem;
        }
    </style>
    <title>Reservar aula</title>
</head>

<body>
    <div id="contenedor-form">
        <h1>RESERVAR AULA</h1>
        <form action="index.php" method="post">
            <p>
                <span id="diaEsp"><?php echo $nombre_dia; ?></span>
                <input type="date" name="fecha" id="fecha"
                    value="<?php echo isset($_POST["fecha"]) ? $_POST["fecha"] : date('Y-m-d'); ?>">
                <button type="submit" name="cambiar">Cambiar de día</button>
            </p>
        </form>
        <?php
        //h1 reservar aula
        //form: input de elegir fecha, boton cambiar de dia para refrescar la fecha y ponga el nombre del dia en español al lado del input
        //respuesta: h2 que diga semana del dia1 al dia7
        //fijo siempre: tabla vacia de horario

        if (isset($_POST["cambiar"])) {

            $fecha = $_POST["fecha"];

            function obtenerSemana($fecha)
            {
                $fecha_seg = strtotime($fecha);

                // Si el día es domingo, se ajusta al lunes anterior
                $dia = date('w', $fecha_seg);
                if ($dia == 0) {
                    $dia = 7;
                }

                // Calcular el lunes y domingo de la semana
                $lunes = date('Y-m-d', strtotime("-" . ($dia - 1) . " days", $fecha_seg));
                $domingo = date('Y-m-d', strtotime("+" . (7 - $dia) . " days", $fecha_seg));

                return [$lunes, $domingo];
            }

            $semana = obtenerSemana($_POST["fecha"]);
            echo "<p>Semana del " . date('d/m/Y', strtotime($semana[0])) . " al " . date('d/m/Y', strtotime($semana[1])) . "</p>";
        }
        ?>
    </div>


</body>

</html>