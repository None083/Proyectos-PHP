<?php
$param = $_REQUEST["sum"];
if ($param !== ""){
    if ($param <= 7) {
        echo "TIPO DE PIEL I: Muy sensible a la luz solar";
    } else if ($param <= 21) {
        echo "TIPO DE PIEL II: Sensible a la luz solar";
    } else if ($param <= 42) {
        echo "TIPO DE PIEL III: Sensibilidad normal a la luz solar";
    } else if ($param <= 68) {
        echo "TIPO DE PIEL IV: La piel tiene tolerancia a la luz solar";
    } else if ($param <= 84) {
        echo "TIPO DE PIEL V: La piel es oscura. Alta tolerancia";
    } else {
        echo "TIPO DE PIEL VI: La piel es negra. Altísima tolerancia";
    }
}
?>