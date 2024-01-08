<?php

session_start();

if (empty($_SESSION['id'])) {
  header("Location:../../index.php");
}
include("../../conexion.php");
$ID = $_SESSION['id'];
$nombreAdmin = $_SESSION['nombre'];


if ($_POST) {
    // Recolectamos los datos del método POST
    $codigo = (isset($_POST["codigo"]) ? $_POST["codigo"] : "");
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $idProfesor = (isset($_POST["idprofesor"]) ? $_POST["idprofesor"] : "");
    
    // Preparar la inserción de los datos
    $sentencia = $conexion->prepare("INSERT INTO cursos( nombre, codigo, idProfesor) VALUES (?, ?, ?)");
    // Asignando los valores que vienen del método POST (Los que vienen del formulario)
    $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
    $sentencia->bindParam(2, $codigo, PDO::PARAM_STR);
    $sentencia->bindParam(3, $idProfesor, PDO::PARAM_STR);
    $sentencia->execute();

    //Creamos tabla para el manejo de notas del curso creado

    $nombreTabla = "notas_" . $codigo;
    $sentencia2 = $conexion->prepare("CREATE TABLE $nombreTabla (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_estudiante varchar(32),
    parciales int,
    talleres int,
    quizes int,
    otros int,
    nota_final float,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    $sentencia2->execute();
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../../imagenes/favicon.png">
    <!--CSS-->
    <link href = "estilos/styles-index.css?v=3" rel = "stylesheet">
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
<body class="color_body">
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
    <!-- Seccion hero-->
    <section class="body-seccion">
        <br><br>
        <div class="container text-center">
            
                <!--  crear curso  -->
		        <div class="modo_container">
			        <h1 class="display-5 fw-bold">Crear un curso</h1>
                    <form action="" method="post" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->

                        <div class="mb-3">
                            <label for="nombre" class="form-label"><h4>Nombre</h4></label>
                            <input type="text"
                            class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="nombre del curso">
                        </div>
                        

                        <div class="mb-3">
                            <label for="codigo" class="form-label"><h4>Codigo</h4></label>
                            <input type="text"
                            class="form-control" name="codigo" id="codigo" aria-describedby="helpId" placeholder="Codigo del curso">
                        </div>

                        <div class="mb-3">
                            <label for="idprofesor" class="form-label"><h4>Profesor</h4></label>
                            <input type="text"
                            class="form-control" name="idprofesor" id="idprofesor" aria-describedby="helpId" placeholder="id del profesor">
                        </div>

                        <button onclick="crear()" type="submit" href="#" class="btn btn-dark boton-letra">Agregar</button>
                    </form>
                </div>
        </div>
        <br><br>
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

    <script  src="../../js/main.js?v=2"> </script>
    <script>
        function crear(){
            alert ("¡El curso a sido crado!");
        }
    </script>
</body>
</html>