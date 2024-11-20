<h2>Horario de los profesores</h2>
<form action="ejercicio4.php" method="post">
    <p>
        <label for="profesor">Horario del profesor: </label>
        <select name="profesor" id="profesor">
        <?php
        while($linea=fgets($fd))
        {
            $datos_linea=explode("\t",$linea);
            if(isset($_POST["profesor"]) && $_POST["profesor"]==$datos_linea[0])
            {
                echo "<option selected value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
                for($i=1;$i<count($datos_linea);$i+=3)
                {
                    if(isset($datos_profesor[$datos_linea[$i]][$datos_linea[$i+1]]))
                        $datos_profesor[$datos_linea[$i]][$datos_linea[$i+1]].="/".$datos_linea[$i+2];
                    else
                        $datos_profesor[$datos_linea[$i]][$datos_linea[$i+1]]=$datos_linea[$i+2];
                }
            }
            else
                echo "<option value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
        }  
        ?>
        </select>
        <button type="submit" name="btnVerHorario">Ver Horario</button> 
    </p>
</form>
<?php

if(isset($_POST["profesor"]))
{
    echo "<h2 class='text_centrado'>Horario del Profesor: ".$_POST["profesor"]."</h2>";

    echo "<table class='text_centrado'>";
    echo "<tr>";
    for($i=0;$i<count(DIAS_SEMANA);$i++)
        echo "<th>".DIAS_SEMANA[$i]."</th>";
    echo "</tr>";
    for($hora=1;$hora<=7;$hora++)
    {
        echo "<tr>";
        echo "<th>".HORAS[$hora]."</th>";
        if($hora==4)
            echo "<td colspan='5'>RECREO</td>";
        else
        {
            for($dia=1;$dia<=5;$dia++)
            {
                if(isset($datos_profesor[$dia][$hora]))
                    echo "<td>".$datos_profesor[$dia][$hora]."</td>";
                else
                    echo "<td></td>";
            }
        }
        
        echo "</tr>";
    }
    echo "</table>";
}