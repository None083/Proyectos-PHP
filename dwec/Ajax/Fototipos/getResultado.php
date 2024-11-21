<?php
$param = $_REQUEST["sum"];
if ($param !== ""){
    if ($param <= 7) {
        echo "<h2>Usted tiene fototipo: I</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 0-7</p>";
        echo "<p>TIPO DE PIEL I: Muy sensible a la luz solar</p>";
    } else if ($param <= 21) {
        echo "<h2>Usted tiene fototipo: II</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 8-21</p>";
        echo "<p>TIPO DE PIEL II: Sensible a la luz solar</p>";
    } else if ($param <= 42) {
        echo "<h2>Usted tiene fototipo: III</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 22-42</p>";
        echo "<p>TIPO DE PIEL III: Sensibilidad normal a la luz solar</p>";
    } else if ($param <= 68) {
        echo "<h2>Usted tiene fototipo: IV</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 43-68</p>";
        echo "<p>TIPO DE PIEL IV: La piel tiene tolerancia a la luz solar</p>";
    } else if ($param <= 84) {
        echo "<h2>Usted tiene fototipo: V</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 69-84</p>";
        echo "<p>TIPO DE PIEL V: La piel es oscura. Alta tolerancia</p>";
    } else {
        echo "<h2>Usted tiene fototipo: VI</h2>";
        echo "<p>Su puntuación en el test fue de: " . $param . "</p>";
        echo "<p id='puntuacion'>PUNTUACIÓN: 85+</p>";
        echo "<p>TIPO DE PIEL VI: La piel es negra. Altísima tolerancia</p>";
    }
    
}
?>