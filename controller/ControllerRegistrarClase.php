<?php
session_start();

include_once 'ControllerAlumnos.php';
$obj = new ControllerAlumnos();

if (isset($_POST['submit'])) {

        $_SESSION['valor_dni'] = $_POST['valor_dni'];
        $_SESSION['idalumno'] = $_POST['idalumno'];
        
        $idadmin = $_SESSION["idadmin"];
        $idalumno = $_POST["idalumno"];

        $fecha = $_POST["fch_registro"];
        $turno = $_POST["turno"];
        $nivel = $_POST["nivel"];
        $uniforme = $_POST["uniformerpta"];
        $estado = $_POST["estadorpta"];
        $numboleta = $_POST["boleta1"];
        $pago1 = $_POST["pago1"];
        $fecharegistro1 = $_POST["fecha1"];
        $nota = $_POST["nota"];

        $obj->ControllerRegistarClase($fecha, $turno, $nivel, $uniforme, $estado, $numboleta, $pago1, $fecharegistro1, $nota, $idadmin, $idalumno);
        header("Location:../view/VerClases.php");
 

}

?>