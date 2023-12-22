<?php
session_start();

include_once 'ControllerAlumnos.php';
$obj = new ControllerAlumnos();

$_SESSION['valor_dni'] = $_POST['valor_dni'];
$_SESSION['idalumno'] = $_POST['idalumno'];
$dni = $_POST["dni"];
$nom_comp = $_POST["nombres"];
$fch_nacimiento = $_POST["fch_nacimiento"];
$fch_nacimiento = date("Y-m-d", strtotime($fch_nacimiento));
$correo = $_POST["correo"];
$distrito = $_POST["distrito"];
$telefono = $_POST["telef"];
$descrip = $_POST["descrip"];
$idalumno = $_POST["idalumno"];
$foto = file_get_contents($_FILES['fotosubida']['tmp_name']);


$obj->ControllerActualizarAlumno($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto,$idalumno);
header('Location:../view/AlumnoPerfil.php');


?>