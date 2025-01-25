<!DOCTYPE html>
<html lang="es">

<head>
    <title>Klipperz Academy System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/login.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<?php include 'header.php'; ?> 

<body class="d-flex flex-column min-vh-100">


    <div class="container mt-3 border border-dark w-50 mb-3" id="formulario">
        <div class="jumbotron text-center">
            <h2>Inicio de Sesión</h2>
        </div>
        <div class="row">
            <form action="controller/ControllerValidarAccesoUsuario.php" method="post">
                <div class="form-group border-bottom border-dark">
                    <label for="user">Usuario</label>
                    <img src="img/user.png" alt="User Icon" id="iconos">
                    <input type="text" class="form-control border-0" placeholder="Ingresar su Usuario" minlength="8"
                        id="user" name="user" required>
                </div>

                <div class="form-group border-bottom border-dark">
                    <label for="password-field">Contraseña</label>
                    <img src="img/password.png" alt="Password Icon" id="iconos">
                    <input type="password" id="password-field" class="form-control border-0" name="password-field"
                        placeholder="Ingresar su contraseña" required>
                </div>

                <input type="checkbox" onclick="showPassword()"> Mostrar contraseña
                <br>

                <!-- PHP Error Handling -->
                <?php
                if (isset($_GET["err"])) {
                    if ($_GET["err"] == 1) {
                        echo "<label style='color: red;'>Datos incompletos, ingrese sus datos.</label>";
                    } elseif ($_GET["err"] == 2) {
                        echo "<label style='color: red;'>Datos incorrectos, intente nuevamente</label>";
                    }
                }
                ?>

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="btn-group-vertical" style="background-color: white;">
                        <input type="submit" class="btn" id="loginSubmit" value="Ingresar">
                        <br>
                    </div>
                </div>
            </form>

            <div class="container d-flex justify-content-center align-items-center">
                <div class="nonuser">
                    <label for="nonuser">No tienes cuenta?</label>
                    <a href="view/RegistroPaciente_Veri1.php">Registrate aqui</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?> 


    <script type="text/javascript" src="js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function () {
            setTimeout(function () {
                var myDiv = document.getElementById('formulario');
                myDiv.style.display = 'block';
                myDiv.classList.add('show');
            }, 350);
        };
    </script>
</body>

</html>