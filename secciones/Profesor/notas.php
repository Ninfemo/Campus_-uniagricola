<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location:../../index.php");
}
include("../../conexion.php");

$codigoCurso = $_GET['codigoCurso'];
$nombreTabla = "notas_". $codigoCurso;


 //Notas de los estudiantes 
if (isset($_POST["parciales"]) && isset($_POST["quizes"]) && isset($_POST["talleres"]) &&  isset($_POST["otros"])) {

    $idEstudiante = $_GET['txtIDA'];

    //consulta porcentajes
    $sentencia3 = $conexion->prepare("SELECT*FROM cursos where codigo = :codigo");
    $sentencia3->bindParam(":codigo", $codigoCurso);
    $sentencia3->execute(); //ejecuta la instruccion select para que se muestren los registros
    $listaPorcentajes = $sentencia3->fetch(PDO::FETCH_ASSOC);

    //inicialisando variables con los porcentajes de curso
    $porcentajeParcial = $listaPorcentajes['porcentaje_parciales']; 
    $porcentajeTaller= $listaPorcentajes['porcentaje_talleres']; 
    $porcentajeQuizes = $listaPorcentajes['porcentaje_quizes']; 
    $porcentajeOtros = $listaPorcentajes['porcentaje_otros']; 

    //tomando las notas ingresadas
    $parcial = (isset($_POST["parciales"]) ? $_POST["parciales"] : "");
    $talleres = (isset($_POST["talleres"]) ? $_POST["talleres"] : "");
    $quizes = (isset($_POST["quizes"]) ? $_POST["quizes"] : "");
    $otros = (isset($_POST["otros"]) ? $_POST["otros"] : "");

    //convirtiendo las notas de string a entero
    $parcialesEntero = floatval($parcial);
    $talleresEntero = floatval($talleres );
    $quizesEntero = floatval($quizes);
    $otrosEntero = floatval($otros);
    

    $nota_final =($parcialesEntero * ($porcentajeParcial / 100)) + ($talleresEntero * ($porcentajeTaller / 100))+ 
    ($quizesEntero * ($porcentajeQuizes / 100))  + ($otrosEntero * ($porcentajeOtros/ 100));  
    

    $sentencia=$conexion->prepare
    ("UPDATE $nombreTabla SET parciales=:parcial, talleres=:talleres, quizes=:quizes,otros=:otros, nota_final=:nota_final
    WHERE id_estudiante=:idEstudiante");

    $sentencia->bindParam(":parcial", $parcialesEntero);
    $sentencia->bindParam(":talleres", $talleresEntero);
    $sentencia->bindParam(":quizes", $quizesEntero);
    $sentencia->bindParam(":otros", $otrosEntero);
    $sentencia->bindParam(":nota_final", $nota_final);
    $sentencia->bindParam(":idEstudiante", $idEstudiante);
    $sentencia->execute();
  
    header("Location:curso.php?codigoCurso=" . $codigoCurso);
}

$idEstudiante = $_GET['txtIDA'];
$sentencia2 = $conexion->prepare("SELECT*FROM $nombreTabla where id_estudiante = :id_estudiante");
$sentencia2->bindParam(":id_estudiante", $idEstudiante);
$sentencia2->execute(); //ejecuta la instruccion select para que se muestren los registros
$listaNotas = $sentencia2->fetch(PDO::FETCH_ASSOC);


$sentencia = $conexion->prepare("SELECT*FROM cursos where codigo = :codigo");
$sentencia->bindParam(":codigo", $codigoCurso);
$sentencia->execute(); //ejecuta la instruccion select para que se muestren los registros*/
$lista = $sentencia->fetch(PDO::FETCH_ASSOC);

$nombreCurso  = $lista['nombre'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../../imagenes/favicon.png">
    <!--CSS-->
    <link href = "estilos/styles-notas.css?v=7" rel = "stylesheet">
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
    <nav class="color_verde navbar navbar-expand-md navbar-light">
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
                        <a href="estudiantes.php" class="nav-link btn btn-light">Estudiantes</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../cerrar.php" class="nav-link btn btn-light">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

      <!-- seccion principal -->
    <section class="body-seccion table-responsive-sm">

        <h1 class="text-center" ><?php echo $nombreCurso; ?></h1><br>
        
        <div class="modo_container2 text-center">
            <h2 class="mb-0 pb-3">Nostas del estudiante</h2>
            <h2>
                <?php
                    $sentencia = $conexion->prepare("SELECT*FROM usuarios where id = :id_estudiante");
                    $sentencia->bindParam(":id_estudiante", $idEstudiante);
                    $sentencia->execute(); //ejecuta la instruccion select para que se muestren los registros*/
                    $lista = $sentencia->fetch(PDO::FETCH_ASSOC);
                    echo  $lista['nombre'];
                ?>
            </h2>
          
            <form action="" method="POST" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->
                <div class="row">

                    <div class="col">
                        <div class="mb-3">
                            <label for="parciales" class="form-label">Parciales</label>
                            <input type="text"
                            class="form-control" name="parciales" id="parciales" value="<?php echo $listaNotas['parciales']; ?>"  aria-describedby="helpId" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="quizes" class="form-label">Quizes</label>
                            <input type="text"
                            class="form-control" name="quizes" id="quizes" value="<?php echo $listaNotas['quizes'];?>"  aria-describedby="helpId" placeholder="">
                        </div>

                    </div>

                    <div class="col">

                        <div class="mb-3">
                            <label for="talleres" class="form-label">Talleres</label>
                            <input type="text"
                            class="form-control" name="talleres" id="talleres" value="<?php echo $listaNotas['talleres'];?>" aria-describedby="helpId" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="otros" class="form-label">Otros</label>
                            <input type="text"
                            class="form-control" name="otros" id="otros" value="<?php echo $listaNotas['otros']; ?>"  aria-describedby="helpId" placeholder="">
                        </div>

                    </div>
                </div>

                <button onclick="actualizar()" type="submit" class="btn btn-dark">Actualizar Notas</button>
                <a href="curso.php?codigoCurso=<?php echo $codigoCurso; ?>" class="btn btn-dark b_login" onclick="history.back()">
                    Volver
                </a>
            </form>
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
            
