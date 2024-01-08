<?php
session_start();
include("conexion.php");

if ($_POST) {
    // Recolectamos los datos del método POST
    $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");
    $contrasenia = (isset($_POST["contraseña"]) ? $_POST["contraseña"] : "");
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $rol = "estudiante";
    
    // Preparar la inserción de los datos
    $sentencia = $conexion->prepare("INSERT INTO usuarios( login,password, rol, nombre) VALUES (?, ?, ?, ?)");
    // Asignando los valores que vienen del método POST (Los que vienen del formulario)
    $sentencia->bindParam(1, $correo, PDO::PARAM_STR);
    $sentencia->bindParam(2, $contrasenia, PDO::PARAM_STR);
    $sentencia->bindParam(3, $rol, PDO::PARAM_STR);
    $sentencia->bindParam(4, $nombre, PDO::PARAM_STR);
    $sentencia->execute();
    header("Location:index.php");
}

if($_GET){
    $correo = (isset($_GET["correo"]) ? $_GET["correo"] : "");
    $password = (isset($_GET["password"]) ? $_GET["password"] : "");

    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE login = '$correo' &&  password = '$password'");
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id'] = $resultado['id'];
    $_SESSION['nombre'] = $resultado['nombre'];

    if ($sentencia) {
        $fila = $sentencia->rowCount();
        if ($fila > 0) {
            if($resultado['rol'] == "administrador"){
                header("Location: secciones/Administrador/index.php");
                exit();
            }
            if($resultado['rol'] == "estudiante"){
                header("Location: secciones/Estudiante/index.php");
                exit();
            }
            if($resultado['rol'] == "profesor"){
                header("Location: secciones/Profesor/index.php");
                exit();
            }
            
        }
    }

    ?>
    <script>
        alert ("ERROR: El usuario o la contraseña son incorrectos");
    </script>
    <?php
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto-DIU</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="imagenes/favicon.png">
    <!--CSS-->
    <link href = "styles.css?v=3" rel = "stylesheet">
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
            <a class="navbar-letra navbar-brand" href="#">
                <img src="imagenes/favicon.png" alt="Logo" width="37" height="35" alt="Logo de la pagina web" class="d-inline-block align-text-top">
                Universidad Agricola
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toggler"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar-toggler">
                <ul class="navbar-nav d-flex  justify-content-center align-items-center ">
                    <li class="derecha nav-item">
                        <a id ="miEnlace" href="index.php" class="nav-link blanco btn btn-light b_ingresar modal_close">Ingresar</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link blanco btn btn-light b_registrar modal_close2">Registrar</a>
                    </li>
                </ul>
            </div>
            
        </div>
    </nav>
    <br><br>

    <!-- Seccion hero-->
    <section>
        <div class="container text-center">
            <div class ="row">
                <!--  modal ingresar a la plataforma-->
                <div class="col modo_container2 ">
                    <div class="navbar-letra">
                        <h1 class="display-5 fw-bold">INGRESAR</h1><br>
                    </div>
                    <div class="contenedor">
                        <form action="" method="GET">

                            <div class="mb-3">
                                <label for="Correo" class="form-label "><h4>Correo</h4></label> <br>
                                <input type="text" class=" form-control" name="correo" id="Correo" aria-describedby="helpId" placeholder="Ingresa tu correo">
                                <br>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label"><h4>Contraseña</h4></label> <br>
                                <input type="password"
                                class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Ingresa tu contraseña">
                                <br>
                            </div>

                            <button type="submit" name="obtener_resultados" class="btn btn-dark boton-letra">Ingresar</button>
                            <!-- <a name="" id="" class="btn btn-dark modal_close2 boton-letra" href="#" role="button">Cancelar</a>-->
                            <br> <br>
                        </form>
                    </div>
                </div>

                <!--  modal crear usuario -->
		        <div class="col modo_container">
			        <h1 class="navbar-letra display-5 fw-bold">REGISTRAR</h1>
                    <form action="" method="post" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->

                        <div class="mb-3">
                            <label for="nombre" class="form-label"><h4>Nombre</h4></label>
                            <input type="text"
                            class="form-control" name="nomnre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label"><h4>Login</h4></label>
                            <input type="text"
                            class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo">
                        </div>

                        <div class="mb-3">
                            <label for="contrasenia" class="form-label"><h4>Contraseña</h4></label>
                            <input type="password"
                            class="form-control" name="contraseña" id="contraseña" aria-describedby="helpId" placeholder="Contraseña">
                        </div>

                        <button onclick="crear()" type="submit" href="#" class="btn btn-dark boton-letra">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </section><br><br>
    <!-- seccion contacto o pie de pagina-->
    <footer class="color_verde d-flex flex-column align-items-center justify-content-center">
        <div class="row">
            <!--<div class="col text-center">
                <p class="d-flex flex-wrap align-items-center justify-content-center">Lorem ipsum es el texto que se usa
                habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el
                diseño visual antes de insertar el texto final.</p>
            </div>-->
            <div class="col"><br><br><br>
                <img class="footer-logo" src="imagenes/favicon.png" width="200em"  alt="favicon de la pagina">
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

    <script  src="js/main.js?v=2"> </script>
    <script>
        function crear(){
            alert ("¡Usuario Creado");
        }
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
  // Selecciona el enlace por su ID
  var enlace = document.getElementById("miEnlace");

  // Simula un clic en el enlace
  enlace.click();
});
</script>
</body>
</html>