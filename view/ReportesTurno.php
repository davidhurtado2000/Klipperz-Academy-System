<?php

#NEED TO COMPLETE ISSET FOR THE TURNO VARIABLE AND THEN TRY TO MAKE 2 SELECTION BOXES TO CHOOSE WHICH YEAR AND WHAT TURN TO SEE

session_start();
if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');

    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);

    include "../controller/ControllerFinanciero.php";
    include "../controller/ControllerTurno.php";
    if (isset($_POST["year"])) {
        $year = $_POST["year"];
        //$month = $_POST["month"];
    } else {
        $year = date('Y');
    }
    if (isset($_POST["turno"])) {
        $turno = $_POST["turno"];
    } else {
        $turno = 1;
    }
    $objFinanciero = new ControllerFinanciero();
    $listaDatosFinanciero = $objFinanciero->ControllerMostrarGananciasGeneralMes($year, $turno);

    $objTurno = new ControllerTurno();
    $nombreTurno = $objTurno->ControllerMostrarNombreTurno($turno);

    $spanishMonthNames = array(
        '1' => 'Enero',
        '2' => 'Febrero',
        '3' => 'Marzo',
        '4' => 'Abril',
        '5' => 'Mayo',
        '6' => 'Junio',
        '7' => 'Julio',
        '8' => 'Agosto',
        '9' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    );


    $dataPoints = array();

    foreach ($listaDatosFinanciero as $filaFinanciero) {
        //$temparray = array("x" => $filaFinanciero["Month"], "y" => $filaFinanciero["TotalPagos"]);
        $fullMonthName = $spanishMonthNames[$filaFinanciero["Month"]];
        $temparray = array("label" => $fullMonthName, "y" => ($filaFinanciero["TotalPagos"]));
        array_push($dataPoints, $temparray);
    }

    $listaYear = $objFinanciero->ControllerGetYear();
    $listTurno = $objFinanciero->ControllerGetTurno();


    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <script>
            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light1", // "light1", "light2", "dark1", "dark2"
                    title: {
                        text: "Reporte de Ganancias del Año ".concat("<?php echo $year; ?>"),
                        fontSize: 30
                    },
                    axisY: {
                        title: "Ingresos en Soles",
                        titleFontSize: 20,
                        labelFontSize: 14,
                        tickLength: 0,
                        includeZero: true
                    },
                    axisX: {
                        title: "Meses",
                        titleFontSize: 20,
                        labelFontSize: 14,
                        tickLength: 0,
                        lineThickness: 0
                    },
                    data: [{
                        type: "column",
                        color: "blue",
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });

                for (var i = 0; i < chart.options.data[0].dataPoints.length; i++) {
                    var dataPoint = chart.options.data[0].dataPoints[i];
                    dataPoint.label = dataPoint.y.toFixed(2); // Adjust to desired decimal places
                    dataPoint.indexLabelFontSize = 16;
                    dataPoint.indexLabelFontColor = "black";
                    dataPoint.indexLabelPlacement = "inside";
                    dataPoint.indexLabelBackgroundColor = "rgba(255, 255, 255, 0.7)";
                }

                chart.render();

            }
        </script>
        <title>Main Menu</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/login.css" type="text/css" rel="stylesheet" media="">
        <script type="text/javascript" src="../js/ganancias.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

        <style>
            .table-container {
                max-height: 500px;
                overflow-y: auto;
            }
        </style>
    </head>


    <header>
        <div class="container-fluid" style="background-color: white;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-start">
                        <p class="h1">Klipperz Academy System <img src="../img/logoKlipperz.jpg" alt="Responsive image"
                                id="logo_bar">
                        </p>
                    </div>
                </div>
            </div>
    </header>

    <body class="d-flex flex-column min-vh-100" style="background-color: transparent;">
        <div class="container-fluid" style="background-color: white;">
            <div class="row my-2">
                <div class="col-lg-6">
                    <div class="float-start">
                        <?php
                        echo "<p class=h3 >Usuario: " . $_SESSION["nombre_completo"] . " </p>";
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="float-end">
                        <form action="../controller/ControllerDestruirSession.php" method="post">
                            <input type="submit" class="btn btn-danger " value="Log Out">
                            <br>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-lg-2 float-start" style="margin-right: -65px;">
                    <form action="ReportesGanancias.php">
                        <input type="submit" class="btn btn-success" value="Ver Por Ganancia General">
                    </form>
                </div>
                <div class="col-lg-2 ">
                    <form action="ViewMainMenu.php">
                        <input type="submit" class="btn btn-danger" value="Regresar al Menu Principal">
                    </form>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-lg-12">
                    <div id="chartContainer" style="height: 500px; width: 100%;"></div>
                    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                </div>
                <div class="row my-2">
                    <div class="col-lg-4">
                        <form action="ReportesTurno.php" method="post" id="yeartipoform">
                            <select class="form-select" aria-label="Default select example" name="year" form="yeartipoform">
                                <option style="display:none;" selected>
                                    <?php echo $year ?>
                                </option>
                                <?php foreach ($listaYear as $filaYear) { ?>
                                    <option value="<?php echo $filaYear["Year"]; ?>">
                                        <?php echo $filaYear["Year"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                    </div>
                    <div class="col-lg-4">
                        <select class="form-select" aria-label="Default select example" name="turno" form="yeartipoform">
                            <option style="display:none;" disabled="disabled" selected>
                                <?php foreach ($nombreTurno as $T) {
                                    echo $T["nombret"] . " - " . $T["nombresp"];
                                } ?>
                            </option>
                            <?php foreach ($listTurno as $filaTurno) { ?>
                                <option value="<?php echo $filaTurno["turno_idturno"]; ?>">
                                    <?php echo $filaTurno["nombret"] . " - " . $filaTurno["nombresp"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <input type="submit" class="btn btn-primary" value="Consultar">
                    </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
    </body>



    </html>

    <?php
}
?>