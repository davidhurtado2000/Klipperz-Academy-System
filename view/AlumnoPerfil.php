<?php
session_start();

if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');
    if (isset($_SESSION["valor_dni"]) && isset($_SESSION["idalumno"])) {
        $_POST["valor_dni"] = $_SESSION["valor_dni"];
        $_POST["idalumno"] = $_SESSION["idalumno"];
        unset($_SESSION["idalumno"]);
        unset($_SESSION["valor_dni"]);
    }
    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);
    foreach($listarDatos as $prueba){
        $_SESSION["idadmin"] = $prueba["idadmin"];
    }

    include_once '../controller/ControllerAlumnos.php';
    $objAlumnos = new ControllerAlumnos();
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

    function estadoMuestra($estado)
    {
        if ($estado == 0) {
            return "Inactivo";
        } else {
            return "Activo";
        }
    }

    function pagoTotalActual($listaInfoAdicional)
    {
        $pagoAcumulado = 0;
        foreach ($listaInfoAdicional as $filaPago) {
            $pagoAcumulado += $filaPago["pago1"] + $filaPago["pago2"] +$filaPago["pago3"] ;
        }

        return $pagoAcumulado;
    }

    function blobToImageTag($blobData, $contentType = 'image/jpeg')
    {
        $base64Image = base64_encode($blobData);
        $imageTag = "<img src='data:$contentType;base64,$base64Image' class='img-fluid'  width=100% alt='Responsive image'>";
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

            <?php
            foreach ($listaDatosAlumno as $fila) {
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <?php
                        echo "" . blobToImageTag($fila["photo"]) . "";
                        ?>
                    </div>

                    <div class="col-lg-8 my-2">
                        <div class="col-sm-9" style="float: left; text-align: center;" id="subtitulos">
                            Datos Personales

                        </div>
                        <div class="col-sm-3" style="float: left; text-align: center;">
                            <form action="ActualizarInformacion.php" method="post">
                                <?php
                                echo "<input type='hidden' value='" . $_POST["valor_dni"] . "' id='valor_dni' name='valor_dni'>";
                                echo "<input type='hidden' value='" . $_POST["idalumno"] . "' id='idalumno' name='idalumno'>";
                                ?>
                                <input type="submit" class="btn btn-warning" value="Actualizar Informacion">
                            </form>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo "<b id='titulosDatos'>Nombres: </b>" . $fila["nombres"] . "";
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                echo "<b id='titulosDatos'>Edad:</b> " . calculateAge($fila["f_naci"]) . "";
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo "<b id='titulosDatos'>Telefono: </b>" . $fila["telef"] . "";
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                echo "<b id='titulosDatos'>Correo: </b>" . $fila["correo"] . "";
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo "<b id='titulosDatos'>Distrito: </b>" . $fila["distrito"] . "";
                                ?>
                            </div>
                        </div>

                        <?php
            }
            ?>


                    <div class="col-sm-12" style="float: left; text-align: center;" id="subtitulos">
                        Informacion Adicional
                    </div>

                    <?php
                    if (empty($listaInfoAdicional)) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <b id='titulosDatos'>Nivel Actual: </b>Vacio
                            </div>
                            <div class="col-sm-12">
                                <b id='titulosDatos'>Unforme: </b>Vacio
                            </div>
                            <div class="col-sm-12">
                                <b id='titulosDatos'>Estado: </b>Vacio
                            </div>

                            <?php
                            if (!empty($fila["descrip"])) {
                                ?>
                                <div class="col-sm-12">
                                    <b id="titulosDatos">Como conocio la barberia:</b>
                                    <br>
                                    <textarea class="form-control" rows="10" placeholder="Vacio" disabled><?php
                                    echo "" . $fila["descrip"] . "";
                                    ?></textarea>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-sm-12">
                                    <b id="titulosDatos">Como conocio la barberia:</b>
                                    <br>
                                    <textarea class="form-control" rows="10" placeholder="Vacio" disabled></textarea>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-12" style="float: left; text-align: center;" id="subtitulos">
                            Informacion Financiero
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                Pago Acumulado: S/. 0
                            </div>
                        </div>


                        <?php
                    } else {

                        foreach ($listaInfoAdicional as $filaInfoAdicional) {



                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    echo "<b id='titulosDatos'>Nivel Actual: </b>" . $filaInfoAdicional["nomnivel"] . "";
                                    ?>
                                </div>
                                <div class="col-sm-12">
                                    <?php
                                    echo "<b id='titulosDatos'>Unforme: </b>" . uniformeUtil($filaInfoAdicional["uniforme"]) . "";
                                    ?>
                                </div>
                                <div class="col-sm-12">
                                    <?php
                                    echo "<b id='titulosDatos'>Estado: </b>" . estadoMuestra($filaInfoAdicional["estado"]) . "";
                                    ?>
                                </div>
                                <div class="col-sm-12">
                                    <b id="titulosDatos">Como conocio la barberia:</b>
                                    <br>
                                    <textarea class="form-control" rows="10" placeholder="Vacio" disabled><?php
                                    echo "" . $fila["descrip"] . "";
                                    ?></textarea>
                                </div>
                            </div>


                            <div class="col-sm-12" style="float: left; text-align: center;" id="subtitulos">
                                Informacion Financiero
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    echo "<b id='titulosDatos'>Pago Acumulado: </b>S/. " . pagoTotalActual($listaInfoAdicional) . "";
                                    ?>
                                </div>
                            </div>
                            <?php
                            break;
                        }
                    }
                    ?>
                </div>

            </div>



        </div>

    </body>

    </html>
    <?php
}
?>