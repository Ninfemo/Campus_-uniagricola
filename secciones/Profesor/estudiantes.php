<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location:../../index.php");
}
include("../../conexion.php");
$ID = $_SESSION['id'];
$nombreProfesor = $_SESSION['nombre'];

/** Mostrar todos los usuarios que hay en la base nde datos */
$sentencia = $conexion->prepare("SELECT*FROM usuarios where rol = 'estudiante'");
$sentencia->execute(); //ejecuta la instruccion select para que se muestren los registros*/
$listaUsuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);


/** Eliminar usuario de la base de datos */

if (isset($_GET['txtIDA'])) {
  $txtID = (isset($_GET['txtIDA'])) ? $_GET['txtIDA'] : "";

  $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  header("Location:estudiantes.php");
}

if ($_POST) {
  
    // Insertar usuario a la base de datos
    // Recolectamos los datos del método POST
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $apellido = (isset($_POST["apellido"]) ? $_POST["apellido"] : "");
    $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");
    $contrasenia = (isset($_POST["contraseña"]) ? $_POST["contraseña"] : "");
    $rol = "estudiante";

    // Preparar la inserción de los datos
    $sentencia = $conexion->prepare("INSERT INTO usuarios(nombre, apellido,  login, password, rol) VALUES ( ?, ?, ?, ?, ?)");
    // Asignando los valores que vienen del método POST (Los que vienen del formulario)
    $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
    $sentencia->bindParam(2, $apellido, PDO::PARAM_STR);
    $sentencia->bindParam(3, $correo, PDO::PARAM_STR);
    $sentencia->bindParam(4, $contrasenia, PDO::PARAM_STR);
    $sentencia->bindParam(5, $rol, PDO::PARAM_STR);
    $sentencia->execute();
    header("Location:estudiantes.php");
}

  /** Editar usuario en base al ID  */
if($_GET){
    //Actualizando los registros 
    $txtID=(isset($_GET["id"])?$_GET["id"]:"");
    $nombre=(isset($_GET["nombre"])?$_GET["nombre"]:"");
    $apellido=(isset($_GET["apellido"])?$_GET["apellido"]:"");
    $correo = (isset($_GET["correo"])?$_GET["correo"]:"");
    $contrasenia = (isset($_GET["contrasenia"])?$_GET["contrasenia"]:"");
    $rol="estudiante";

    $sentencia=$conexion->prepare
    ("UPDATE usuarios SET nombre=:nombre,
    apellido=:apellido,  
    login=:correo, 
    password=:contrasenia,
    rol=:rol
    WHERE id=:id");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":apellido", $apellido);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":contrasenia", $contrasenia);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":rol", $rol);
    $sentencia->execute();
  
    header("Location:estudiantes.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../../imagenes/favicon.png">
    <!--CSS-->
    <link href = "estilos/styles-usuarios.css?v=2" rel = "stylesheet">
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
                        <a href="estudiantes.php" class="nav-link btn btn-light">Estudiantes</a>
                    </li> 
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link btn btn-light">Salir</a>
                    </li>  
                </ul>
            </div>
        </div>    
    </nav>

  <!-- seccion principal -->
  <section class="body-seccion  table-responsive-sm">
    
    <h1 class="center" >Estudiantes en la universidad</h1><br><br>
    <table class="table">
      <div class = "relleno">
        <a href="index.php" class="btn btn-dark b_login">
          Crear
        </a>
        <a class="btn btn-dark b_editar" href="index.php"
          role="button"><i class="fas fa-edit icon-text"> </i>Editar</a>
      </div>      
      <thead class="letra_new">
        <tr class="text-center">
          <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Correo</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!--Para mostrar todos los datos de la tabla usuarios -->
        <?php
          $numUsuarios = count($listaUsuarios);
          for($i = 0; $i < $numUsuarios; $i++) { 
          $registro = $listaUsuarios[$i];?>
          <tr class="text-center">
            <td><?php echo $registro["id"]; ?></td>
            <td><?php echo $registro["nombre"]; ?></td>
            <td><?php echo $registro["apellido"]; ?></td>
            <td><?php echo $registro["login"]; ?></td>

            <td>
              <a onclick="eliminar()" class="btn btn-dark" href="usuarios.php?txtIDA=<?php echo $registro["id"]; ?>" role="button"><i class="fas fa-trash-alt icon-text"> Eliminar</i></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
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

        <!-- seccion modal crear usuario -->
        <section class="modo">
		      <div class="modo_container text-center">
				    <h2 class="mb-0 pb-3">CREAR ESTUDIANTE</h2>
            <form action="" method="post" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->
              <div class="row">
                <div class="col">

                  <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                    class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
                  </div>
                
                  <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="text"
                    class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo">
                  </div>

                </div>
                <div class="col">

                  <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text"
                    class="form-control" name="apellido" id="apellido" aria-describedby="helpId" placeholder="apellido">
                  </div>

                  <div class="mb-3">
                    <label for="contrasenia" class="form-label">Contraseña</label>
                    <input type="password"
                    class="form-control" name="contraseña" id="contraseña" aria-describedby="helpId" placeholder="Contraseña">
                  </div>

                </div>
              </div>
              <button onclick="crear()" type="submit" href="estudiantes.php" class="btn btn-dark">Agregar Registro</button>
              <!--<a type="submit" name="" id="" class="btn btn-dark modal_close" href="#"  role="button">Agregar Registro</a>-->
              <a name="" id="" class="btn btn-dark modal_close" href="estudiantes.php" role="button">Cancelar</a>
            </form>
          </div>
        </section>

        <!-- seccion modal editar usuario -->
        <section class = "ventana">
          <div class="modo_container2 text-center">
            <h2 class="mb-0 pb-3">EDITAR ESTUDIANTE</h2>
            <form action="" method="GET" enctype="multipart/form-data"> <!--Esto es para que se puedan subir los archivos-->
              <div class="row">
                <div class="col">

                  <div class="mb-3">
                    <label for="nombre" class="form-label">ID del estudiante a editar</label>
                    <input type="text"
                    class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="id">
                  </div>

                  <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                    class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="nombre">
                  </div>

                  <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text"
                    class="form-control" name="apellido" id="apellido" aria-describedby="helpId" placeholder="apellido">
                  </div>

                </div>
                <div class="col">
                  <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="text"
                    class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo">
                  </div>

                  <div class="mb-3">
                    <label for="contrasenia" class="form-label">Contraseña</label>
                    <input type="password"
                    class="form-control" name="contrasenia" id="contrasenia" aria-describedby="helpId" placeholder="Contraseña">
                  </div>

                </div>

              </div>
 
              <button type="submit" class="btn btn-dark">Actualizar Registros</button>
              <a name="" id="" class="btn btn-dark modal_close2" href="#" role="button">Cancelar</a>
            </form>
          </div>
        </section>
        <script src="js/main.js?v=34"></script>

</body>
    <script>
            function eliminar(){
                alert("¡Usuario eliminado");
              /**   var respuesta = confirm("¿Seguro que quieres eliminar?");
              if (respuesta) {
                alert("Usuario eliminado");
              } else {
              alert("Has cancelado la acción");
              }         
            
              var nombre = prompt("Por favor, ingresa tu nombre:");

              if (nombre != null && nombre !== "") {
              alert("Hola, " + nombre + "! Bienvenido.");
              } else {
              alert("No ingresaste tu nombre.");
                }
              */
            }
            function editar(){

            }
            function crear(){
              alert ("¡Usuario Creado");
            }
    </script> 
</html>