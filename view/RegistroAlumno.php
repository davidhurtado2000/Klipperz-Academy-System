<?php
session_start();

if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Registrar Alumno</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/login.css" type="text/css" rel="stylesheet" >
        <link href="../css/AlumnoRegistro.css" type="text/css" rel="stylesheet" >
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
            <div class="container my-3  border-2 border-dark rounded">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="ViewMainMenu.php">
                            <input type="submit" class="btn btn-secondary" value="← Regresar">
                        </form>

                    </div>
                    <form action="../controller/ControllerRegistrarAlumno.php" method="post" enctype="multipart/form-data" onsubmit="return validateFileImg()">
                        <div class="form-group border-bottom border-dark">
                            <label for="dni">DNI</label>
                            <img src="../img/imgRegistroAlumno/dni.png" alt="Responsive image" id="imgRegis" ><input type="text"
                                class="form-control border-0" placeholder="Ingresar el DNI" id="dni"
                                name="dni" maxlength="8" minlength="8" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="nombres">Nombre Completo</label>
                            <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" ><input type="text"
                                class="form-control border-0" id="nombres" name="nombres" placeholder="Ingrese el Nombre Completo" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="fch_nacimiento">Fecha de Nacimiento</label>
                            <img src="../img/imgRegistroAlumno/info.png" alt="Responsive image" id="imgRegis" class="my-2"><input type="date"
                                class="form-control border-0" id="fch_nacimiento" name="fch_nacimiento" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="correo">Correo electronico</label>
                            <img src="../img/imgRegistroAlumno/email_icon.png" alt="Responsive image" id="imgRegis"><input type="text"
                                class="form-control border-0" placeholder="Ingresar el Correo Electronico"
                                id="correo" name="correo" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="distrito">Distrito</label>
                            <img src="../img/imgRegistroAlumno/city.png" alt="Responsive image" id="imgRegis"><input type="text"
                                class="form-control border-0" placeholder="Ingresar el Distrito" 
                                id="distrito" name="distrito" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="telef">Telefono</label>
                            <img src="../img/imgRegistroAlumno/telephone.png" alt="Responsive image" id="imgRegis"><input type="text"
                                class="form-control border-0" placeholder="Ingresar el Numero Telefonico" minlength="9"
                                id="telef" name="telef" maxlength="12" required>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="descrip">Como conocio la academia</label>
                            <img src="../img/imgRegistroAlumno/i_icon.png" alt="Responsive image" id="imgRegis"><textarea type="text"
                                class="form-control border-0" placeholder="Ingresar Descripcion"
                                id="descrip" name="descrip" maxlength="1000" rows="5" required></textarea>
                        </div>

                        <div class="form-group border-bottom border-dark">
                            <label for="fotosubida">Foto de Perfil</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
                            <img src="../img/imgRegistroAlumno/profile_icon.png" alt="Responsive image" id="imgRegis"><input type="file"
                                class="form-control border-0" placeholder="Foto" name="fotosubida" id="fotosubida" required>

                        </div>
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="btn-group-vertical pt-2" style="background-color: white;">
                                <input type="hidden" name="user" id="user" value="<?php echo $_SESSION["user"] ?>">
                                <input type="submit" name="submit" class="btn btn-primary border border-dark"
                                    value="Registrar Alumno">
                            </div>
                        </div>
                    </form>

                    <script>
                        function validateFileImg(){
                            var fileInput = document.getElementById('fotosubida');
                            var file = fileInput.files[0];

                            if (file) {
                                var fileName = file.name;
                                var fileExt = fileName.split('.').pop().toLowerCase();

                                if (fileExt == 'png' || fileExt == 'jpg'){
                                    return true;
                                }
                                else{
                                    alert('Porfavor ingresar una imagen PNG');
                                    return false;
                                }
                            }else{
                                alert('Porfavor ingresar una imagen');
                                return false;
                            }

                        }
                    </script>
                </div>
            </div>
        </div>

    </body>



    </html>

    <?php
}
?>