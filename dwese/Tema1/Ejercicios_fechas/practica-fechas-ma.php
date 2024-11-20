<?php
const SEGUNDOS_DIA = 60 * 60 * 24;
const DIAS_SEMANA = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];

if (isset($_POST["cambiar"]) && $_POST["fecha"] != "") {
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
    <title>Practica fechas, solución Miguel Ángel</title>
</head>

<body>
    <div>
        <h1>RESERVAR AULA</h1>
        <form action="practica-fechas-ma.php" method="post">
            <p>
                <span id="diaEsp"><?php echo DIAS_SEMANA[$dia_semana]; ?></span>
                <input type="date" name="fecha" id="fecha"
                    value="<?php echo $fecha; ?>">
                <button type="submit" name="cambiar">Cambiar de día</button>
            </p>
            <p class="texto_centrado">
                Semana <?php echo date("d/m/Y", $primer_dia); ?> del al <?php echo date("d/m/Y", $ultimo_dia); ?>
            </p>
        </form>
    </div>
</body>

</html>