<?php
include_once '../model/ModelTurno.php';

class ControllerTurno{

    public function ControllerMostrarTurno(){
        try {
            $obj = new ModelTurno();
            return $obj->_ModelMostrarTurnos();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerMostrarNombreTurno($idturno){
        try {
            $obj = new ModelTurno();
            return $obj->_ModelMostrarNombreTurno($idturno);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
