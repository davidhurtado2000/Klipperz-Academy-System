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
            $pagoAcumulado += $filaPago["pagototal"];
        }

        return $pagoAcumulado;
    }

    function blobToImageTag($blobData, $contentType = 'image/jpeg')
    {
        $base64Image = base64_encode($blobData);
        $imageTag = "<img src='data:$contentType;base64,$base64Image' class='img-fluid img-thumbnail' alt='Responsive image'>";
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
        <link href="../css/AlumnoActualizacion.css" type="text/css" rel="stylesheet" media="">
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
            <form action="../controller/ControllerActualizarAlumno.php" method="post" enctype="multipart/form-data"
                onsubmit="return validateFileImg()" class="w-50 mx-auto">
                <?php foreach ($listaDatosAlumno as $filaAlumno) { ?>
                    <div class="form-group border-bottom border-dark">
                        <label for="dni">DNI</label>
                        <img src="../img/imgRegistroAlumno/dni.png" alt="Responsive image" id="imgRegis"><input type="text"
                            class="form-control border-0" value="<?php echo $filaAlumno["dni"]; ?>"
                            placeholder="Ingresar el DNI" id="dni" name="dni" maxlength="8" minlength="8" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="nombres">Nombre Completo</label>
                        <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis"><input type="text"
                            class="form-control border-0" id="nombres" name="nombres"
                            value="<?php echo $filaAlumno["nombres"]; ?>" placeholder="Ingrese el Nombre Completo" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="fch_nacimiento">Fecha de Nacimiento</label>
                        <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" class="my-2"><input
                            type="date" class="form-control border-0" value="<?php echo $filaAlumno["f_naci"]; ?>"
                            id="fch_nacimiento" name="fch_nacimiento" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="correo">Correo electronico</label>
                        <img src="../img/imgRegistroAlumno/email_icon.png" alt="Responsive image" id="imgRegis"><input
                            type="text" class="form-control border-0" value="<?php echo $filaAlumno["correo"]; ?>"
                            placeholder="Ingresar el Correo Electronico" id="correo" name="correo" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="distrito">Distrito</label>
                        <img src="../img/imgRegistroAlumno/city.png" alt="Responsive image" id="imgRegis"><input type="text"
                            class="form-control border-0" value="<?php echo $filaAlumno["distrito"]; ?>"
                            placeholder="Ingresar el Distrito" id="distrito" name="distrito" required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="telef">Telefono</label>
                        <img src="../img/imgRegistroAlumno/telephone.png" alt="Responsive image" id="imgRegis"><input
                            type="text" class="form-control border-0" value="<?php echo $filaAlumno["telef"]; ?>"
                            placeholder="Ingresar el Numero Telefonico" minlength="9" id="telef" name="telef" maxlength="12"
                            required>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="descrip">Como conocio la academia</label>
                        <img src="../img/imgRegistroAlumno/i_icon.png" alt="Responsive image" id="imgRegis"><textarea
                            type="text" class="form-control border-0" placeholder="Ingresar Descripcion" id="descrip"
                            name="descrip" maxlength="1000" rows="5" required><?php echo $filaAlumno["descrip"]; ?></textarea>
                    </div>

                    <div class="form-group border-bottom border-dark">
                        <label for="fotosubida">Foto de Perfil</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
                        <img src="../img/imgRegistroAlumno/profile_icon.png" alt="Responsive image" id="imgRegis"><input
                            type="file" class="form-control border-0" placeholder="Foto" name="fotosubida" id="fotosubida"
                            required>

                    </div>

                <?php } ?>

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="btn-group-vertical pt-2" style="background-color: white;">
                        <input type="hidden" name="user" id="user" value="<?php echo $_SESSION["user"] ?>">
                        <input type="hidden" name="valor_dni" id="valor_dni" value="<?php echo $_POST["valor_dni"] ?>">
                        <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $_POST["idalumno"] ?>">
                        <input type="submit" name="submit" class="btn btn-primary border border-dark"
                            value="Registrar Alumno">
                    </div>
                </div>
            </form>


        </div>

    </body>

    </html>
    <?php
}
?>