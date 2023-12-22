<?php
session_start();

if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');
    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);

    include_once '../controller/ControllerAlumnos.php';
    $objAlumnos = new ControllerAlumnos();
    $listarClasesEspecifica = $objAlumnos->ControllerConsultarClasesEspecifica($_POST["idclase"]);
    $listaDatosAlumno = $objAlumnos->ControllerMostrarDatosAlumno($_POST["valor_dni"]);

    include_once '../controller/ControllerTurno.php';
    $objTurno = new ControllerTurno();
    $listarTurnos = $objTurno->ControllerMostrarTurno();

    include_once '../controller/ControllerNivel.php';
    $objNivel = new ControllerNivel();
    $listarNivel = $objNivel->ControllerMostrarNiveles();

    $idFormBoleta1 = "formboleta1";
    $idFormBoleta2 = "formboleta2";
    $idFormBoleta3 = "formboleta3";
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
        <link href="../css/login.css" type="text/css" rel="stylesheet" media="">
        <link href="../css/AlumnoPerfil.css" type="text/css" rel="stylesheet" media="">
        <link href="../css/ClaseRegistro.css" type="text/css" rel="stylesheet" media="">
        <script type="text/javascript" src="../js/alumno.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

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
                                        <a class="nav-link active" aria-current="page" href="#" onclick="submitRegistroClases()">
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
                        <form action="ActualizarInformacion.php" class="float-end">
                            <input type="submit" class="btn btn-danger" value="Regresar">
                        </form>
                    </div>
                </div>


                <?php

            }
            ?>


            <form action="../controller/ControllerRegistrarBoleta3.php" method="post" class="w-50 mx-auto">

                <?php foreach ($listarClasesEspecifica as $filaDatos) { ?>

                    <div class="h4 text-center">Registro de Boleta 3</div>
                    <div class="form-group border-bottom border-dark">
                        <label for="dni">Numero de Boleta</label>
                        <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" class="my-2"><input
                            type="text" class="form-control border-0" id="numboleta" name="numboleta" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="dni">Pago</label>
                        <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" class="my-2"><input
                            type="text" class="form-control border-0" id="pago2" name="pago2" required>
                    </div>
                    <div class="form-group border-bottom border-dark">
                        <label for="dni">Fecha de Registro</label>
                        <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" class="my-2"><input
                            type="date" class="form-control border-0" id="fch_registro" name="fch_registro" required>
                    </div>

                <?php } ?>

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="btn-group-vertical pt-2" style="background-color: white;">
                        <input type="hidden" name="valor_dni" id="valor_dni" value="<?php echo $_POST["valor_dni"] ?>">
                        <input type="hidden" name="idclase" id="idclase" value="<?php echo $_POST["idclase"] ?>">
                        <input type="submit" name="submit" class="btn btn-primary border border-dark"
                            value="Registrar Boleta 2">
                    </div>
                </div>
            </form>

    </body>

    </html>
    <?php
}
?>