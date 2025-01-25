<?php
session_start();
if ($_SESSION["user"] == "" && $_SESSION["password-field"] == "") {
    header('Location:../Log-in.php?err=3');
} else {
    date_default_timezone_set('America/Lima');

    // Handle search input
    $busqueda = isset($_POST['buscar_alumno']) ? $_POST["buscar_alumno"] : "vacio";

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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="../css/login.css" type="text/css" rel="stylesheet">
        <link href="../css/menuprincipal.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
    </head>


    <?php include '../header.php'; ?> 

    <body class="d-flex flex-column min-vh-100">
        <div class="container-fluid">
            <div class="row my-2">
                <div class="col-lg-6">
                    <div class="float-start">
                        <?php
                        echo "<p class=h3>Bienvenido " . $_SESSION["nombre_completo"] . "!</p>";
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="float-end">
                        <form action="../controller/ControllerDestruirSession.php" method="post">
                            <input type="submit" class="btn btn-danger" value="Cerrar Sesión">
                        </form>
                    </div>
                </div>
            </div>

            <div class="row" id="actionbuttons">
                <div class="col-lg-2">
                    <form action="RegistroAlumno.php">
                        <input type="submit" class="btn w-100"  id="operationbuttons" value="+ Registrar Nuevo Alumno">
                    </form>
                </div>
                <div class="col-lg-2">
                    <form action="TurnosxMes.php">
                        <input type="submit" class="btn w-100" id="operationbuttons" value="Ver Turnos">
                    </form>
                </div>
                <?php if ($listarDatos[0]['prioridad'] == 1) { ?>
                    <div class="col-lg-2">
                        <form action="ReportesGanancias.php">
                            <input type="submit" class="btn w-100" id="operationbuttons" value="$ Ver Ganancias">
                        </form>
                    </div>
                <?php } ?>
            </div>

            <form action="ViewMainMenu.php" method="POST" class="my-3">
                <div class="row" id="actionbuttons">
                    <div class="col-lg-4">
                        <input type="text" placeholder="Busqueda..." class="form-control rounded" id="buscar_alumno"
                            name="buscar_alumno">
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-success w-100" value="Buscar Alumnos">
                    </div>
                </div>
            </form>

            <div class="table-container my-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped border border-dark">
                        <thead>
                            <th scope="col">Nombres</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Detalles</th>
                        </thead>

                        <?php
                        foreach ($listaAlumnos as $fila) {
                            echo "<form action='AlumnoPerfil.php' method='POST'>";
                            echo "<tr>";
                            echo "<td>" . $fila["nombres"] . "</td>";
                            echo "<td>" . $fila["dni"] . "</td>";
                            echo "<td><input type='hidden' value='" . $fila["dni"] . "' name='valor_dni'>
                            <input type='hidden' value='" . $fila["idalumno"] . "' name='idalumno'>
                            <input type='submit' class='btn btn-sm btn-primary' value='Ver Perfil'></td>";
                            echo "</tr>";
                            echo "</form>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <?php include '../footer.php'; ?> 
    </body>

    </html>

    <?php
}
?>