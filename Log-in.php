<!DOCTYPE html>
<html lang="es">

<head>
  <title>Klipperz Academy System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/login.css" type="text/css" rel="stylesheet" media="">
  <script type="text/javascript" src="js/login.js"></script>
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
          <p class="h1">Klipperz Academy System <img src="img/logoKlipperz.jpg" alt="Responsive image" id="logo_bar">
          </p>
        </div>
      </div>
    </div>
</header>

<body class="d-flex flex-column min-vh-100" style="background-color: transparent;">

  <!--div class="container-fluid	 mt-3 border border-dark w-25" id="formulario"-->
  <div class="container	 mt-3 border border-dark w-50 mb-3" id="formulario">
    <div class="jumbotron text-center">
      <p class="h2">Inicio de Sesion</p>
    </div>
    <div class="row">

      <form action="controller/ControllerValidarAccesoUsuario.php" method="post">
        <div class="form-group border-bottom border-dark">
          <label for="txt-user">Usuario</label>
          <img src="img/user.png" alt="Responsive image" id="iconos"><input type="text" class="form-control border-0"
            placeholder="Ingresar su Usuario" minlength="8" id="user" name="user">

        </div>

        <div class="form-group border-bottom border-dark">
          <label for="txt-pass">Contraseña</label>
          <img src="img/password.png" alt="Responsive image" id="iconos"><input type="password" id="password-field"
            class="form-control border-0" name="password-field" placeholder="Ingresar su contraseña">
        </div>
        <input type="checkbox" onclick="showPassword()"> Mostrar contraseña

        <br>
        <?php
        if (isset($_GET["err"])) {
          if ($_GET["err"] == 1) {
            echo "<label for='formGroupExampleInput2' style='color: red;'>Datos incompletos, ingrese sus datos.</label>";
          } elseif ($_GET["err"] == 2) {
            echo "<label for='formGroupExampleInput2' style='color: red;'>Datos incorrectos, intente nuevamente</label>";
          }
        }
        ?>
        <div class="container d-flex justify-content-center align-items-center">
          <div class="btn-group-vertical" style="background-color: white;">
            <input type="submit" class="btn btn-outline-success " value="Ingresar">
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
</body>

<footer class="mt-auto  text-center ">
  <br>
  <p>© 2023 Copyright</p>
</footer>


</html>