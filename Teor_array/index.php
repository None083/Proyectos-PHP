<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría array</title>
    <style>
        table, td, th{
            border: 1px, solid, black;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <?php
    //array escalar
    $nota[0] = 5;
    $nota[1] = 9;
    $nota[2] = 8;
    $nota[3] = 5;
    $nota[4] = 6;
    $nota[5] = 7;

    $nota1 = array(5, 9, 8, 5, 7); //otra forma de crear el array

    echo "<p>El número de elementos que tiuene el array nota es: " . count($nota) . "</p>";

    //mostramos un array escalar secuencial
    echo "<h2>Elementos del array nota</h2>";
    echo "<ol>";
    for ($i = 0; $i < count($nota); $i++) {
        echo "<li>" . $nota[$i] . "</li>";
    }
    echo "</ol>";

    var_dump($nota);


    $nota1[13] = 5;
    $nota1[] = 9;
    $nota1[23] = 8;
    $nota1[] = 5;
    $nota1["Juan"] = 6;
    $nota1[2501] = 7;

    echo "<h2>Elementos del array nota1</h2>";
    echo "<br>";
    print_r($nota1);
    echo "<ul>";
    foreach ($nota1 as $key => $valor) {
        echo "<li>Clave: " . $key . ", Valor: " . $valor . "</li>";
    }
    echo "</ul>";

    $nota2 = array(0 => 5, 1 => 9, 8 => 8, "Juan" => 9, 100 => 3);

    //Array asociativo
    $notas["Dani"]["DWESE"] = 7;
    $notas["Dani"]["DWECLI"] = 6;
    $notas["Tomás"]["DWESE"] = 3;
    $notas["Tomás"]["DWECLI"] = 9;
    $notas["Clara"]["DWESE"] = 5.5;
    $notas["Clara"]["DWECLI"] = 6.5;

    echo "<h2>Notas de los alumnos de 2º de DAW</h2>";
    echo "<ol>";
    foreach ($notas as $alumno => $asignaturas) {
        echo "<li>" . $alumno;
        echo "<ul>";
        foreach ($asignaturas as $asignatura => $valor_nota) {
            echo "<li>" . $asignatura . ": " . $valor_nota . "</li>";
        }
        echo "</ul>";
        echo "</li>";
    }
    echo "</ol>";

    //Array asociativo
    $notas["Dani"]= 7;
    $notas["Tomás"] = 3;
    $notas["Clara"] = 5.5;

    echo "<h2>Notas de los alumnos de 2º de DAW en la asignatura DWESE</h2>";
    echo "<table>";
    echo "<tr><th>Alumno</th><th>Nota</th></tr>";
    foreach ($notas as $nombre => $valor_nota20) {
        echo "<tr>";
        echo "<td>".$nombre."</td>";
        echo "<td>".$valor_nota20."</td>";
        echo "</tr>";
    }
    echo "</table>";

    //Otra forma de recorrer
    echo "<table>";
    echo "<tr><th>Alumno</th><th>Nota</th></tr>";
    while (current($notas)) {
        echo "<tr>";
        echo "<td>".key($notas)."</td>";
        echo "<td>".current($notas)."</td>";
        echo "</tr>";
        next($notas);
    }
    echo "</table>";
    /*$variable = 0;
    unset($variable); //destruye variable*/
    ?>
</body>

</html>