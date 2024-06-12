<?php

class EmpresaCable
{
    private $col_objPlanes;
    private $col_objCanales;
    private $col_objClientes;
    private $col_objContratos;

    public function __construct($col_objPlanes, $col_objCanales, $col_objClientes, $col_objContratos)
    {

        $this->col_objPlanes = $col_objPlanes;
        $this->col_objCanales = $col_objCanales;
        $this->col_objClientes = $col_objClientes;
        $this->col_objContratos = $col_objContratos;
    }

    //GETTERS
    public function getCol_objPlanes()
    {

        return $this->col_objPlanes;
    }

    public function getCol_objCanales()
    {

        return $this->col_objCanales;
    }

    public function getCol_objClientes()
    {

        return $this->col_objClientes;
    }

    public function getCol_objContratos()
    {

        return $this->col_objContratos;
    }

    // SETTERS

    public function setCol_objPlanes($col_objPlanes)
    {

        $this->col_objPlanes = $col_objPlanes;
    }

    public function setCol_objCanales($col_objCanales)
    {

        $this->col_objCanales = $col_objCanales;
    }

    public function setCol_objClientes($col_objClientes)
    {

        $this->col_objClientes = $col_objClientes;
    }

    public function setCol_objContratos($col_objContratos)
    {

        $this->col_objContratos = $col_objContratos;
    }
    public function __toString()
    {
        $cadena = "Planes: " . $this->getCol_objPlanes() . "\n";
        $cadena .= "Canales: " . $this->getCol_objCanales() . "\n";
        $cadena .= "Clientes: " . $this->getCol_objClientes() . "\n";
        $cadena .= "Contratos: " . $this->getCol_objContratos() . "\n";
        return $cadena;
    }

    //METODOS

    public function incorporarPlan($objPlan)
    {
        $col_objPlanes = $this->getCol_objPlanes();
        $sePuedeIncorporar = true;
        foreach ($col_objPlanes as $plan) {
            $colCanales = $plan->getColCanales();
            $incluyeMG = $plan->getIncluyeMG();
            if ($colCanales === $objPlan->getColCanales() && $incluyeMG === $objPlan->getIncluyeMG()) {
                $sePuedeIncorporar = false;
            }
        }

        if ($sePuedeIncorporar == true) {
            array_push($col_objPlanes, $objPlan);
            $this->setCol_objPlanes($col_objPlanes);
        }
    }

    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb, $costo, $seRenueva, $porcDescuento, $estado)
    {
        $col_objContratos = $this->getCol_objContratos();
        if ($esViaWeb == true) {
            $objContratoWeb = new ContratoViaWeb($fechaDesde, $fechaVenc, $objPlan, $costo, $seRenueva, $objCliente, $porcDescuento, $estado);
            array_push($col_objContratos, $objContratoWeb);
            $this->setCol_objContratos($col_objContratos);
        }
        $objContrato = new Contrato($fechaDesde, $fechaVenc, $objPlan, $costo, $seRenueva, $objCliente, $estado);
        array_push($col_objContratos, $objContrato);
        $this->setCol_objContratos($col_objContratos);
    }

    public function retornarImporteContratos($codigoPlan)
    {
        $col_objContratos = $this->getCol_objContratos();
        $importeContratos = 0;

        foreach ($col_objContratos as $objContrato) {
            if ($objContrato->getObjPlan()->getCodigo() == $codigoPlan) {
                $importeContratos += $objContrato->getCosto();
            }
        }
        return $importeContratos;
    }

    public function pagarContrato($objContrato)
    {
        $importeContrato = $objContrato->calularImporte();
        $objContrato->actualizarEstadoContrato();
        $estadoDelContrato = $objContrato->getEstado();
        $cliente = $objContrato->getObjCliente();
        if ($estadoDelContrato == "MOROSO") {
            $diasEnMora = $objContrato->diasContratoVencido();
            $incremento = $importeContrato * 10 / 100;
            $incrementoTotal = $incremento * $diasEnMora;
            $importeContrato += $incrementoTotal;
            $objContrato->setEstado("AL DIA");
            $cliente->setEstado("AL DIA");
            $objContrato->setSeRenueva(true);
            $objContrato->aumentarUnMes();
        } elseif ($estadoDelContrato == "SUSPENDIDO") {
            $diasEnMora = $objContrato->diasContratoVencido();
            $incremento = $importeContrato * 10 / 100;
            $incrementoTotal = $incremento * $diasEnMora;
            $importeContrato += $incrementoTotal;
            $cliente->setEstado("SUSPENDIDO");
            $objContrato->setSeRenueva(false);
        }
        $objContrato->aumentarUnMes();
        return $importeContrato;
    }
}
