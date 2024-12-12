<?php
class Empleado
{
    private $nombre;
    private $sueldo;

    public function __construct($nombre_nuevo, $sueldo_nuevo)
    {
        $this->nombre = $nombre_nuevo;
        $this->sueldo = $sueldo_nuevo;
    }

    public function debeImpuestos(){
        if ($this->sueldo > 3000) {
            echo "<p>El empleado <strong>".$this->nombre."</strong> con sueldo <strong>".$this->sueldo."</strong> debe pagar impuestos</p>";
        }else{
            echo "<p>El empleado <strong>".$this->nombre."</strong> con sueldo <strong>".$this->sueldo."</strong> no debe pagar impuestos</p>";
        }
    }

    public function setNombre($nombre_nuevo)
    {
        $this->nombre = $nombre_nuevo;
    }

    public function setSueldo($sueldo_nuevo)
    {
        $this->sueldo = $sueldo_nuevo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

}
