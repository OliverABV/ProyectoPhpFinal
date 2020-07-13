<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$categoriaPublicacion = "tutoria";

 if(isset($_GET['MasPreguntas'])){
    $cargarMasPreguntas = $_GET['cantidadP'];
    $cargarMasPreguntas+=2;
  }else{
      $cargarMasPreguntas = 2;
  }

  if(isset($_GET['OcultarPreguntas'])){
    $cargarMasPreguntas = 2;
  }

  if(isset($_GET['MasComentarios'])){
    $cargarMasComentarios = $_GET['cantidadC'];
    $cargarMasComentarios+=2;
  }else{
      $cargarMasComentarios = 2;
  }

  if(isset($_GET['OcultarComentario'])){
    $cargarMasComentarios = 2;
  }
//<!-- OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACION -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT  PU.id_pregunta_publicacion, PU.id_publicacion_usuario, PUS.titulo, PU.id_usuario_pregunta, PU.fecha_pregunta_publicacion, PU.id_usuario_dueno_publicacion, PU.pregunta_publicacion, PU.fecha_respuesta_publicacion, PU.respuesta_publicacion,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario
FROM preguntas_publicacion AS PU 
INNER JOIN usuario2 AS U ON PU.id_usuario_pregunta = U.id_usuario
NATURAL JOIN publicacion_usuario AS PUS
WHERE PU.id_publicacion_usuario = ?
ORDER BY fecha_pregunta_publicacion DESC
LIMIT {$cargarMasPreguntas}");

$consultaSQL->bindParam(1, $idPublicacion);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//<!-- TERMINO OBTENER TODAS LAS PREGUNTAS DE LA PUBLICACION -->

//<!-- OBTENER TODOS LOS COMENTARIOS DE LA PUBLICACION -->
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT  PU.id_dueno_comentario_usuario, PU.id_publicacion_usuario, PU.fecha_comentario, PU.titulo, PU.comentario, PU.estrellas, PU.id_usuario_dueno_publicacion,
U.foto_usuario, U.nombre_usuario, U.apellidopat_usuario, U.apellidomat_usuario
FROM calificacion_publicacion_usuario AS PU 
INNER JOIN usuario2 AS U ON PU.id_dueno_comentario_usuario = U.id_usuario
WHERE PU.id_publicacion_usuario = ?
ORDER BY fecha_comentario DESC
LIMIT {$cargarMasComentarios}");

$consultaSQL->bindParam(1, $idPublicacion);
$consultaSQL->execute();
$listaComentarios = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//<!-- TERMINO OBTENER TODOS LOS COMENTARIOS DE LA PUBLICACION -->

$detallesPublicacion = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario 
NATURAL JOIN usuario2
NATURAL JOIN region
NATURAL JOIN ciudad
NATURAL JOIN comuna
WHERE id_publicacion_usuario = ?;");


$detallesPublicacion->bindParam(1, $idPublicacion);
$detallesPublicacion->execute();
$datosPublicacion = $detallesPublicacion->fetch(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//variables que se ocupan mas abajo
$idDueñoPublicacion = $datosPublicacion['id_usuario_dueno_publicacion'];
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
        <script src="JavaScript/expandComentario.js"></script>



        <script src="js/main.js"></script>


    </head>
    <body>
        <!-- Header Start -->
  <header style="
                        width: 90%;
                         float: rigth;
                        margin: auto;
                        " >
    <div class="container" style="
    margin-left: 0; margin-right: 0;">
      <div class="row">
        <div class="col-md-12">
          <!-- header Nav Start -->
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header" style="float: left;">
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

                        <img src="<?php echo $datosPublicacion['foto_usuario']; ?>" alt=""  style="float:left; width:250px; height:270px; padding-top:30px; padding-right:15px; ">                        
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
                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario_dueno_publicacion = ? AND id_publicacion_usuario = ?");
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
                        <img src="img/Imagenes/Sistema/estrella.png"  width="3%" height="3%" alt="Puntuacion.img" class="img-responsive">
                        <?php if ($contadorCalificacionUsuario != 0) { ?>
                            <b><?php echo round($resultadoCalificacionUsuario, 1); ?></b>
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
                   
                    
                <div  class="column3">
                    
                        <!-- LLENADO DE OTRAS PREGUNTAS -->
                        <h3>Comentarios de otros usuarios:</h3>
                        <?php foreach ($listaComentarios as $lista) { ?>
                            <div class="contenedor-comentarios">
                                <div class="comentarios">
                                <div class="expandMoreContent" id="showMoreContent1" > 

                                    <div class="photo-perfil">
                                    <img src="<?php echo $lista['foto_usuario']; ?>" alt="">
                                    </div>
                                    <div class="info-comentarios" >
                                        <div class="header-comentario">
                                            <h4><?php echo $lista['nombre_usuario']; ?><?php echo $lista['apellidopat_usuario']; ?>&nbsp;<?php echo $lista['apellidomat_usuario']; ?></h4>
                                            <h4 style="margin-right: 20% ;"> <?php echo $lista['titulo']; ?></h5> 
                                            <img src="img/Imagenes/Sistema/estrella.png" width="3%" height="3%" style="margin-right: -18%;" > 
                                            <h4><?php echo $lista['estrellas']; ?></h4>

                                        </div>
                                   
                                        <p>
                                       
                                        <?php echo $lista['comentario']; ?>
                                    
                                            
                                        </p>
                                        
                                        <div class="footer-comentario">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php } ?>
                        <!-- TERMINO LLENADO DE OTRAS PREGUNTAS -->
                        <br><br>
                        <button class="btn btn-default" type="submit" name="" style="margin-left:35%  ">         
                        <a href="DetallesPublicacion.php?id=<?php echo $idPublicacion ?>&MasComentarios=1&cantidadC=<?php echo $cargarMasComentarios; ?>" class="btn">Cargar Más Comentarios</a>
                        </button>

                        <button class="btn btn-default" type="submit" name="">         
                        <a href="DetallesPublicacion.php?id=<?php echo $idPublicacion ?>&OcultarComentarios=1" class="btn">Ocultar Preguntas</a>
                        </button>


                    </div>
                </div>
              
               
                    <div  class="column4" >
                        <h4>Deseas Preguntar algo?</h4>
 
                        <!-- TERMINO FORMULARIO PARA CREAR LA PREGUNTA -->
                        <form action="guardarPregunta.php?id=<?php echo $idPublicacion ?>&dueño=<?php echo $idDueñoPublicacion ?>" method="POST" enctype="multipart/form-data">
                            <input type="text" id="txtPregunta" name="txtPregunta" size="250" maxlength="250"  style="width: 30%; padding: 5px 5px; margin: 2px 5px; box-sizing: border-box;border: 2px solid red; 
                                   border-radius: 4px;" required>

                            <button class="btn btn-default" type="submit" name="" >Preguntar</button>
                        </form>
                        <!-- LLENADO DE OTRAS PREGUNTAS -->
                        <h4>Preguntas de otros usuarios:</h4>
                        <?php foreach ($listaPreguntas as $lista) { ?>
                            <div class="contenedor-comentarios">
                                <div class="comentarios" >
                                   <div class="expandMoreContent" id="showMoreContent1" > 
                                    <div class="photo-perfil">
                                    <img src="<?php echo $lista['foto_usuario']; ?>" alt="">
                                    </div>
                                    <div class="info-comentarios" >
                                        <div class="header-comentario">
                                            <h4><?php echo $lista['nombre_usuario']; ?>&nbsp;<?php echo $lista['apellidopat_usuario']; ?>&nbsp;<?php echo $lista['apellidomat_usuario']; ?></h4>
                                            <h5><?php 
                                            $date = date_create($lista['fecha_pregunta_publicacion']);
                                            echo date_format($date, 'd-m-Y');
                                            ?></h5>
                                        </div>
                                        <p> 
                                            
                                            <?php
                                            echo $lista['pregunta_publicacion']; ?>
                                            
                                          </p>
                                          <?php if(!is_null($lista['fecha_respuesta_publicacion'])){?>
                                          <hr class="line">
                                          <label>Respuesta: <?php if(!is_null($lista['fecha_respuesta_publicacion'])){
                                            $date = date_create($lista['fecha_respuesta_publicacion']);
                                            echo date_format($date, 'd-m-Y');
                                            }else{
                                                echo 'aun sin respuesta';
                                            }?></label>
                                      
                                         <p>
                                            <?php echo $lista['respuesta_publicacion']; ?>
                                            </p> 
                                        <?php } ?>
                                        <div class="footer-comentario">

                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                            
                        <?php } ?>

                        <br><br>
                        <button class="btn btn-default" type="submit" name="" style="margin-left:35%  ">         
                        <a href="DetallesPublicacion.php?id=<?php echo $idPublicacion ?>&MasPreguntas=1&cantidadP=<?php echo $cargarMasPreguntas; ?>" class="btn">Cargar Más Preguntas</a>
                        </button>

                        <button class="btn btn-default" type="submit" name="">         
                        <a href="DetallesPublicacion.php?id=<?php echo $idPublicacion ?>&OcultarPreguntas=1" class="btn">Ocultar Preguntas</a>
                        </button>

                        <!-- TERMINO LLENADO DE OTRAS PREGUNTAS -->
                     <!--   <div class="expandMoreHolder" >
                                        <span expand-more data-hidentext="Mostrar Menos" data-showtext="Mostrar Mas" data-target="showMoreContent1"
                                        class="btn-expand-more"> Mostrar Mas</span>
                                  </div>
                             --?
                    </div>
                                        -->

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
                        height: auto;
                        width:auto;

                    }

                    .column2 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 0.7;
                        padding: 10px;
                        height: auto;
                        width:auto;
                    }

                    .column3 {
                        -webkit-flex: 2;
                        -ms-flex: 2;
                        flex: 2;
                        padding: 10px;
                        height:auto;
                        width: auto;  

                                    
                    }


                    .column4 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 1;
                        padding: 10px;
                        height: auto;
                        width: auto;
                 
                    }


                    .line{
                        width: 100%;
                        height: 1px;
                        border-style: none;
                        box-shadow: 5px black;
                        background: #c21919;
                        margin-top: 10px;
                    }

                    .line2{
                        width: 100%;
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
                        margin-left: 180px;
                    }  
                   /*
                       
                       //css expand more

                    .expandMoreContent{
                        height: 150px; 
                        overflow: hidden;
                        transition: height 0.5s ease-in-out;
                        position: relative;
                    }
                  
                    .expandMoreContent.expand-active{
                        height: auto;
                        transition: height 0.5s ease-in-out;
                    }

                    .expandMoreHolder{
                        height: 40px;
                        padding: 15px 0;
                        text-align: center;
                    }

                    .btn-expand-more{
                        cursor: pointer;
                        border: 1px solid rgba(0, 0, 0, 0.2)
                    }

                    */

                     
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
                        transition:  all 300ms;
                        margin-top: 10px;
                        border-left: 1.5px solid #019CDE;
                        border-right: 1.5px solid #019CDE;
                        box-shadow: 3px 3px 8px red


   
                       
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
                        width: 900px;
                    }

                    .info-comentarios p{
                        padding: 10px;
                        width: 900px;
                        height: auto;
                        
                    }
                    
                    .info-comentarios label{
                      float: right;
                        
                    }

                    .footer-comentario{
                        width: auto;
                        height: auto;
                        background: #019CDE;
                        padding: 2px;
                        color: #5f5f5f;
                        display: flex;
                        justify-content: space-between;
                        font-size: 15px;               
                    }
                
                  

            




                </style>

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