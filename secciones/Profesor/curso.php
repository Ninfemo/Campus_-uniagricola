<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location:../../index.php");
}
include("../../conexion.php");

$codigoCurso = $_GET['codigoCurso'];
$nombreTabla = "notas_". $codigoCurso;

/** Mostrar todo lo que hay en la base de datos acerca del curso*/
$sentencia = $conexion->prepare("SELECT*FROM cursos where codigo = :codigo");
$sentencia->bindParam(":codigo", $codigoCurso);
$sentencia->execute(); //ejecuta la instruccion select para que se muestren los registros*/
$lista = $sentencia->fetch(PDO::FETCH_ASSOC);

$nombreCurso  = $lista['nombre'];

/** Mostrar todos los estudiantes que estan matriculados en el curso */
$sentencia = $conexion->prepare("SELECT*FROM asignacion where codigoCurso =:codigoCurso");
$sentencia->bindParam(":codigoCurso", $codigoCurso);
$sentencia->execute(); //ejecuta la instruccion select para que se muestren los registros*/
$listaUsuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);


  /** Editar porcentaje de notas   */
  
if(isset($_POST["porcentaje_parcial"]) && isset($_POST["porcentaje_talleres"]) && isset($_POST["porcentaje_quizes"]) &&  isset($_POST["porcentaje_otros"])){
    //Actualizando los registros 
    $porcentaje_parcial = (isset($_POST["porcentaje_parcial"]) ? $_POST["porcentaje_parcial"] : "");
    $porcentaje_talleres = (isset($_POST["porcentaje_talleres"]) ? $_POST["porcentaje_talleres"] : "");
    $porcentaje_quizes= (isset($_POST["porcentaje_quizes"]) ? $_POST["porcentaje_quizes"] : "");
    $porcentaje_otros = (isset($_POST["porcentaje_otros"]) ? $_POST["porcentaje_otros"] : "");


    $sentencia=$conexion->prepare
    ("UPDATE cursos SET porcentaje_parciales=:porcentaje_parcial, porcentaje_talleres=:porcentaje_talleres, porcentaje_quizes=:porcentaje_quizes,porcentaje_otros=:porcentaje_otros
    WHERE codigo=:codigo");

    $sentencia->bindParam(":porcentaje_parcial", $porcentaje_parcial);
    $sentencia->bindParam(":porcentaje_talleres", $porcentaje_talleres);
    $sentencia->bindParam(":porcentaje_quizes", $porcentaje_quizes);
    $sentencia->bindParam(":porcentaje_otros", $porcentaje_otros);

    $sentencia->bindParam(":codigo", $codigoCurso);
    $sentencia->execute();
  
    header("Location:curso.php?codigoCurso=" . $codigoCurso);
}




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../../imagenes/favicon.png">
    <!--CSS-->
    <link href = "estilos/styles-cursos.css?v=12" rel = "stylesheet">
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
    
        <h1 class="center" ><?php echo $nombreCurso; ?></h1><br><br>
        <table class="table  color_modal_curso">
            <div class = "relleno">

        
                <a href="" id ="miEnlace"class="btn btn-light modal_curso modal_close_estudiantes modal_close_avisos modal_close_calificaciones">
                    Curso
                </a>

                <a href="curso.php?codigoCurso=<?php echo $codigoCurso?>" class="btn btn-light modal_estudiantes modal_close_avisos  modal_close_curso modal_close_calificaciones">
                    Estudiantes
                </a>

                <a href="curso.php?codigoCurso=<?php echo $codigoCurso?>" class="btn btn-light modal_avisos modal_close_calificaciones modal_close_curso  modal_close_estudiantes ">
                    Avisos
                </a>

                <a href="curso.php?codigoCurso=<?php echo $codigoCurso?>" class="btn btn-light modal_calificaciones modal_close_curso  modal_close_estudiantes modal_close_avisos ">
                    Calificaciones
                </a>
            <!--
            <button href="curso.php?codigoCurso=<?php echo $codigoCurso?>" class="btn btn-light modal_calificaciones modal_close_avisos modal_close_curso modal_close_estudiantes ">
                Calificaciones
            </button>
            -->

            
            
            </div>
            <thead class="">
                <tr class=""><h3 class="text-center">Porcentajes</h3></tr>
                <tr class="text-center">
                    <th scope="col">Parciales</th>
                    <th scope="col">Talleres</th>
                    <th scope="col">Quizes</th>
                    <th scope="col">Otros</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody class="relleno">
                <tr class="text-center">
                    <td><?php echo $lista['porcentaje_parciales']; ?>%</td>
                    <td><?php echo $lista['porcentaje_talleres']; ?>%</td>
                    <td><?php echo $lista['porcentaje_quizes']; ?>%</td>
                    <td><?php echo $lista['porcentaje_otros']; ?>%</td>
            
                    <td>
                        <a class="btn btn-dark b_login" href="curso.php?codigoCurso=<?php echo $codigoCurso; ?>" role="button">Editar</a>
                    </td>
                </tr>

            </tbody>

        </table>
        <div class="modalC">
        <div class="">
            <tbody>
                <div class="container_tr">Actividad 1</div>
                <div class="container_tr">Actividad 2</div>
                <div class="container_tr">Actividad 3</div>
                <div class="container_tr">Actividad 4</div>
                <div class="container_tr">Actividad 5</div>
            </tbody>
        </div>
        </div>
        
        <div class="modalE">
            <div class="container_tr">
                <table class="table">
                    <thead class="letra_new">
                        <tr class="text-center">
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Para mostrar todos los datos de la tabla usuarios -->
                        <?php
                            $numUsuarios = count($listaUsuarios);
                            for($i = 0; $i < $numUsuarios; $i++) { 
                                $registro = $listaUsuarios[$i];
                        ?>
                                <tr class="text-center">
                                    <td>
                        <?php 
                                        echo $idUsuario = $registro["idEstudiante"]; $id = $registro["id"];?>
                                    </td>
                                    <td>
                        <?php
                                        $sentencia=$conexion->prepare("SELECT nombre FROM usuarios WHERE id=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $nombreUsuario = $sentencia->fetchColumn(); // Recupera el valor
                        ?>    
                                    </td>
                                    <td>
                        <?php
            
                                        $sentencia=$conexion->prepare("SELECT apellido FROM usuarios WHERE id=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $apellidoUsuario = $sentencia->fetchColumn(); // Recupera el valor
                        ?>
                                    </td>
                                    <td>
                        <?php
                                        $sentencia=$conexion->prepare("SELECT login FROM usuarios WHERE id=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $loginUsuario = $sentencia->fetchColumn(); // Recupera el valor
                        ?>
                                    </td>
                                    <td>
                                        <a  class="btn btn-dark" href="notas.php?txtIDA=<?php echo $idUsuario; ?>&codigoCurso=<?php echo $codigoCurso?>" role="button">Notas</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modalA">
            <div class="">
                <tbody>
                    <div class="container_tr">Avisos</div>
                </tbody>
            </div>
        </div>

        <div class="modalF">
            <div class="container_tr">
                <table class="table">
                    <thead class="letra_new">
                        <tr class="text-center">
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Nota final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Para mostrar todos los datos de la tabla usuarios -->
                        <?php
                            $numUsuarios = count($listaUsuarios);
                            for($i = 0; $i < $numUsuarios; $i++) { 
                                $registro = $listaUsuarios[$i];
                                $idUsuario = $registro["idEstudiante"]
                        ?>
                                <tr class="text-center">
                                    <td>
                        <?php
                                        $sentencia=$conexion->prepare("SELECT nombre FROM usuarios WHERE id=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $nombreUsuario = $sentencia->fetchColumn(); // Recupera el valor
                        ?>    
                                    </td>
                                    <td>
                        <?php
            
                                        $sentencia=$conexion->prepare("SELECT apellido FROM usuarios WHERE id=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $apellidoUsuario = $sentencia->fetchColumn(); // Recupera el valor
                        ?>
                                    </td>
                                    <td class="td_resaltado">
                        <?php
                                        $codigoCurso = $_GET['codigoCurso'];
                                        $nombreTabla = "notas_". $codigoCurso;
                                        $sentencia=$conexion->prepare("SELECT nota_final FROM $nombreTabla WHERE id_estudiante=:id");
                                        $sentencia->bindParam(":id", $idUsuario);
                                        $sentencia->execute();
                                        echo $notaFinal = $sentencia->fetchColumn(); // Recupera el valor
                        ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--
            <div class="modalF">
                <div class="">
                    <tbody>
                        <div class="container_tr">Calificaciones</div>
                    </tbody>
                </div>
            </div>
        -->
    
    
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

    <!-- seccion modal editar curso -->
    <section class = "modo">
        <div class="modo_container text-center">
            <h2 class="mb-0 pb-3">PORCENTAJES</h2>
            <form action="" method="POST" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->

                <div class ="row">
                    <div class = "col">

                        <div class="mb-3">
                            <label for="porcentaje_parcial" class="form-label">Parciales</label>
                            <input type="text"
                            class="form-control" name="porcentaje_parcial" id="porcentaje_parcial" aria-describedby="helpId" placeholder="ingresar el nuevo porcentaje">
                        </div>

                        <div class="mb-3">
                            <label for="porcentaje_talleres" class="form-label">Talleres</label>
                            <input type="text"
                            class="form-control" name="porcentaje_talleres" id="porcentaje_talleres" aria-describedby="helpId" placeholder="ingresar el nuevo porcentaje">
                        </div>

                    </div>
                    <div class="col">

                        <div class="mb-3">
                            <label for="porcentaje_quizes" class="form-label">Quizes</label>
                            <input type="text"
                            class="form-control" name="porcentaje_quizes" id="porcentaje_quizes" aria-describedby="helpId" placeholder="ingresar el nuevo porcentaje">
                        </div>

                        <div class="mb-3">
                            <label for="porcentaje_otros" class="form-label">Otros</label>
                            <input type="text"
                            class="form-control" name="porcentaje_otros" id="porcentaje_otros" aria-describedby="helpId" placeholder="ingresar el nuevo porcentaje">
                        </div>

                    </div>

                </div>

            <button type="submit" class="btn btn-dark" href="#" >Actualizar Registros</button>
            <a name="" id="" class="btn btn-dark modal_close" href="#" role="button">Cancelar</a>
            </form>
        </div>
    </section>

    <!-- seccion modal editar curso -->
    <script src="js/curso.js?v=23"></script>
    <script src="js/main.js?v=34"></script>

</body>
    <script>
            function eliminar(){
                alert("¡Usuario eliminado");
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
            
