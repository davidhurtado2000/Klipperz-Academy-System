<?php
include_once '../model/ModelAlumnos.php';

class ControllerAlumnos{

    public function ControllerBuscarAlumnos($busqueda){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelBuscarAlumnos($busqueda);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerRegistrarAlumno($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto){
        try {
            $obj = new ModelAlumnos();
            $obj->_ModelRegistrarAlumnos($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerActualizarAlumno($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto,$idalumno){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelActualizarAlumno($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto,$idalumno);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerMostrarDatosAlumno($dni){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelMostrarDatosAlumnos($dni);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerInformacionAdicional($dni){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelInformacionAdicionalAlumno($dni);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerConsultarClases($dni){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelConsultarClases($dni);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerConsultarClasesEspecifica($id){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelConsultarClasesEspecifica($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerActualizarClase($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelActualizarClase($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerActualizarClaseBoleta12($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, $boleta2, $pago2, $fecharegistro2, $idboleta2){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelActualizarClaseBoleta12($idclase, $fecha, $turno, $nivel, $uniforme, $estado, 
            $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, 
            $boleta2, $pago2, $fecharegistro2, $idboleta2);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function ControllerActualizarClaseBoleta123($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, 
    $boleta2, $pago2, $fecharegistro2, $idboleta2,
    $boleta3, $pago3, $fecharegistro3, $idboleta3){
        try {
            $obj = new ModelAlumnos();
            return $obj->_ModelActualizarClaseBoleta123($idclase, $fecha, $turno, $nivel, $uniforme, $estado, 
            $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, 
            $boleta2, $pago2, $fecharegistro2, $idboleta2,
            $boleta3, $pago3, $fecharegistro3, $idboleta3);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerRegistarBoleta2($numboleta, $pago, $fecha, $idclase){
        try {
            $obj = new ModelAlumnos();
            $obj->_ModelRegistarBoleta2($numboleta, $pago, $fecha, $idclase);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerRegistarBoleta3($numboleta, $pago, $fecha, $idclase){
        try {
            $obj = new ModelAlumnos();
            $obj->_ModelRegistarBoleta3($numboleta, $pago, $fecha, $idclase);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ControllerRegistarClase($fecha, $turno, $nivel, $uniforme, $estado, $numboleta, $pago1, $fecharegistro1, $nota, $idadmin, $idalumno){
        try {
            $obj = new ModelAlumnos();
            $obj->_ModelInsertarBoleta($fecha, $turno, $nivel, $uniforme, $estado, $numboleta, $pago1, $fecharegistro1, $nota, $idadmin, $idalumno);
        } catch (Exception $e) {
            throw $e;
        }
    }

    

}

?>