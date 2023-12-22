<?php 
include_once '../util/Conexion.php';

class ModelUsuario
{

    public function __construct()
    {
        $con = new Conexion();
    }

    #Code to validate the user

    public function _ModelValidarUsuario($user, $pass){
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT * FROM admin WHERE username=? AND pass=?');
            $query->bindParam(1, $user);
            $query->bindParam(2, $pass);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelMostrarDatosUsuario($user, $pass){
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT * FROM admin WHERE username=? AND pass=?');
            $query->bindParam(1, $user);
            $query->bindParam(2, $pass);

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