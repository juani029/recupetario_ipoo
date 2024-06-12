<?php

class ContratoViaWeb extends Contrato
{

    private $porcDescuento;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente, $porcDescuento, $estado)
    {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente, $estado);

        if ($porcDescuento != null) {
            $this->porcDescuento = $porcDescuento;
        } else {
            $this->porcDescuento = 10;
        }
    }

    public function getPorcDescuento()
    {

        return $this->porcDescuento;
    }

    public function setPorcDescuento($porcDescuento)
    {

        $this->porcDescuento = $porcDescuento;
    }

    public function __toString()
    {
        $cadena = parent::__toString();

        $cadena .= "\nPorcentaje de descuento: " . $this->getPorcDescuento();
        return $cadena;
    }

    //METODOS 

    public function calcularImporte()
    {
        $importeContratoPadre = parent::calcularImporte();
        $porcDescuento = $this->getPorcDescuento();
        $descuento =  ($importeContratoPadre * $porcDescuento) / 100;
        $importeContrato = $importeContratoPadre - $descuento;

        return $importeContrato;
    }
}
