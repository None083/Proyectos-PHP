<?php
const SEGUNDOS_DIA = 60 * 60 * 24;
const DIAS_SEMANA = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];

if (isset($_POST["fecha"]) && $_POST["fecha"] != "") {
    $fecha = $_POST["fecha"];
} else {
    $fecha = date("Y-m-d");
}

$segundos_fecha = strtotime($fecha);
$dia_semana = date("w", strtotime($fecha));

//Calcular primer y último día de la semana

$dias_pasados = $dia_semana - 1;

if ($dias_pasados == -1) {
    $dias_pasados = 6;
}
$primer_dia = $segundos_fecha - ($dias_pasados * SEGUNDOS_DIA);
$ultimo_dia = $primer_dia + (6 * SEGUNDOS_DIA);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        th,
        td {
            border: 1px solid black;

        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;

        }

        th {
            background-color: #ccc;
        }
    </style>
    <title>Practica fechas, solución Miguel Ángel</title>
</head>

<body>
    <div>
        <h1>RESERVAR AULA</h1>
        <form id="form_fecha" action="practica-fechas-ma-copy.php" method="post">
            <p>
                <span id="diaEsp"><?php echo DIAS_SEMANA[$dia_semana]; ?></span>
                <input type="date" name="fecha" id="fecha"
                    value="<?php echo $fecha; ?>" onchange="document.getElementById('form_fecha').submit()">

            </p>
            <p class="texto_centrado">
                Semana <?php echo date("d/m/Y", $primer_dia); ?> del al <?php echo date("d/m/Y", $ultimo_dia); ?>
            </p>
        </form>
    </div>
    <?php
    $horas[1] = "8:15 - 9:15";
    $horas[] = "9:15 - 10:15";
    $horas[] = "10:15 - 11:15";
    $horas[] = "11:15 - 11:45";
    $horas[] = "11:45 - 12:45";
    $horas[] = "12:45 - 13:45";
    $horas[] = "13:45 - 14:45";

    echo "<table>";
    echo "<tr>";
    echo "<th></th>";
    for ($i = 1; $i <= 5; $i++) {
        echo "<th>" . DIAS_SEMANA[$i] . "</th>";
    }
    echo "</tr>";
    for ($fila = 1; $fila <= 7; $fila++) {
        echo "<tr>";
        echo "<th>" . $horas[$fila] . "</th>";
        if ($fila == 4) {
            echo "<td colspan = '5'>RECREO</td>";
        } else {
            for ($col = 1; $col <= 5; $col++) {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>