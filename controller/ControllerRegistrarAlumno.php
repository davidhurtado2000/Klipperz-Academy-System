<?php
function imageToBlob($filePath) {
    // Check if the file exists
    if (!file_exists($filePath)) {
        return false;
    }

    // Read the image file
    $imageData = file_get_contents($filePath);

    // Check if the file read was successful
    if ($imageData === false) {
        return false;
    }

    // Encode the image data using base64 encoding
    $base64Data = base64_encode($imageData);

    // Create the data URI for the Blob
    $blobData = 'data:' . mime_content_type($filePath) . ';base64,' . $base64Data;

    return $blobData;
}

include_once 'ControllerAlumnos.php';
$obj = new ControllerAlumnos();

$dni = $_POST["dni"];
$nom_comp = $_POST["nombres"];
$fch_nacimiento = $_POST["fch_nacimiento"];
$fch_nacimiento = date("Y-m-d", strtotime($fch_nacimiento));
$correo = $_POST["correo"];
$distrito = $_POST["distrito"];
$telefono = $_POST["telef"];
$descrip = $_POST["descrip"];
$foto = file_get_contents($_FILES["fotosubida"]['tmp_name']);


$obj->ControllerRegistrarAlumno($dni,$nom_comp,$fch_nacimiento,$correo,$distrito,$telefono,$descrip,$foto);
header('Location:../view/ViewMainMenu.php');


?>