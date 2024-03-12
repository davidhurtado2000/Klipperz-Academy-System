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

    public function _ModelMostrarNombreTurno($idturno)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT nombret, nombresp FROM turno 
            INNER JOIN profesor ON turno.profesor_idprof1=profesor.idprof
            WHERE idturno=?');
            $query->bindParam(1, $idturno);
            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelMostrarAlumnosTurnos($idturno, $fecha){
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("SELECT nombres, dni, telef, nomnivel FROM clase
            INNER JOIN turno ON clase.turno_idturno = turno.idturno
            INNER JOIN alumno ON clase.alumno_idalumno = alumno.idalumno
            INNER JOIN nivel ON clase.nivel_idnivel = nivel.idnivel
            WHERE idturno =? AND DATE_FORMAT(clase.fechaRegistro, '%Y-%m') =?
            ORDER BY nombres");
            $query->bindParam(1, $idturno);
            $query->bindParam(2, $fecha);
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