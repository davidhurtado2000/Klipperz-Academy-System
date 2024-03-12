<?php 
include_once '../util/conect.php';

function getTurno(){
  $mysqli = getConn();
  $query = 'SELECT * FROM turno';
  $result = $mysqli->query($query);
  $turno = '<option value="0">Elige un Turno</option>';
  while($row = $result->fetch_array(MYSQLI_ASSOC)){
    $turno .= "<option value='$row[idturno]'>$row[nombret]</option>";
  }
  return $turno;
}

echo getTurno();