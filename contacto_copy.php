<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login2.php');
}
?>
<?php
include_once './PostgreSQL/ConexionBD.php';
$publicacionesDatosSQL = ConexionBD::abrirConexion()->prepare("(SELECT publicacion_usuario.*, usuario2.foto_usuario, usuario2.certificado_usuario
FROM publicacion_usuario 
INNER JOIN usuario2
ON publicacion_usuario.id_usuario = usuario2.id_usuario)
UNION
(SELECT publicacion_entidad.*, entidad.foto_entidad, entidad.nombre_comercial_entidad
FROM publicacion_entidad 
INNER JOIN entidad
ON publicacion_entidad.id_entidad = entidad.id_entidad)
ORDER BY fecha_registro");
$publicacionesDatosSQL->execute();
ConexionBD::cerrarConexion();

$publicacionesTutoriaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario INNER JOIN usuario2 ON publicacion_usuario.id_usuario = usuario2.id_usuario WHERE categoria_publicacion = 'tutoria'");
$publicacionesTutoriaSQL->execute();
ConexionBD::cerrarConexion();
$publicacionesAsesoriaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario INNER JOIN usuario2 ON publicacion_usuario.id_usuario = usuario2.id_usuario WHERE categoria_publicacion = 'asesoria'");
$publicacionesAsesoriaSQL->execute();
ConexionBD::cerrarConexion();
$publicacionesOportunidadSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_entidad INNER JOIN entidad ON publicacion_entidad.id_entidad = entidad.id_entidad WHERE categoria_publicacion = 'oportunidad'");
$publicacionesOportunidadSQL->execute();
ConexionBD::cerrarConexion();

if (!empty($_GET['filtro'])) {
    if ($_GET['filtro'] == "tutoria") {
        $filtro = $publicacionesTutoriaSQL;
    } elseif ($_GET['filtro'] == "asesoria") {
        $filtro = $publicacionesAsesoriaSQL;
    } elseif ($_GET['filtro'] == "oportunidad") {
        $filtro = $publicacionesOportunidadSQL;
    }
} else {
    $filtro = $publicacionesDatosSQL;
}
?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Space Template</title>
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
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/modificaciones.css">
    
    <!-- Js -->
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/min/waypoints.min.js"></script>
    <script src="js/jquery.counterup.js"></script>

    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="js/google-map-init.js"></script>


    <script src="js/main.js"></script>


  </head>
  <body>
    <!-- Header Start -->
    <header>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- header Nav Start -->
            <nav class="navbar navbar-default">
              <div>
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.html">
                    <img src="img/logo.png" alt="Logo" >
                  </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                   <li><a href="index.html">Inicio</a></li>
                    <li>
                        <a href="#">Bienvenido <span class="glyphicon glyphicon-user"></span> <?php
                          if (!empty($_SESSION['inicioSesion']['nombre_usuario'])) {
                              $avatar = $_SESSION['inicioSesion']['foto_usuario'];
                              echo $_SESSION['inicioSesion']['nombre_usuario'];
                              echo' ';
                              echo '<img class="rounded-circle" border-radius: 100%; src="' . $avatar . '" width="50" height="50">';
                          } else {
                              $avatar = $_SESSION['inicioSesion']['foto_entidad'];
                              echo $_SESSION['inicioSesion']['nombre_comercial_entidad'];
                              echo ' ';
                              echo '<img class="rounded-circle" border-radius: 100%; src="' . $avatar . '" width="50" height="50">';
                          }
                          ?>  
                        </a>
                    </li>
                    <li><a href="#">Mi Cuenta </a></li>
                    <li><a href="CerrarSesion.php">Cerrar Sesion</a></li>
                 
                  </ul>
                </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
              </nav>
            </div>
          </div>
        </div>
        </header><!-- header close -->

        <section id="contact-form">
        <div id="contenedor"> 

<div id="contenido"> 


        <hr>
        <!-- FOREACH QUE CREA LA LISTA DE LAS PUBLICACIONES "filtro" RESIVE LOS DATOS SEGUN EL FILTRO QUE SE SELECCIONA-->
   
        <?php foreach ($filtro as $publicacion) { ?>     


            <div class="container-fluid02" id="publicacion-container">



                <div class="row"  >
                    <div class="col-3 bg" id="publicacion-foto">

                        <div class="row">
                            <div class="col bg">
                                <!-- SE COLOCA EL AVATAR DEL USUARIO DUEÑO DE LA PUBLICACION LISTADA -->
                                <img src="<?php
                                if (!empty($publicacion['foto_usuario'])) {
                                    echo $publicacion['foto_usuario'];
                                } else {
                                    echo $publicacion['foto_entidad'];
                                }
                                ?>" width="100" height="100" alt="Imagen.Publicacion" class="img-responsive">

                            </div>
                        </div>
                    </div>


                    <div class="col-6 bg">
                        <div class="row row-cols-1">
                            <div class="col bg">
                                <!-- TITULO CON LINK PARA REDIRIGIR A LA VISTA DETALLADA DE LA PUBLICACION SELECCIONADA CLIKEANDO SU TITULO -->
                                <?php if (!empty($publicacion['id_publicacion_usuario'])) { ?>
                                    <?php if ($publicacion['categoria_publicacion'] == "tutoria") { ?>
                                        <div class="titulo">
                                            Titulo: <?php echo "<a class='publicacion' href=DetallesTuroria.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                        </div>
                                    <?php } elseif ($publicacion['categoria_publicacion'] == "asesoria") { ?>
                                        Titulo:  <?php echo "<a class='publicacion' href=DetallesAsesoria.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                    <?php } elseif ($publicacion['categoria_publicacion'] == "oportunidad") { ?>
                                        Titulo: <?php echo "<a class='publicacion' href=DetallesOportunidad.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                    <?php } ?>

                                <?php } elseif (!empty($publicacion['id_publicacion_entidad'])) { ?>
                                    Titulo: <?php echo "<a class='publicacion' href=DetallesOportunidad.php?id=" . $publicacion['id_publicacion_entidad'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                <?php } ?>

                            </div>
                            <!-- INCLUYE Y NO INCLUYE -->
                            <div class="col bg">Incluye: <?php echo $publicacion['si_incluye'] ?></div>
                            <div class="col bg">Excluye: <?php echo $publicacion['no_incluye'] ?></div>
                            <div class="col bg">Tipo: Tipo</div>
                            <div class="col bg">Certificado: <?php
                                if (!empty($publicacion['certificado_usuario'])) {
                                    echo $publicacion['certificado_usuario'];
                                }
                                ?></div>
                            <!-- DESCRIPCION-->
                            <div class="col bg">Descripcion: <?php echo $publicacion['descripcion'] ?></div>
                            <!-- PRECIO -->
                            <div class="col bg">$: <?php echo $publicacion['precio'] ?></div>

                        </div>

                    </div>


                    <div class="col-3 bg" id="calificacion">

                        <div class="row row-cols-1">

                            <div id="imagen1">

                                <div class="col bg">
                                    <!-- CALIFICACION -->
                                    <?php
                                    if (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "tutoria")) {

                                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario = ? AND id_publicacion_usuario = ?");
                                        $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                        $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
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
                                    } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "asesoria")) {

                                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario = ? AND id_publicacion_usuario = ?");
                                        $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                        $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
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
                                    } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "oportunidad")) {

                                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_entidad WHERE id_entidad = ? AND id_publicacion_entidad = ?");
                                        $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                        $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
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
                                    } elseif (!empty($publicacion['id_publicacion_entidad'])) {
                                        $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_entidad WHERE id_entidad = ? AND id_publicacion_entidad = ?");
                                        $calificacionSQL->bindParam(1, $publicacion['id_entidad']);
                                        $calificacionSQL->bindParam(2, $publicacion['id_publicacion_entidad']);
                                        $calificacionSQL->execute();
                                        $sumaCalificacionEntidad = 0;
                                        $contadorCalificacionEntidad = 0;
                                        $resultadoCalificacionEntidad = 0;

                                        foreach ($calificacionSQL as $calificacion) {
                                            $sumaCalificacionEntidad += $calificacion['estrellas'];
                                            $contadorCalificacionEntidad++;
                                        }
                                        if ($contadorCalificacionEntidad != 0) {
                                            $resultadoCalificacionEntidad = $sumaCalificacionEntidad / $contadorCalificacionEntidad;
                                            //   echo $resultadoCalificacionEntidad;
                                        } else {
                                            //   echo 'Sin Calificaciones';
                                        }
                                        ConexionBD::cerrarConexion();
                                    }
                                    ?>

                                    <img src="img/Imagenes/Sistema/gif-estrella.gif"  width="25%" height="25%" alt="Puntuacion.img" class="img-responsive">
                                    <?php
                                    if ($publicacion['categoria_publicacion'] == "tutoria") {
                                        if ($contadorCalificacionUsuario != 0) {
                                            ?>
                                            <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                        <?php } else { ?>
                                            <b> SIN CLASIFICACION</b>
                                            <?php
                                        }
                                    } elseif ($publicacion['categoria_publicacion'] == "asesoria") {
                                        if ($contadorCalificacionUsuario != 0) {
                                            ?>
                                            <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                        <?php } else { ?>
                                            <b> SIN CLASIFICACION</b>
                                            <?php
                                        }
                                    } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "oportunidad")) {
                                        if ($contadorCalificacionUsuario != 0) {
                                            ?>
                                            <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                        <?php } else { ?>
                                            <b> SIN CLASIFICACION</b>
                                            <?php
                                        }
                                    } elseif ($publicacion['categoria_publicacion'] == "oportunidad") {
                                        if ($contadorCalificacionEntidad != 0) {
                                            ?>
                                            <b><?php echo $resultadoCalificacionEntidad; ?></b>
                                        <?php } else { ?>
                                            <b> SIN CLASIFICACION</b>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="imagen1">
                                <div class="col bg">
                                    <!-- SELLOS (tutoria, asesoria, oportunidad -->
                                    <?php if ($publicacion['categoria_publicacion'] == "tutoria") { ?>
                                        <img src="img/Imagenes/Sistema/tutoria.png" alt="tutoria.img" width="50%" height="50%" class="img-responsive">
                                    <?php } elseif ($publicacion['categoria_publicacion'] == "asesoria") { ?>
                                        <img src="img/Imagenes/Sistema/asesoria.png" alt="asesoria.img" width="50%" height="50%" class="img-responsive">
                                    <?php } else { ?>
                                        <img src="img/Imagenes/Sistema/opportunity.png" alt="oportunidad.img" width="50%" height="50%" class="img-responsive">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
            <hr>
        <?php } ?>
    </div>   

    <div class="wrap">



    </div>


</div>        

</div>

</div>     
</body>


          
        </section>
        <!-- Call to action Start -->
        <section id="call-to-action">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="block">
                  <h2>We design delightful digital experiences.</h2>
                  <p>Read more about what we do and our philosophy of design. Judge for yourself The work and results we’ve achieved for other clients, and meet our highly experienced Team who just love to design.</p>
                  <a class="btn btn-default btn-call-to-action" href="#" >Tell Us Your Story</a>
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