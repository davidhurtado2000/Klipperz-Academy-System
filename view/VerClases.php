<?php
session_start();

if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {

    if (isset($_SESSION["valor_dni"]) && isset($_SESSION["idalumno"])) {
        $_POST["valor_dni"] = $_SESSION["valor_dni"];
        $_POST["idalumno"] = $_SESSION["idalumno"];
        unset($_SESSION["idalumno"]);
        unset($_SESSION["valor_dni"]);
    }
    date_default_timezone_set('America/Lima');
    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);

    include_once '../controller/ControllerAlumnos.php';
    $objAlumnos = new ControllerAlumnos();
    $listarClases = $objAlumnos->ControllerConsultarClases($_POST["valor_dni"]);
    $listaDatosAlumno = $objAlumnos->ControllerMostrarDatosAlumno($_POST["valor_dni"]);
    $listaInfoAdicional = $objAlumnos->ControllerInformacionAdicional($_POST["valor_dni"]);

    function calculateAge($dob)
    {
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        $age = $today->diff($birthdate)->y;
        return $age;
    }

    function uniformeUtil($uniforme)
    {
        if ($uniforme == 0) {
            return "No";
        } else {
            return "Si";
        }
    }

    function formatToDMY($dateString)
    {
        $dateTime = new DateTime($dateString);
        return $dateTime->format('d-m-Y');
    }

    function nombreDelMes($dateString)
    {
        $mesesEnEspanol = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];
        $dateTime = new DateTime($dateString);
        $nombreMesEnIngles = $dateTime->format('F');
        $nombreMesEnEspanol = $mesesEnEspanol[$nombreMesEnIngles];
        return $nombreMesEnEspanol;
    }


    function blobToImageTag($blobData, $contentType = 'image/jpeg')
    {
        $base64Image = base64_encode($blobData);
        $imageTag = "<img src='data:$contentType;base64,$base64Image' class='img-fluid img-thumbnail' alt='Responsive image'
        height='125' width='75'>";
        return $imageTag;
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Perfil Alumno</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="../css/login.css" type="text/css" rel="stylesheet" media="">
        <link href="../css/AlumnoPerfil.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="../js/alumno.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
        <div class="container-fluid py-2" style="background-color: white;">
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
            <!--ESTA SECCION ES EL NAV BAR-->
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="ViewMainMenu.php">Menu Principal</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <form action="AlumnoPerfil.php" method="post" id="hiddenForm">
                                            <?php
                                            echo "<input type='hidden' name='valor_dni' id='valor_dni' value='" . $_POST["valor_dni"] . "'>";
                                            echo "<input type='hidden' name='idalumno' id='idalumno' value='" . $_POST["idalumno"] . "'>";
                                            ?>
                                        </form>
                                        <a class="nav-link active" aria-current="page" href="#" onclick="submitForm()">Ver
                                            Alumno Perfil</a>
                                    </li>
                                    <li class="nav-item">
                                        <form action="RegistrarClase.php" method="post" id="hiddenRegistroClases">
                                            <?php
                                            echo "<input type='hidden' name='valor_dni' id='valor_dni' value='" . $_POST["valor_dni"] . "'>";
                                            echo "<input type='hidden' name='idalumno' id='idalumno' value='" . $_POST["idalumno"] . "'>";
                                            ?>
                                        </form>
                                        <a class="nav-link active" aria-current="page" href="#"
                                            onclick="submitRegistroClases()">
                                            Registrar Clases</a>
                                    </li>
                                    <li class="nav-item">
                                        <form action="VerClases.php" method="post" id="hiddenFormClases">
                                            <?php
                                            echo "<input type='hidden' name='valor_dni' id='valor_dni' value='" . $_POST["valor_dni"] . "'>";
                                            echo "<input type='hidden' name='idalumno' id='idalumno' value='" . $_POST["idalumno"] . "'>";
                                            ?>
                                        </form>
                                        <a class="nav-link active" aria-current="page" href="#"
                                            onclick="submitFormClases()">Ver Clases</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <!--ESTA SECCION ES EL NAV BAR-->

            <!--DE AQUI PARA ABAJO CAMBIA EL CODIGO -->

            <?php
            foreach ($listaDatosAlumno as $fila) {
                ?>
                <div class="row">
                    <div class="col-sm-4">
                        <?php
                        echo "" . blobToImageTag($fila["photo"]) . "";
                        echo "  Alumno: " . $fila["nombres"] . "";
                        ?>
                    </div>

                    <div class="col-lg-8 my-auto">
                        <form action="RegistrarClase.php" class="float-end" method="post" >
                            <?php
                            echo "<input type='hidden' name='valor_dni' id='valor_dni' value='" . $_POST["valor_dni"] . "'>";
                            echo "<input type='hidden' name='idalumno' id='idalumno' value='" . $_POST["idalumno"] . "'>";
                            ?>
                            <input type="submit" class="btn btn-secondary" value="Registrar Clase">

                        </form>
                    </div>
                </div>


                <?php

            }
            ?>
            <div class="table-container">
                <div class="table-responsive my-2">
                    <table class="table table-bordered table-striped border border-dark">
                        <thead style="background: grey">
                            <th scope="col">Fecha</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Mes</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Uniforme</th>
                            <th scope="col">Pago 1</th>
                            <th scope="col">Pago 2</th>
                            <th scope="col">Pago 3</th>
                            <!--th scope="col">Pago Total</th-->
                            <th scope="col">Nota</th>
                            <th scope="col">Opcion</th>
                        </thead>

                        <?php
                        foreach ($listarClases as $filaClases) {
                            echo "<form action='ActualizarClase.php' id='myForm' method='POST'>";
                            echo "<tr>";
                            echo "<td>" . formatToDMY($filaClases["fechaRegistro"]) . "</td>";
                            echo "<td>" . $filaClases["nombret"] . " - " . $filaClases["nombresp"] . "</td>";
                            echo "<td>" . nombreDelMes($filaClases["fechaRegistro"]) . "</td>";
                            echo "<td>" . $filaClases["nomnivel"] . "</td>";
                            echo "<td>" . uniformeUtil($filaClases["uniforme"]) . "</td>";
                            echo "<td>" . $filaClases["pago_boleta_1"] . "</td>";
                            echo "<td>" . $filaClases["pago_boleta_2"] . "</td>";
                            echo "<td>" . $filaClases["pago_boleta_3"] . "</td>";
                            //echo "<td>" . $filaClases["pagototal"] . "</td>";
                            echo "<td>" . $filaClases["nota"] . "</td>";
                            echo "<td> 
                        <input type='hidden' value='" . $filaClases["idclase"] . "' id='idclase' name='idclase'>
                        <input type='hidden' value='" . $_POST["valor_dni"] . "' id='valor_dni' name='valor_dni'>
                        <input type='hidden' name='idalumno' id='idalumno' value='" . $_POST["idalumno"] . "'>
                        <input type='submit' value='Actualizar'> 
                        </td>";
                            echo "</tr>";
                            echo "</form>";
                        }

                        ?>

                    </table>
                </div>
            </div>
            
    </body>

    </html>
    <?php
}
?>