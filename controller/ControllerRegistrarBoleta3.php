<?php
session_start();

include_once 'ControllerAlumnos.php';
$obj = new ControllerAlumnos();

if (isset($_POST['submit'])) {

    $_SESSION['valor_dni'] = $_POST['valor_dni'];
    $idclase = $_POST["idclase"];
    $numboleta = $_POST["numboleta"];
    $pago = $_POST["pago2"];
    $fecha = $_POST["fch_registro"];

    $obj->ControllerRegistarBoleta3($numboleta, $pago, $fecha, $idclase);
    header("Location:../view/VerClases.php");

} else {
    echo "Error";
}

?>