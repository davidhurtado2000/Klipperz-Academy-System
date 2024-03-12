<?php
include_once '../util/conect.php';

function getYear()
{
    $mysqli = getConn();
    $id = $_POST['idturno'];
    $mysqli->query("SET lc_time_names = 'es_ES'");
    $query = "SELECT DATE_FORMAT(fechaRegistro, '%M %Y') AS nombremes, DATE_FORMAT(fechaRegistro, '%Y-%m') AS fechames FROM clase WHERE turno_idturno = $id 
    GROUP BY DATE_FORMAT(fechaRegistro, '%M %Y')
    ORDER BY nombremes";
    $result = $mysqli->query($query);
    $mes = '<option value="0">Elige la Fecha</option>';
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $nombremes = ucfirst($row['nombremes']);
        $mes .= "<option value='$row[fechames]'>$nombremes</option>";
    }
    return $mes;
}

echo getYear();