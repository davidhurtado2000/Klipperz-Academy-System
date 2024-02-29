<?php
session_start();
if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');

    if (isset($_POST['buscar_alumno'])) {
        $busqueda = $_POST["buscar_alumno"];
    } else {
        $busqueda = "vacio";
    }



    include "../controller/ControllerUsuario.php";

    $objDatos = new ControllerUsuario();
    $listarDatos = $objDatos->ControllerMostrarDatosUsuario($_SESSION["user"], $_SESSION["password-field"]);

    include_once '../controller/ControllerAlumnos.php';
    $objAlumnos = new ControllerAlumnos();
    $listaAlumnos = $objAlumnos->ControllerBuscarAlumnos($busqueda);

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Main Menu</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/login.css" type="text/css" rel="stylesheet" media="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
            <div class="row">
                <div class="col-lg-12">

                    <?php if ($listarDatos[0]['prioridad'] == 1) { ?>
                        <form action="ReportesGanancias.php">
                            <input type="submit" class="btn btn-success" value="$ Ver Ganancias">
                        </form>
                    <?php } ?>
                    <br>

                    <!--Esta parte del codigo es del boton para redireccion para registrar un nuevo alumno-->
                    <form action="RegistroAlumno.php">
                        <input type="submit" class="btn btn-primary" value="+ Registrar Nuevo Alumno">
                    </form>



                </div>
            </div>

            <!--Se encarga en la busqueda de los alumnos-->
            <form action="ViewMainMenu.php" method="POST">
                <div class="row my-2">
                    <div class="col-lg-10">
                        <input type="text" placeholder="Busqueda..." class="rounded w-100 pb-2" id="buscar_alumno"
                            name="buscar_alumno">
                    </div>

                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-success" value="Buscar">
                    </div>
                </div>
            </form>
            <div class="table-container">
                <div class="table-responsive my-2">
                    <table class="table table-bordered table-striped border border-dark">
                        <thead style="background: grey">
                            <th scope="col">Nombres</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Detalles</th>
                        </thead>

                        <?php
                        foreach ($listaAlumnos as $fila) {
                            echo "<form action='AlumnoPerfil.php' id='myForm' method='POST'>";
                            echo "<tr>";
                            echo "<td>" . $fila["nombres"] . "</td>";
                            echo "<td>" . $fila["dni"] . "</td>";
                            echo "<td> 
                        <input type='hidden' value='" . $fila["dni"] . "' name='valor_dni'>
                        <input type='hidden' value='" . $fila["idalumno"] . "'  name='idalumno'>
                        <input type='submit' value='Ver Perfil'> 
                        </td>";
                            echo "</tr>";
                            echo "</form>";
                        }

                        ?>

                    </table>
                </div>
            </div>

        </div>
    </body>



    </html>

    <?php
}
?>