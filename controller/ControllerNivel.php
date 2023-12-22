<?php
include_once '../model/ModelNivel.php';

class ControllerNivel{

    public function ControllerMostrarNiveles(){
        try {
            $obj = new ModelNivel();
            return $obj->_ModelMostrarNiveles();
        } catch (Exception $e) {
            throw $e;
        }
    }

}

?>