<?php
include_once '../util/Conexion.php';

class ModelFinanciero
{

    public function __construct()
    {
        $con = new Conexion();
    }


    public function _ModelMostrarGananciasGeneral($year)
    {
        try {
            $obj = Conexion::singleton();
            $sql = "SELECT YEAR(fechapago) AS 'Year', MONTH(fechapago) AS 'Month', SUM(pagos) AS 'TotalPagos'
            FROM (
                SELECT fechapago1 AS fechapago, pago1 AS pagos FROM boleta_1 WHERE YEAR(fechapago1) = $year
                UNION ALL
                SELECT fechapago2, pago2 FROM boleta_2 WHERE YEAR(fechapago2) = $year
                UNION ALL
                SELECT fechapago3, pago3 FROM boleta_3 WHERE YEAR(fechapago3) = $year
            ) AS all_data
            GROUP BY YEAR(fechapago), MONTH(fechapago)
            ORDER BY 'Year', 'Month';";

            $query = $obj->prepare($sql);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;

            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function _ModelMostrarGananciasGeneralMes($year, $turno)
    {
        try {
            $obj = Conexion::singleton();
            $sql = "SELECT YEAR(fechapago) AS 'Year', MONTH(fechapago) AS 'Month', SUM(pagos) AS 'TotalPagos', idturno
            FROM (
                SELECT fechapago1 AS fechapago, pago1 AS pagos, turno_idturno FROM boleta_1
                INNER JOIN clase ON boleta_1.idboleta1 = clase.boleta_1_idboleta
                WHERE YEAR(fechapago1) = $year
                
                UNION ALL
                
                SELECT fechapago2, pago2, turno_idturno FROM boleta_2
                INNER JOIN clase ON boleta_2.idboleta2 = clase.boleta_2_idboleta
                WHERE YEAR(fechapago2) = $year
                
                UNION ALL
                
                SELECT fechapago3, pago3, turno_idturno FROM boleta_3
                INNER JOIN clase ON boleta_3.idboleta3 = clase.boleta_3_idboleta
                WHERE YEAR(fechapago3) = $year
            ) AS all_data
            INNER JOIN turno ON all_data.turno_idturno = turno.idturno
            WHERE turno.idturno = $turno
            GROUP BY YEAR(fechapago), MONTH(fechapago)
            ORDER BY 'Year', 'Month';";

            $query = $obj->prepare($sql);

            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function _ModelGetYear(){
        try {
            $obj = Conexion::singleton();
            $sql = "SELECT YEAR(fechapago) AS 'Year'
            FROM (
                SELECT fechapago1 AS fechapago, pago1 AS pagos FROM boleta_1 
                UNION ALL 
                SELECT fechapago2, pago2 FROM boleta_2 
                UNION ALL 
                SELECT fechapago3, pago3 FROM boleta_3
            ) AS all_data 
            GROUP BY YEAR(fechapago)
            ORDER BY 'Year';";
            $query = $obj->prepare($sql);
            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function _ModelGetTurno(){
        try {
            $obj = Conexion::singleton();
            $sql = "SELECT turno_idturno, nombret, nombresp FROM clase
            INNER JOIN turno ON clase.turno_idturno = turno.idturno
            INNER JOIN profesor ON turno.profesor_idprof1=profesor.idprof";
            $query = $obj->prepare($sql);
            $query->execute();
            $vector = $query->fetchAll();
            $query = null;
            return $vector;
        } catch (Exception $e) {
            throw $e;
        }
    }



}

?>