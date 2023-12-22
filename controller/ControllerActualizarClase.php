<?php
session_start();

include_once 'ControllerAlumnos.php';
$obj = new ControllerAlumnos();

if (isset($_POST['submit'])) {

    if (!empty($_POST["boleta1"]) && empty($_POST["boleta2"]) && empty($_POST["boleta3"])) {
        $_SESSION['valor_dni'] = $_POST['valor_dni'];
        $_SESSION['idalumno'] = $_POST['idalumno'];
        $idclase = $_POST["idclase"];
        $idboleta = $_POST["idboleta1"];
        $fecha = $_POST["fch_registro"];
        $turno = $_POST["turno"];
        $nivel = $_POST["nivel"];
        $uniforme = $_POST["uniformerpta"];
        $estado = $_POST["estadorpta"];
        $boleta1 = $_POST["boleta1"];
        $pago1 = $_POST["pago1"];
        $fecharegistro1 = $_POST["fecha1"];
        $nota = $_POST["nota"];

        $obj->ControllerActualizarClase($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta);
        header("Location:../view/VerClases.php");
    } elseif (!empty($_POST["boleta1"]) && !empty($_POST["boleta2"]) && empty($_POST["boleta3"])) {
        //Completar la parte del model para realizarlo
        $_SESSION['valor_dni'] = $_POST['valor_dni'];
        $_SESSION['idalumno'] = $_POST['idalumno'];
        $idclase = $_POST["idclase"];
        $idboleta = $_POST["idboleta1"];
        $idboleta2 = $_POST["idboleta2"];
        $fecha = $_POST["fch_registro"];
        $turno = $_POST["turno"];
        $nivel = $_POST["nivel"];
        $uniforme = $_POST["uniformerpta"];
        $estado = $_POST["estadorpta"];
        $boleta1 = $_POST["boleta1"];
        $pago1 = $_POST["pago1"];
        $fecharegistro1 = $_POST["fecha1"];
        $boleta2 = $_POST["boleta2"];
        $pago2 = $_POST["pago2"];
        $fecharegistro2 = $_POST["fecha2"];
        $nota = $_POST["nota"];

        $obj->ControllerActualizarClaseBoleta12($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, $boleta2, $pago2, $fecharegistro2, $idboleta2);
        header("Location:../view/VerClases.php");
    } elseif (!empty($_POST["boleta1"]) && !empty($_POST["boleta2"]) && !empty($_POST["boleta3"])) {
        //Completar la parte del model para realizarlo
        $_SESSION['valor_dni'] = $_POST['valor_dni'];
        $_SESSION['idalumno'] = $_POST['idalumno'];
        $idclase = $_POST["idclase"];
        $idboleta = $_POST["idboleta1"];
        $idboleta2 = $_POST["idboleta2"];
        $idboleta3 = $_POST["idboleta3"];
        $fecha = $_POST["fch_registro"];
        $turno = $_POST["turno"];
        $nivel = $_POST["nivel"];
        $uniforme = $_POST["uniformerpta"];
        $estado = $_POST["estadorpta"];
        $boleta1 = $_POST["boleta1"];
        $pago1 = $_POST["pago1"];
        $fecharegistro1 = $_POST["fecha1"];
        $boleta2 = $_POST["boleta2"];
        $pago2 = $_POST["pago2"];
        $fecharegistro2 = $_POST["fecha2"];
        $boleta3 = $_POST["boleta3"];
        $pago3 = $_POST["pago3"];
        $fecharegistro3 = $_POST["fecha3"];
        $nota = $_POST["nota"];

        $obj->ControllerActualizarClaseBoleta123($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, 
        $boleta2, $pago2, $fecharegistro2, $idboleta2,
        $boleta3, $pago3, $fecharegistro3, $idboleta3);
        header("Location:../view/VerClases.php");
    }

} else {
    echo "Error";
}

?>