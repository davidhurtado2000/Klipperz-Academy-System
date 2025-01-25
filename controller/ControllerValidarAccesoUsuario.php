<?php
session_start();
include 'ControllerUsuario.php';

$pro = new ControllerUsuario();
IF($_POST["user"] == "" || $_POST["password-field"] == ""){
    header(header: 'Location:../Log-in.php?err=1');
} else{
    $data = $pro->ControllerValidarUsuario($_POST["user"], $_POST["password-field"]);
    foreach($data as $fila){
        $_SESSION['nombre_completo'] = $fila['nombresa']. " ". $fila['apellidosa'];
        $_SESSION['user'] = $fila['username'];
        $_SESSION['password-field'] = $fila['pass'];

    }
    
    if(count($data) == 0)
	    header('Location:../Log-in.php?err=2');
	else {
	    header('Location:../view/ViewMainMenu.php');
	}
}

?>