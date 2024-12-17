<?php
class Pelicula {
    // Atributos privados
    private $nombre;
    private $anio;
    private $director;
    private $alquilada;
    private $precio;
    private $fechaPrevDev;

    // Constructor
    public function __construct($nombre, $anio, $director, $alquilada, $precio, $fechaPrevDev) {
        $this->nombre = $nombre;
        $this->anio = $anio;
        $this->director = $director;
        $this->alquilada = $alquilada;
        $this->precio = $precio;
        $this->fechaPrevDev = $fechaPrevDev;
    }

    // Métodos para interactuar con los atributos
    public function getNombre() {
        return $this->nombre;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getDirector() {
        return $this->director;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getFechaPrevDev() {
        return $this->fechaPrevDev;
    }

    public function getAlquilada() {
        return $this->alquilada;
    }

    // Método para calcular el recargo por días de retraso
    public function calcularRecargo() {
        $hoy = new DateTime(); // Fecha actual
        $fechaDev = new DateTime($this->fechaPrevDev); // Fecha prevista de devolución

        if ($hoy > $fechaDev) {
            $diasRetraso = $hoy->diff($fechaDev)->days; // Número de días de retraso
            return $diasRetraso * 1.2; // Recargo: 1.2€ por día
        }
        return 0; // Sin recargo
    }
}
?>