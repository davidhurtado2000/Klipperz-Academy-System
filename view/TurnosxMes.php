<?php
session_start();
if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');

    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);

    if (isset($_POST["turno"])) {
        $turno = $_POST["turno"];
        $mes = $_POST["mes"];
    } else {
        $turno = "Vacio";
        $mes = "Vacio";
    }

    include "../controller/ControllerTurno.php";

    $objTurno = new ControllerTurno();
    $listaTurno = $objTurno->ControllerMostrarAlumnoTurno($turno, $mes);
    $nombreTurno = $objTurno->ControllerMostrarNombreTurno($turno);


    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Turno por Mes</title>
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
                <div class="col-lg-2 ">
                    <form action="ViewMainMenu.php">
                        <input type="submit" class="btn btn-danger" value="Regresar al Menu Principal">
                    </form>
                </div>
            </div>

            <div class="row my-2">
                <form action="TurnosxMes.php" method="POST">
                    <div class="row my-2">
                        <div class="col-lg-2">
                            <select class="form-select" id="turno" name="turno" required>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="form-select" id="mes" name="mes" required>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-success" value="Consultar">
                        </div>
                    </div>
                </form>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script type="text/javascript" src="../js/turnomes.js"></script>

                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 text-center">
                        <h1 class="display-6"><?php foreach($nombreTurno as $filanomturno){
                            echo "<strong> Turno: </strong>". $filanomturno["nombret"]. ", <strong> Periodo: </strong>".$mes; 
                        }
                        ?></h1>
                    </div>
                </div>
                <div class="table-container">
                    <div class="table-responsive my-2">
                        <table class="table table-bordered table-striped border border-dark">
                            <thead style="background: grey">
                                <th scope="col">Nombres de Alumnos</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Nivel actual</th>
                            </thead>

                            <?php
                            foreach ($listaTurno as $fila) {
                                echo "<tr>";
                                echo "<td>" . $fila["nombres"] . "</td>";
                                echo "<td>" . $fila["dni"] . "</td>";
                                echo "<td>" . $fila["telef"] . "</td>";
                                echo "<td>" . $fila["nomnivel"] . "</td>";
                                echo "</tr>";
                            }

                            ?>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </body>



    </html>

    <?php
}
?>