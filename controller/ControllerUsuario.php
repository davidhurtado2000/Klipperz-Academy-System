<?php
include_once '../model/ModelUsuario.php';

class ControllerUsuario{
    public function ControllerValidarUsuario($user, $pass){
        try {
            $obj = new ModelUsuario();
            return $obj->_ModelValidarUsuario($user, $pass);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function ControllerMostrarDatosUsuario($user, $pass){
        try {
            $obj = new ModelUsuario();
            return $obj->_ModelMostrarDatosUsuario($user,$pass);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

?>