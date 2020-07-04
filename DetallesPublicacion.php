<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$categoriaPublicacion = "tutoria";

//<!-- OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACION -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT  PU.fecha_pregunta_publicacion, PU.pregunta_publicacion, PU.fecha_respuesta_publicacion, PU.respuesta_publicacion,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario
FROM preguntas_publicacion AS PU 
NATURAL JOIN usuario2 AS U
WHERE id_publicacion_usuario = ?
ORDER BY fecha_pregunta_publicacion DESC;");
$consultaSQL->bindParam(1, $idPublicacion);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//<!-- TERMINO OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACION -->

$detallesPublicacion = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario 
NATURAL JOIN usuario2
NATURAL JOIN region
NATURAL JOIN ciudad
NATURAL JOIN comuna
WHERE id_publicacion_usuario = ?;");

/*
  SELECT * FROM publicacion_usuario
  INNER JOIN usuario2 ON publicacion_usuario.id_usuario = usuario2.id_usuario
  INNER JOIN region ON publicacion_usuario.id_region = region.id_region
  INNER JOIN ciudad ON publicacion_usuario.id_ciudad = ciudad.id_ciudad
  INNER JOIN comuna ON publicacion_usuario.id_comuna = comuna.id_comuna
  WHERE id_publicacion_usuario = ?;
 */

$detallesPublicacion->bindParam(1, $idPublicacion);
$detallesPublicacion->execute();
$datosPublicacion = $detallesPublicacion->fetch(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//variables que se ocupan mas abajo
$idDueñoPublicacion = $datosPublicacion['id_usuario'];
$nacimiento = $datosPublicacion['fechanac_usuario'];
?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Detalles</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!-- CSS -->
        <link rel="stylesheet" href="css2/owl.carousel.css">
        <link rel="stylesheet" href="css2/bootstrap.min.css">
        <link rel="stylesheet" href="css2/font-awesome.min.css">
        <link rel="stylesheet" href="css2/style.css">
        <link rel="stylesheet" href="css2/ionicons.min.css">
        <link rel="stylesheet" href="css2/animate.css">
        <link rel="stylesheet" href="css2/responsive.css">
        <link rel="stylesheet" href="css/comentarios.css">


        <!-- Js -->
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/min/waypoints.min.js"></script>
        <script src="js/jquery.counterup.js"></script>



        <script src="js/main.js"></script>


    </head>
    <body>
        <!-- Header Start -->
  <header style="
                        width: 90%;
                         float: rigth;
                        margin: auto;
                        " > >
    <div class="container" style="
    margin-left: 0; margin-right: 0;">
      <div class="row">
        <div class="col-md-12">
          <!-- header Nav Start -->
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">EduWeb</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>       
                  <span></span>
                </a>
              </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <div class="row">
                    <ul class="nav navbar-nav navbar-right">
                      <li><img src="img/logo.png" alt="Logo" height="50px" height="50px" style="margin-right: 50px;"></li>
                      <li><a href="indexUsuario.php">Inicio</a></li>
                      <li><a href="MaquetaPublicaciones.php">Publicaciones</a></li>
                      <li><a href="PublicacionTutoria.php">Crear Publicación</a></li>

                      <li>
                            <a href="#"> <?php
                                if (!empty($_SESSION['inicioSesion']['nombre_usuario'])) {
                                    $avatar = $_SESSION['inicioSesion']['foto_usuario'];
                                    echo $_SESSION['inicioSesion']['nombre_usuario'];
                                    echo' ';
                                    echo '<img class="rounded-circle" src="' . $avatar . '" width="50" height="50">';
                                } else {
                                    $avatar = $_SESSION['inicioSesion']['foto_entidad'];
                                    echo $_SESSION['inicioSesion']['nombre_comercial_entidad'];
                                    echo ' ';
                                    echo '<img class="rounded-circle" src="' . $avatar . '" width="50" height="50">';
                                }
                                ?>  </a>
                        </li>
                       <li><a href="ActualizarDatosUsuario2.php">Mi Cuenta</a></li>
                        <li><a href="CerrarSesion.php">Cerrar Sesion</a></li>

                 
                   </ul>
                  </div>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
          </div>
        </div>
      </div>
    </header><!-- header close -->

        <!-- Slider Start -->
        <section id="global-header">
            <div class="container">          
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h1>Detalles de la Tutoría/Asesoría</h1>
                            <p>Aqui verá toda la información detallada </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact form start -->
        <section id="contact-form">
            <div class="conetenedor">  
                <div class="row">
                    <div  class="column1" >

                        <img src="<?php echo $datosPublicacion['foto_usuario']; ?>" alt=""  style="float:left; width:250px; height:250px; padding-top:30px; padding-right:15px; ">                        
                        <h2 style= "padding-top:5px ;">Datos:</h2>  
                        <label for="">Nombre:</label> <label for=""><?php echo $datosPublicacion['nombre_usuario']; ?>&nbsp;<?php echo $datosPublicacion['apellidopat_usuario']; ?>&nbsp;<?php echo $datosPublicacion['apellidomat_usuario']; ?></label> <br>

                        <!-- CALCULO EDAD-->
                        <?php
                        $fecha = time() - strtotime($nacimiento);

                        $edad = floor($fecha / 31556926);
                        ?>
                        <!-- TERMINO CALCULO EDAD-->
                        <label for="">Edad:</label> <label for=""><?php echo $edad ?></label> <br>


                        <label for="">Residencia:</label> <label for=""><?php echo $datosPublicacion['nombre_region'] ?></label><br /> <label for=""><?php echo $datosPublicacion['nombre_ciudad'] ?></label><br /><label for=""><?php echo $datosPublicacion['nombre_comuna'] ?></label> <br>

                        <!-- CALIFICACION -->
                        <?php
                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario = ? AND id_publicacion_usuario = ?");
                        $calificacionSQL->bindParam(1, $idDueñoPublicacion);
                        $calificacionSQL->bindParam(2, $idPublicacion);
                        $calificacionSQL->execute();
                        $sumaCalificacionUsuario = 0;
                        $contadorCalificacionUsuario = 0;
                        $resultadoCalificacionUsuario = 0;
                        foreach ($calificacionSQL as $calificacion) {
                            $sumaCalificacionUsuario += $calificacion['estrellas'];
                            $contadorCalificacionUsuario++;
                        }
                        if ($contadorCalificacionUsuario != 0) {
                            $resultadoCalificacionUsuario = $sumaCalificacionUsuario / $contadorCalificacionUsuario;
                            // echo $resultadoCalificacionUsuario;
                        } else {
                            //  echo 'Sin Calificaciones';
                        }

                        ConexionBD::cerrarConexion();
                        ?>
                        <br>
                        <label for="">Calificación:</label>
                        <img src="img/Imagenes/Sistema/estrella.png"  width="10%" height="10%" alt="Puntuacion.img" class="img-responsive">
                        <?php if ($contadorCalificacionUsuario != 0) { ?>
                            <b><?php echo $resultadoCalificacionUsuario; ?></b>
                        <?php } else { ?>
                            <b> SIN CLASIFICACION</b>
                        <?php } ?>
                        <!-- TERMINO CALIFICACION -->
                        <br><br><br>
                        <h2>Descripción</h2> <label for=""><?php echo $datosPublicacion['descripcion'] ?></label>

                    </div>
                    <div  class="column2" >
                        <h2><?php echo $datosPublicacion['titulo'] ?></h2>

                        <label for="">Tipo de Clases Ofrecidas:</label>&nbsp;<?php echo $datosPublicacion['categoria_publicacion']; ?> <label for=""></label> <br>
                        <label for="">Incluye:</label> <?php echo $datosPublicacion['si_incluye'] ?> <label for=""></label> <br>
                        <label for="">Excluye:</label> <?php echo $datosPublicacion['no_incluye'] ?> <label for=""></label> <br>
                        <label for="">Valor Hora:</label> <?php echo $datosPublicacion['precio'] ?> <label for=""></label> <br>
                        <br><br>
                        <button class="btn btn-default" type="submit" name="" style="margin-left:15%">Solicitar</button>
                        <h4 style="margin-top:240px">Problemas con esta persona? <a href="">Reportala aqui</a></h4>
                    </div>
                </div>
                <div class="row">

                    <div  class="column3" >
                        <h2>Deseas Preguntar algo?</h2>
                        <form action="DetallesPublicacion_copy.php?id=<?php echo $idPublicacion ?>" method="POST" enctype="multipart/form-data">
                            <input type="text" id="" name="" style="width: 60%; padding: 5px 5px; margin: 2px 5px; box-sizing: border-box;border: 2px solid red; 
                                   border-radius: 4px;">
                                   <?php
                                   if (!empty($_POST['txtPregunta'])) {
                                       //echo "<script>alert('ENTRO EN SI');</script>";
                                       $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
                                       //$fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
                                       $fechaSubida = date_format($fechaCompleta, "d-m-Y");
                                       $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO Preguntas_publicacion (id_publicacion_usuario, id_usuario, fecha_pregunta_publicacion, pregunta_publicacion) VALUES (?, ?, ?, ?)");
                                       $consultaSQL->bindParam(1, $idPublicacion);
                                       $consultaSQL->bindParam(2, $_SESSION['inicioSesion']['id_usuario']);
                                       $consultaSQL->bindParam(3, $fechaSubida);
                                       $consultaSQL->bindParam(4, $_POST['txtPregunta']);
                                       //echo '<script>alert ("Fecha '.$idPublicacion.' ");</script>';
                                       if ($consultaSQL->execute()) {

                                           echo "<script>alert('PREGUNTA REALIZADA');</script>";
                                       } else {

                                           echo "<script>alert('ERROR AL CREAR LA PREGUNTA');</script>";
                                       }
                                       ConexionBD::cerrarConexion();
                                   }
                                   ?>
                            <button class="btn btn-default" type="submit" name="" >Preguntar</button>
                        </form>
                        <!-- TERMINO FORMULARIO PARA CREAR LA PREGUNTA -->

                        <!-- LLENADO DE OTRAS PREGUNTAS -->
                        <h3>Preguntas de otros usuarios:</h3>
                        <?php foreach ($listaPreguntas as $lista) { ?>
                            <hr class="line">
                            <div class="contenedor-comentarios">
                                <div class="comentarios">
                                    <div class="photo-perfil">
                                        <img src="<?php echo $datosPublicacion['foto_usuario']; ?>" alt="">
                                    </div>
                                    <div class="info-comentarios" >
                                        <div class="header-comentario">
                                            <h4><?php echo $datosPublicacion['nombre_usuario']; ?>&nbsp;<?php echo $datosPublicacion['apellidopat_usuario']; ?>&nbsp;<?php echo $datosPublicacion['apellidomat_usuario']; ?></h4>
                                            <h5><?php 
                                            $date = date_create($lista['fecha_pregunta_publicacion']);
                                            echo date_format($date, 'd-m-Y');
                                            ?></h5>
                                        </div>
                                        <p>
                                            <?php echo $lista['pregunta_publicacion']; ?>
                                    
                                            
                                        </p>
                                        <div class="footer-comentario">
                                            <h5 class="request">Responder</h5>
                                            <label class=""></label>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- TERMINO LLENADO DE OTRAS PREGUNTAS -->


                    </div>

                    <div  class="column4" style="background-color:#bbb;">
                        <h1>Comentarios de otros usuarios:</h1>
                    </div>

                </div>

                <style>
                    .conetenedor{
                        margin-left:15%;
                        margin-right:15%;
                    }

                    .row {
                        display: -webkit-flex;
                        display: flex;
                    }
                    .column1 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 0.8;
                        padding: 10px;
                        height: 550px;
                        width:50%;
                        background: skyblue;

                    }

                    .column2 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 0.7;
                        padding: 10px;
                        height: 550px;
                        width:50%;
                        background: skyblue;
                    }

                    .column3 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 1.4;
                        padding: 10px;
                        height: 1700px;
                        width: 100%;
                    }

                    .line{
                        width: 630px;
                        height: 2px;
                        border-style: none;
                        background: #c21919;
                        margin-top: 10px;
                    }
                    .contenedor-comentarios{
                        margin-top: 20px;
                    }
                    .comentarios{
                        display: flex;
                    }                  

                    .photo-perfil{
                        width: 100px;
                        height: 82px;
                        border-radius: 50%;
                        overflow: hidden;
                    }                    
                    .photo-perfil img{
                        width: 100%;
                        height: 100%;
                    }

                    .info-comentarios{
                        margin-left: 20px;
                        background: #e6e6e6;
                        transition:  all 300ms;
                        margin-top: 10px;
                    }

                    .info-comentarios:hover{

                        border-bottom: 2px solid black; 
                    }

                    .header-comentario{
                        display: flex;
                        justify-content: space-between;
                        padding: 10px;
                        background: #019CDE;
                        color: white;
                    }

                    .info-comentarios p{
                        padding: 20px;
                        width: 580px;
                        height: 125px;
                    }

                    .footer-comentario{
                        width: 100%;
                        background: white;
                        padding: 10px;
                        color: #5f5f5f;
                        display: flex;
                        justify-content: space-between;
                    }
                    .footer-comentario{
                        font-size: 15px;
                        cursor: pointer;
                    }

                    .column4 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 1;
                        padding: 10px;
                        height: 300px;
                        width:50%;
                        border: solid;
                    }





                </style>

            </div>
        </div>
    </section>
    <!-- Call to action Start -->
    <section id="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h2>Creemos en ti y en tu futuro</h2>
                        <p>Edu-Web ofrece la posibilidad de insertar laboralmente a jóvenes estudiantes en un área de gran demanda de profesionales y con
                            grandes posibilidades de proyección laboral.</p>
                        <a class="btn btn-default btn-call-to-action" href="RegistroUsuario.php">Empezar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer Start -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-manu">
                        <ul>
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="contacto.html">Contacto</a></li>
                            <li><a href="#">Suporte</a></li>
                            <li><a href="#">Terminos</a></li>
                        </ul>
                    </div>
                    <p>Copyright &copy; Crafted by <a href="">Diego Malagueño, Bastian Jara</a>.</p>
                </div>
            </div>
        </div>
    </footer>                            
</body>
</html>