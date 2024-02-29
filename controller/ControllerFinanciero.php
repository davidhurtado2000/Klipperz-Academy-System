<?php
include_once '../model/ModelFinanciero.php';

class ControllerFinanciero{

    public function ControllerMostrarGananciasGenerales($year){
        try {
            $obj = new ModelFinanciero();
            return $obj->_ModelMostrarGananciasGeneral($year);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerGetYear(){
        try {
            $obj = new ModelFinanciero();
            return $obj->_ModelGetYear();
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function ControllerGetTurno(){
        try {
            $obj = new ModelFinanciero();
            return $obj->_ModelGetTurno();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerMostrarGananciasGeneralMes($year, $turno){
        try {
            $obj = new ModelFinanciero();
            return $obj->_ModelMostrarGananciasGeneralMes($year, $turno);
        } catch (Exception $e) {
            throw $e;
        }
    }

}

?>