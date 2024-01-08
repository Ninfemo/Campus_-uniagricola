<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location:../../index.php");
}
include("../../conexion.php");

/** Eliminar reporte de la base de datos */

if (isset($_GET['txtIDA'])) {
    $txtID = (isset($_GET['txtIDA'])) ? $_GET['txtIDA'] : "";
  
    $sentencia = $conexion->prepare("DELETE FROM reportes WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("Location:reportes.php");
  }

//seleccionamos todos los reportes
$sentencia2 = $conexion->prepare("SELECT * FROM reportes");
$sentencia2->execute(); //ejecuta la instruccion select para que se muestren los registros
$listaCursos = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../../imagenes/favicon.png">
    <!--CSS-->
    <link href = "estilos/styles-cursos.css?v=71" rel = "stylesheet">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&family=Pixelify+Sans:wght@500&display=swap" rel="stylesheet">
    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class = "">
    <!-- navbar-->
    <nav class="color_verde navbar navbar-expand-md navbar-light" >
        <div class="container-fluid">
            <a class="navbar-letra" href="#">
                <img src="../../imagenes/favicon.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                Universidad AGRICOLA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toggler"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar-toggler">
                <ul class="navbar-nav d-flex  justify-content-center align-items-center ">
                    <li class="nav-item">
                        <a href="index.php" class="derecha nav-link btn btn-light">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="reportes.php" class="nav-link btn btn-light">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a href="cursos.php" class="nav-link btn btn-light">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a href="usuarios.php" class="nav-link btn btn-light">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link btn btn-light">Salir</a>
                    </li>  
                </ul>
            </div>
    </nav>

      <!-- seccion principal -->
    <section class="body-seccion table-responsive-sm">

        
        <div class=" text-center">
            <table class="table">
                <div class = "relleno">
                    <h2>Reportes</h2>
                </div>
                <thead class="letra_new">
                    <tr>
                        <th scope="col">usuario</th>
                        <th scope="col">Reporte</th>
                        <th scope="col">Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!--Para mostrar todos los datos de la tabla usuarios -->
                    <?php
                        $numUsuarios = count($listaCursos);
                        for($i = 0; $i < $numUsuarios; $i++) { 
                            $registro = $listaCursos[$i];
                    ?>
                            <tr class="">
                                <td><?php
                                    echo $registro['usuario']; // Recupera el valor
                    ?>
                                </td> 
                                <td><?php
                                    echo $registro['reporte']; // Recupera el valor
                    ?>
                                </td>
                                <td><?php
                                    echo $registro['fecha']; // Recupera el valor
                    ?>
                                </td>
                                <td>
                                    <a onclick="eliminar()" class="btn btn-dark" href="reportes.php?txtIDA=<?php echo $registro["id"]; ?>" role="button"> Eliminar</a>
                                </td>
                            </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
        </div>

    </section>

    <!-- seccion contacto o pie de pagina-->
    <footer class="color_verde d-flex flex-column align-items-center justify-content-center">
        <div class="row">
            <!--<div class="col text-center">
                <p class="d-flex flex-wrap align-items-center justify-content-center">Lorem ipsum es el texto que se usa
                habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el
                diseño visual antes de insertar el texto final.</p>
            </div>-->
            <div class="col"><br><br><br>
                <img class="footer-logo" src="../../imagenes/favicon.png" width="200em"  alt="favicon de la pagina">
            </div>
            <div class="col  text-center"><br>
                <p class="footer-texto"><h3>Creemos un proyecto juntos</h3></p>
                <div class="iconos-redes-sociales d-flex flex-wrap align-items-center justify-content-center">
                    <a href="https://twitter.com/mosorongo_n" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/nicolasfelipe.mosorongoduarte/" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.linkedin.com/feed/?trk=guest_homepage-basic_nav-header-signin" target="_blank"
                    rel="noopener noreferrer">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://www.instagram.com/nicolasmosorongo/" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://github.com/" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="mailto:mosorongo333@gmail.com" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div>
                <div class="derechos-de-autor">Creado por Nicolas Mosorongo (2023) &#169;</div><br>
            </div>
        </div>
    </footer>

    <script src="js/main.js?v=12"></script>

</body>
    <script>
            function eliminar(){
                alert("¡Usuario eliminado");
            }
            function actualizar(){
                alert("¡notas actualizadas");
            }

            function editar(){

            }
            function crear(){
            alert ("¡Usuario Creado");
            }
            document.addEventListener("DOMContentLoaded", function() {
               // Selecciona el enlace por su ID
                var enlace = document.getElementById("miEnlace");
                // Simula un clic en el enlace
                enlace.click();
            });
    </script> 
</html>
            
