<?php
include_once '../util/conect.php';

function getYear()
{
    $mysqli = getConn();
    $id = $_POST['idturno'];
    $mysqli->query("SET lc_time_names = 'es_ES'");
    $query = "SELECT DATE_FORMAT(fechaRegistro, '%Y') AS yearturno FROM clase WHERE turno_idturno = $id 
    GROUP BY DATE_FORMAT(fechaRegistro, '%Y')
    ORDER BY yearturno";
    $result = $mysqli->query($query);
    $year = '<option value="0">Elige la Fecha</option>';
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $year .= "<option value='$row[yearturno]'>$row[yearturno]</option>";
    }
    return $year;
}

echo getYear();