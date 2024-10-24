<?php
function tiene_vocales($texto){
    $vocales["a"] = 1;
    $vocales["A"] = 1;
    $vocales["e"] = 1;
    $vocales["E"] = 1;
    $vocales["i"] = 1;
    $vocales["I"] = 1;
    $vocales["o"] = 1;
    $vocales["O"] = 1;
    $vocales["u"] = 1;
    $vocales["U"] = 1;
    
}

function mi_explode($separador, $frase)
{
    $aux=[];
    $i=0;
    $l_frase=strlen($frase);
    while($i<$l_frase && $frase[$i]==$separador)
        $i++;
    
        
    if($i<$l_frase)
    {
        $j=0;
        $aux[$j]=$frase[$i];
        for($i=$i+1;$i<$l_frase;$i++)
        {
            if($frase[$i]!=$separador)
            {
                $aux[$j].=$frase[$i];
            }
            else
            {
                while($i<$l_frase && $frase[$i]==$separador)
                    $i++;

                if($i<$l_frase)
                {
                    $j++;
                    $aux[$j]=$frase[$i];
                }
                
            }
        }

    }

    return $aux;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>

<body>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="sep">Elija un separador: </label>
            <select name="sep" id="sep">
                <option <?php if (isset($_POST["sep"]) && $_POST["sep"] == ";") echo "selected"; ?> value=";">; (punto y coma)</option>
                <option <?php if (isset($_POST["sep"]) && $_POST["sep"] == ":") echo "selected"; ?> value=":">: (dos puntos)</option>
                <option <?php if (isset($_POST["sep"]) && $_POST["sep"] == ",") echo "selected"; ?> value=",">, (coma)</option>
                <option <?php if (isset($_POST["sep"]) && $_POST["sep"] == " ") echo "selected"; ?> value=" "> (espacio)</option>
            </select>
        </p>
        <p>
            <label for="texto">Introduzca una frase: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"]; ?>">
            <?php
            if (isset($_POST["btnContar"]) && $error_form)
                echo "<span class='error'>Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnContar">Contar</button>
        </p>
    </form>

    <?php
    if (isset($_POST["btnContar"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        echo "<p>El texto ".$_POST["texto"]." con el separador ".$_POST["separador"]."  es de :" . count(mi_explode($_POST["sep"], $_POST["texto"])) . "</p>";
    }
    ?>
</body>

</html>