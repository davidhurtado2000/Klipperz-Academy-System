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
        <title>Registro de Alumno</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="../css/login.css" type="text/css" rel="stylesheet">
        <link href="../css/AlumnoRegistro.css" type="text/css" rel="stylesheet">
        <link href="../css/menuprincipal.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="../js/alumno.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    </head>


    <?php include '../header.php'; ?>

    <body class="d-flex flex-column min-vh-100">
        <div class="container-fluid">
            <div class="container my-3  border-2 border-dark rounded">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="ViewMainMenu.php">
                            <input type="submit" class="btn btn-secondary" value="← Regresar al Menu Principal">
                        </form>
                    </div>

                    <form action="../controller/ControllerRegistrarAlumno.php" method="post" enctype="multipart/form-data"
                        onsubmit="return validateFileImg()">

                        <div>
                            <p class="h2 text-center mb-4">Registro de Alumnado Klipperz</p>
                        </div>

                        <div class="form-group mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/dni.png" alt="DNI Icon"
                                        style="height: 20px;"></span>
                                <input type="text" class="form-control" placeholder="Ingresar el DNI..." id="dni" name="dni"
                                    maxlength="8" minlength="8" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nombres" class="form-label">Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/info.png" alt="Info Icon"
                                        style="height: 20px;"></span>
                                <input type="text" class="form-control" id="nombres" name="nombres"
                                    placeholder="Ingrese el Nombre Completo..." required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fch_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/info.png" alt="Date Icon"
                                        style="height: 20px;"></span>
                                <input type="date" class="form-control" id="fch_nacimiento" name="fch_nacimiento" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/email_icon.png"
                                        alt="Email Icon" style="height: 20px;"></span>
                                <input type="text" class="form-control" placeholder="Ingresar el Correo Electrónico..."
                                    id="correo" name="correo" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="distrito" class="form-label">Distrito</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/city.png" alt="City Icon"
                                        style="height: 20px;"></span>
                                <input type="text" class="form-control" placeholder="Ingresar el Distrito..." id="distrito"
                                    name="distrito" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="telef" class="form-label">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/telephone.png"
                                        alt="Phone Icon" style="height: 20px;"></span>
                                <input type="text" class="form-control" placeholder="Ingresar el Número Telefónico..."
                                    minlength="9" id="telef" name="telef" maxlength="12" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="descrip" class="form-label">¿Cómo conoció la academia?</label>
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/i_icon.png"
                                        alt="Info Icon" style="height: 20px;"></span>
                                <textarea class="form-control" placeholder="Ingresar Descripción..." id="descrip"
                                    name="descrip" maxlength="1000" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="fotosubida" class="form-label">Foto de Perfil</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
                            <div class="input-group">
                                <span class="input-group-text"><img src="../img/imgRegistroAlumno/profile_icon.png"
                                        alt="Profile Icon" style="height: 20px;"></span>
                                <input type="file" class="form-control" name="fotosubida" id="fotosubida" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="hidden" name="user" id="user" value="<?php echo $_SESSION['user']; ?>">
                            <input type="submit" name="submit" class="btn btn-primary px-5" value="Registrar Alumno">
                        </div>
                    </form>


                    <script>
                        function validateFileImg() {
                            var fileInput = document.getElementById('fotosubida');
                            var file = fileInput.files[0];

                            if (file) {
                                var fileName = file.name;
                                var fileExt = fileName.split('.').pop().toLowerCase();

                                if (fileExt == 'png' || fileExt == 'jpg') {
                                    return true;
                                }
                                else {
                                    alert('Porfavor ingresar una imagen PNG');
                                    return false;
                                }
                            } else {
                                alert('Porfavor ingresar una imagen');
                                return false;
                            }

                        }
                    </script>
                </div>
            </div>
        </div>

    </body>


    <?php include '../footer.php'; ?>


    </html>

    <?php
}
?>