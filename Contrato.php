<?php
/*
 
Adquirir un plan implica un contrato. Los contratos tienen la fecha de inicio, la fecha de vencimiento, el plan, un estado (al día, moroso, suspendido), un costo, si se renueva o no y una referencia al cliente que adquirió el contrato.
*/
class Contrato
{

     //ATRIBUTOS
     private $fechaInicio;
     private $fechaVencimiento;
     private $objPlan;
     private $estado;  //al día, moroso, suspendido
     private $costo;
     private $seRenueva;
     private $objCliente;

     //CONSTRUCTOR
     public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente, $estado)
     {

          $this->fechaInicio = $fechaInicio;
          $this->fechaVencimiento = new DateTime($fechaVencimiento);
          $this->objPlan = $objPlan;
          if ($estado == null) {
               $this->estado = 'AL DIA';
          } else {
               $this->estado = $estado;
          }
          $this->costo = $costo;
          $this->seRenueva = $seRenueva;
          $this->objCliente = $objCliente;
     }


     public function getFechaInicio()
     {
          return $this->fechaInicio;
     }

     public function setFechaInicio($fechaInicio)
     {
          $this->fechaInicio = $fechaInicio;
     }

     public function getFechaVencimiento()
     {
          return $this->fechaVencimiento;
     }

     public function setFechaVencimiento($fechaVencimiento)
     {
          $this->fechaVencimiento = $fechaVencimiento;
     }


     public function getObjPlan()
     {
          return $this->objPlan;
     }

     public function setObjPlan($objPlan)
     {
          $this->objPlan = $objPlan;
     }

     public function getEstado()
     {
          return $this->estado;
     }

     public function setEstado($estado)
     {
          $this->estado = $estado;
     }

     public function getCosto()
     {
          return $this->costo;
     }

     public function setCosto($costo)
     {
          $this->costo = $costo;
     }

     public function getSeRenueva()
     {
          return $this->seRenueva;
     }

     public function setSeRenueva($seRennueva)
     {
          $this->seRenueva = $seRennueva;
     }


     public function getObjCliente()
     {
          return $this->objCliente;
     }

     public function setObjCliente($objCliente)
     {
          $this->objCliente = $objCliente;
     }

     public function __toString()
     {
          $fechaVencimiento = $this->obtenerFechaVencimiento();
          //string $cadena
          $cadena = "Fecha inicio: " . $this->getFechaInicio() . "\n";
          $cadena = "Fecha Vencimiento: " . $fechaVencimiento . "\n";
          $cadena = $cadena . "Plan: " . $this->getObjPlan() . "\n";
          $cadena = $cadena . "Estado: " . $this->getEstado() . "\n";
          $cadena = $cadena . "Costo: " . $this->getCosto() . "\n";
          $cadena = $cadena . "Se renueva: " . $this->getSeRenueva() . "\n";
          $cadena = $cadena . "Cliente: " . $this->getObjCliente() . "\n";


          return $cadena;
     }

     // METODOS

     public function diasContratoVencido()
     {
          $fechaActual = new DateTime('now');
          $fechaVencimiento = $this->getFechaVencimiento();
          $diferencia = $fechaVencimiento->diff($fechaActual);
          return $diferencia->days;
     }

     public function obtenerFechaVencimiento()
     {
          return $this->fechaVencimiento->format('Y-m-d');
     }

     public function aumentarUnMes()
     {
          $newFechaDeVencimiento = $this->getFechaVencimiento();
          $newFechaDeVencimiento->modify('+1 month');
          $this->setFechaVencimiento($newFechaDeVencimiento);
     }

     public function actualizarEstadoContrato()
     {
          $diasVencido = $this->diasContratoVencido();

          if ($diasVencido > 0) {
               $this->setEstado('MOROSO');
          } else if ($diasVencido > 10) {
               $this->setEstado('SUSPENDIDO');
          }
     }

     public function calcularImporte()
     {
          $objPlan = $this->getObjPlan();
          $precioPlan = $objPlan->getImporte();
          $canales = $objPlan->getColCanales();
          $precioTotalCanales = 0;
          foreach ($canales as $unCanal) {
               $precioTotalCanales += $unCanal->getImporte();
          }
          $importeContrato = $precioPlan + $precioTotalCanales;
          $this->setCosto($importeContrato);
          return $importeContrato;
     }
}
