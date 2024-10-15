<?php

$texto = trim($_POST["string"]);
$texto_sin_tildes = "";

for ($i = 0; $i < mb_strlen($texto, 'UTF-8'); $i++) {
    $caracter = mb_substr($texto, $i, 1, 'UTF-8');
    
    switch ($caracter) {
        case 'á':
            $texto_sin_tildes .= "a";
            break;
        case 'é':
            $texto_sin_tildes .= "e";
            break;
        case 'í':
            $texto_sin_tildes .= "i";
            break;
        case 'ó':
            $texto_sin_tildes .= "o";
            break;
        case 'ú':
            $texto_sin_tildes .= "u";
            break;
        case 'Á':
            $texto_sin_tildes .= "A";
            break;
        case 'É':
            $texto_sin_tildes .= "E";
            break;
        case 'Í':
            $texto_sin_tildes .= "I";
            break;
        case 'Ó':
            $texto_sin_tildes .= "O";
            break;
        case 'Ú':
            $texto_sin_tildes .= "U";
            break;
        default:
            $texto_sin_tildes .= $caracter;
            break;
    }
}

echo "<div id='contenedor-resp'>";
echo "<h1>Quita acentos - Resultado</h1>";
echo "<dl><dt>Texto original</dt>";
echo "<dd>".$texto."</dd>";
echo "<dt>Texto sin acentos</dt>";
echo "<dd>".$texto_sin_tildes."</dd></dl></div>";
?>