<?php
include_once '../util/Conexion.php';

class ModelTurno
{

    public function __construct()
    {
        $con = new Conexion();
    }


    public function _ModelMostrarTurnos()
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT * FROM turno INNER JOIN profesor ON turno.profesor_idprof1=profesor.idprof');
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