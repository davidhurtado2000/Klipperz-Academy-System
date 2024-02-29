<?php
include_once '../util/Conexion.php';

class ModelAlumnos
{

    public function __construct()
    {
        $con = new Conexion();
    }


    public function _ModelBuscarAlumnos($busqueda)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT nombres, dni, idalumno FROM alumno WHERE nombres LIKE "%' . $busqueda . '%"');
            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function _ModelRegistrarAlumnos($dni, $nom_comp, $fch_nacimiento, $correo, $distrito, $telefono, $descrip, $foto)
    {
        try {
            $foto = base64_encode($foto);
            $obj = Conexion::singleton();
            $query = $obj->prepare('INSERT INTO alumno (dni, nombres, f_naci, correo, distrito, telef, descrip, photo) VALUES (?,?,?,?,?,?,?,FROM_BASE64(?))');

            $query->bindParam(1, $dni);
            $query->bindParam(2, $nom_comp);
            $query->bindParam(3, $fch_nacimiento);
            $query->bindParam(4, $correo);
            $query->bindParam(5, $distrito);
            $query->bindParam(6, $telefono);
            $query->bindParam(7, $descrip);
            $query->bindParam(8, $foto);
            if ($query) {
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
            echo $statusMsg, $status;
            $query->execute(); //Ejecuta la consulta SQL

        } catch (PDOException $e) {
            $e->getMessage();
        }
    }


    public function _ModelActualizarAlumno($dni, $nom_comp, $fch_nacimiento, $correo, $distrito, $telefono, $descrip, $foto, $idalumno)
    {
        try {
            $foto = base64_encode($foto);
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE alumno 
                SET 
                    dni = :dni,
                    nombres = :nombres,
                    f_naci = STR_TO_DATE(:f_nacimiento, '%Y-%m-%d'),
                    correo = :correo,
                    distrito = :distrito,
                    telef = :telefono, 
                    descrip = :descrip,
                    photo = FROM_BASE64(:foto)
                WHERE idalumno = :idalumno");
    
            $query->bindParam(':dni', $dni);
            $query->bindParam(':nombres', $nom_comp);
            $query->bindParam(':f_nacimiento', $fch_nacimiento);
            $query->bindParam(':correo', $correo);
            $query->bindParam(':distrito', $distrito);
            $query->bindParam(':telefono', $telefono);
            $query->bindParam(':descrip', $descrip);
            $query->bindParam(':foto', $foto);
            $query->bindParam(':idalumno', $idalumno);
    
            echo $query->execute();

        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function _ModelMostrarDatosAlumnos($dni)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT * FROM alumno WHERE dni=?');

            $query->bindParam(1, $dni);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelInformacionAdicionalAlumno($dni)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT nivel.nomnivel,uniforme,estado,pagototal,alumno.descrip,pago1,pago2,pago3 FROM clase 
            INNER JOIN alumno ON clase.alumno_idalumno=alumno.idalumno
            INNER JOIN nivel ON clase.nivel_idnivel = nivel.idnivel
            INNER JOIN boleta_1 ON clase.boleta_1_idboleta = boleta_1.idboleta1
            LEFT JOIN boleta_2 ON clase.boleta_2_idboleta = boleta_2.idboleta2
            LEFT JOIN boleta_3 ON clase.boleta_3_idboleta = boleta_3.idboleta3
            WHERE alumno.dni=? 
            ORDER BY fechaRegistro DESC');

            $query->bindParam(1, $dni);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelConsultarClases($dni)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT 
            idclase, fechaRegistro, nombret, nomnivel, uniforme, nombresp,nota,
            boleta_1.pago1 AS pago_boleta_1,
            COALESCE(boleta_2.pago2, 0) AS pago_boleta_2,
            COALESCE(boleta_3.pago3, 0) AS pago_boleta_3,
            pagototal,
            tipopago
            FROM clase 
            INNER JOIN alumno ON clase.alumno_idalumno=alumno.idalumno
            INNER JOIN nivel ON clase.nivel_idnivel = nivel.idnivel
            INNER JOIN turno ON clase.turno_idturno = turno.idturno
            INNER JOIN boleta_1 ON clase.boleta_1_idboleta = boleta_1.idboleta1
            LEFT JOIN boleta_2 ON clase.boleta_2_idboleta = boleta_2.idboleta2
            LEFT JOIN boleta_3 ON clase.boleta_3_idboleta = boleta_3.idboleta3
            INNER JOIN profesor ON turno.profesor_idprof1 = profesor.idprof
            WHERE alumno.dni = ?
            ORDER BY fechaRegistro DESC');

            $query->bindParam(1, $dni);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelConsultarClasesEspecifica($id)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT 
            idclase, fechaRegistro, nombret, nomnivel, uniforme, nombresp,nota,idturno, idnivel, estado,
            pago1 AS pago_boleta_1, idboleta1, fechapago1, numboleta1,
            COALESCE(boleta_2.pago2, 0) AS pago_boleta_2, boleta_2.idboleta2, boleta_2.fechapago2,numboleta2,
            COALESCE(boleta_3.pago3, 0) AS pago_boleta_3, boleta_3.idboleta3, boleta_3.fechapago3,numboleta3,
            pagototal,
            tipopago
            FROM clase 
            INNER JOIN alumno ON clase.alumno_idalumno=alumno.idalumno
            INNER JOIN nivel ON clase.nivel_idnivel = nivel.idnivel
            INNER JOIN turno ON clase.turno_idturno = turno.idturno
            INNER JOIN boleta_1 ON clase.boleta_1_idboleta = boleta_1.idboleta1
            LEFT JOIN boleta_2 ON clase.boleta_2_idboleta = boleta_2.idboleta2
            LEFT JOIN boleta_3 ON clase.boleta_3_idboleta = boleta_3.idboleta3
            INNER JOIN profesor ON turno.profesor_idprof1 = profesor.idprof
            WHERE idclase = ?
            ORDER BY fechaRegistro DESC');

            $query->bindParam(1, $id);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    //--Funciones para actualizar los boletos--
    public function ModelActualizarBoleta($boleta1, $pago1, $fecharegistro1, $idboleta)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE boleta_1
            SET
                numboleta1 = '" . $boleta1 . "',
                pago1 = '" . $pago1 . "',
                fechapago1 = '" . $fecharegistro1 . "'
                WHERE idboleta1 = '" . $idboleta . "'");
            echo $query->execute(); //Ejecuta la consulta SQL

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ModelActualizarBoleta2($boleta1, $pago1, $fecharegistro1, $idboleta)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE boleta_2
            SET
                numboleta2 = '" . $boleta1 . "',
                pago2 = '" . $pago1 . "',
                fechapago2 = '" . $fecharegistro1 . "'
                WHERE idboleta2 = '" . $idboleta . "'");
            echo $query->execute(); //Ejecuta la consulta SQL

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ModelActualizarBoleta3($boleta1, $pago1, $fecharegistro1, $idboleta)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE boleta_3
            SET
                numboleta3 = '" . $boleta1 . "',
                pago3 = '" . $pago1 . "',
                fechapago3 = '" . $fecharegistro1 . "'
                WHERE idboleta3 = '" . $idboleta . "'");
            echo $query->execute(); //Ejecuta la consulta SQL

        } catch (Exception $e) {
            throw $e;
        }
    }
    //----------------------------------------------------------------

    public function _ModelActualizarClase($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, $tipopago)
    {
        $this->ModelActualizarBoleta($boleta1, $pago1, $fecharegistro1, $idboleta);
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE clase
            SET
                fechaRegistro = '" . $fecha . "',
                turno_idturno = '" . $turno . "',
                nivel_idnivel = '" . $nivel . "',
                uniforme = '" . $uniforme . "',
                estado = '" . $estado . "',
                pagototal = '" . $pago1 . "',
                nota = '" . $nota . "',
                tipopago = '" . $tipopago . "'
                WHERE idclase = '" . $idclase . "'");
            echo $query->execute(); //Ejecuta la consulta SQL


        } catch (Exception $e) {
            throw $e;
        }
    }
    public function _ModelActualizarClaseBoleta12($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, $tipopago , $boleta2, $pago2, $fecharegistro2, $idboleta2)
    {
        $this->ModelActualizarBoleta($boleta1, $pago1, $fecharegistro1, $idboleta);
        $this->ModelActualizarBoleta2($boleta2, $pago2, $fecharegistro2, $idboleta2);
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE clase
            SET
                fechaRegistro = '" . $fecha . "',
                turno_idturno = '" . $turno . "',
                nivel_idnivel = '" . $nivel . "',
                uniforme = '" . $uniforme . "',
                estado = '" . $estado . "',
                pagototal = '" . $pago1+$pago2. "',
                nota = '" . $nota . "',
                tipopago = '" . $tipopago . "'
                WHERE idclase = '" . $idclase . "'");
            echo $query->execute(); //Ejecuta la consulta SQL


        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelActualizarClaseBoleta123($idclase, $fecha, $turno, $nivel, $uniforme, $estado, $boleta1, $pago1, $fecharegistro1, $nota, $idboleta, $tipopago,
    $boleta2, $pago2, $fecharegistro2, $idboleta2,
    $boleta3, $pago3, $fecharegistro3, $idboleta3)
    {
        $this->ModelActualizarBoleta($boleta1, $pago1, $fecharegistro1, $idboleta);
        $this->ModelActualizarBoleta2($boleta2, $pago2, $fecharegistro2, $idboleta2);
        $this->ModelActualizarBoleta3($boleta3, $pago3, $fecharegistro3, $idboleta3);
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare("UPDATE clase
            SET
                fechaRegistro = '" . $fecha . "',
                turno_idturno = '" . $turno . "',
                nivel_idnivel = '" . $nivel . "',
                uniforme = '" . $uniforme . "',
                estado = '" . $estado . "',
                pagototal = '" . $pago1+$pago2+$pago3 . "',
                nota = '" . $nota . "',
                tipopago = '" . $tipopago . "'
                WHERE idclase = '" . $idclase . "'");
            echo $query->execute(); //Ejecuta la consulta SQL


        } catch (Exception $e) {
            throw $e;
        }
    }

    //--Funciones para insertar y registrar boleta 2--

    function _ModelInsertarBoleta2Clase($idboleta, $idclase)
    {
        try {
            $obj = Conexion::singleton();

            // Update clase table
            $updateQuery = $obj->prepare("UPDATE clase SET boleta_2_idboleta = :idboleta WHERE idclase = :idclase");
            $updateQuery->bindParam(':idboleta', $idboleta);
            $updateQuery->bindParam(':idclase', $idclase);

            // Bind the actual value to the parameter

            if ($updateQuery->execute()) {
                echo "Update successful";
            } else {
                echo "Update failed";
                print_r($updateQuery->errorInfo()); // Print error information
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelRegistarBoleta2($numboleta, $pago, $fecha, $idclase)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('INSERT INTO boleta_2 (numboleta2, pago2, fechapago2) VALUES (?,?,?)');
            $query->bindParam(1, $numboleta);
            $query->bindParam(2, $pago);
            $query->bindParam(3, $fecha);
            $query->execute();
            $query = null;
    
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT idboleta2 FROM boleta_2 WHERE numboleta2=?');
            $query->bindParam(1, $numboleta);
            $query->execute();
    
            $vector = $query->fetch();
            $idboleta = implode("", $vector);
    
            $idboleta = substr($idboleta,  (strlen($idboleta)/2) - strlen($idboleta));
    
            $this->_ModelInsertarBoleta2Clase($idboleta, $idclase);
    
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    //--Funciones para insertar y registrar boleta 3--
    function _ModelInsertarBoleta3Clase($idboleta, $idclase)
    {
        try {
            $obj = Conexion::singleton();

            // Update clase table
            $updateQuery = $obj->prepare("UPDATE clase SET boleta_3_idboleta = :idboleta WHERE idclase = :idclase");
            $updateQuery->bindParam(':idboleta', $idboleta);
            $updateQuery->bindParam(':idclase', $idclase);

            if ($updateQuery->execute()) {
                echo "Update successful";
            } else {
                echo "Update failed";
                print_r($updateQuery->errorInfo()); 
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelRegistarBoleta3($numboleta, $pago, $fecha, $idclase)
    {
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('INSERT INTO boleta_3 (numboleta3, pago3, fechapago3) VALUES (?,?,?)');
            $query->bindParam(1, $numboleta);
            $query->bindParam(2, $pago);
            $query->bindParam(3, $fecha);
            $query->execute();
            $query = null;
    
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT idboleta3 FROM boleta_3 WHERE numboleta3=?');
            $query->bindParam(1, $numboleta);
            $query->execute();
    
            $vector = $query->fetch();
            $idboleta = implode("", $vector);
    
            $idboleta = substr($idboleta,  (strlen($idboleta)/2) - strlen($idboleta));
    
            $this->_ModelInsertarBoleta3Clase($idboleta, $idclase);
    
        } catch (Exception $e) {
            throw $e;
        }
    }

    function _ModelRegistrarClase($fecha, $turno, $nivel, $uniforme, $estado, $pago1, $nota, $idboleta, $idadmin, $idalumno, $tipopago)
    {
        try {
            $null = null;
            $obj = Conexion::singleton();
            $updateQuery = $obj->prepare("INSERT INTO clase(
                pagototal,
                admin_idadmin,
                nivel_idnivel,
                alumno_idalumno,
                boleta_1_idboleta,
                boleta_2_idboleta,
                boleta_3_idboleta,
                turno_idturno,
                fechaRegistro,
                uniforme,
                estado,
                nota,
                tipopago
            )
            VALUES(
                :value1,
                :value2,
                :value3,
                :value4,
                :value5,
                :value6,
                :value7,
                :value8,
                :value9,
                :value10,
                :value11,
                :value12,
                :value13
                )");
            $updateQuery->bindParam(':value1', $pago1);
            $updateQuery->bindParam(':value2', $idadmin);
            $updateQuery->bindParam(':value3', $nivel);
            $updateQuery->bindParam(':value4', $idalumno);
            $updateQuery->bindParam(':value5', $idboleta);
            $updateQuery->bindParam(':value6', $null);
            $updateQuery->bindParam(':value7', $null);
            $updateQuery->bindParam(':value8', $turno);
            $updateQuery->bindParam(':value9', $fecha);
            $updateQuery->bindParam(':value10', $uniforme);
            $updateQuery->bindParam(':value11', $estado);
            $updateQuery->bindParam(':value12', $nota);
            $updateQuery->bindParam(':value13', $tipopago);
            $updateQuery->execute();
            
            
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function _ModelInsertarBoleta($fecha, $turno, $nivel, $uniforme, $estado, $numboleta, $pago1, $fecharegistro1, $nota, $idadmin, $idalumno, $tipopago){
        try {
            $obj = Conexion::singleton();
            $query = $obj->prepare('INSERT INTO boleta_1 (numboleta1, pago1, fechapago1) VALUES (?,?,?)');
            $query->bindParam(1, $numboleta);
            $query->bindParam(2, $pago1);
            $query->bindParam(3, $fecha);
            $query->execute();
            $query = null;
    
            $obj = Conexion::singleton();
            $query = $obj->prepare('SELECT idboleta1 FROM boleta_1 WHERE numboleta1=?');
            $query->bindParam(1, $numboleta);
            $query->execute();
    
            $vector = $query->fetch();
            $idboleta = implode("", $vector);
    
            $idboleta = substr($idboleta,  (strlen($idboleta)/2) - strlen($idboleta));
    
            $this->_ModelRegistrarClase($fecha, $turno, $nivel, $uniforme, $estado, $pago1, $nota, $idboleta, $idadmin, $idalumno, $tipopago);
    
        } catch (Exception $e) {
            throw $e;
        }


    }


}

?>