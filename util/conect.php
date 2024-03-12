<?php
function getConn()
{
    $mysqli = mysqli_connect('localhost', 'root', '', "kacademy_db");
    if (mysqli_connect_errno())
        echo "Fallo al conectar a la Base de Datos: " . mysqli_connect_error();
    $mysqli->set_charset('utf8');
    return $mysqli;
}