<?php
include_once '../util/Conexion.php';

class ModelNivel
{

    public function __construct()
    {
        $con = new Conexion();
    }


    public function _ModelMostrarNiveles()
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT * FROM nivel');
            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }





}

?>