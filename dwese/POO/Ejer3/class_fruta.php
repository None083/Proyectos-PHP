<?php
class Fruta
{
    private $color;
    private $tamanyo;

    private static $n_frutas = 0;

    public function __construct($color_nuevo, $tamanyo_nuevo)
    {
        $this->color = $color_nuevo;
        $this->tamanyo = $tamanyo_nuevo;
        self::$n_frutas++;
    }

    public function __destruct()
    {
        self::$n_frutas--;
    }

    public static function cuantaFruta(){
        return self::$n_frutas;
    }

    public function setColor($color_nuevo)
    {
        $this->color = $color_nuevo;
    }

    public function setTamanyo($tamanyo_nuevo)
    {
        $this->tamanyo = $tamanyo_nuevo;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTamanyo()
    {
        return $this->tamanyo;
    }

    public function imprimir()
    {
        echo "<h2>Información de mi fruta pera</h2>";
        echo "<p><strong>Color: </strong>" . $this->getColor() . "</br>";
        echo "<strong>Tamaño: </strong>" . $this->getTamanyo() . "</p>";
    }
}
