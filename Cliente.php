<?php
class Cliente
{

    //ATRIBUTOS

    private $denominacion;
    private $cuit;
    private $estado;  //al día, moroso, suspendido


    //CONSTRUCTOR
    public function __construct($denominacion, $cuit, $estado)
    {

        $this->denominacion = $denominacion;
        $this->cuit = $cuit;
        $this->estado = $estado;
    }

    public function getDenominacion()
    {
        return $this->denominacion;
    }
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;
    }

    public function getCuit()
    {
        return $this->cuit;
    }
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }


    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    public function __toString()
    {
        //string $cadena
        $cadena = "Denominacion: " . $this->getDenominacion() . "\n";
        $cadena = $cadena . "CUIT: " . $this->getCuit() . "\n";
        $cadena = $cadena . "Estado: " . $this->getEstado() . "\n";

        return $cadena;
    }
}
