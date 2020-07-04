<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');


//$_SESSION['inicioSesion']['nombre_usuario'])
}
?>

<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EduWeb</title>
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
                       <li><a href="ActualizarDatosUsuario.php">Mi Cuenta</a></li>
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
    <section id="slider">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-2">
            <div class="block">
              <h1 class="animated fadeInUp">Edu-Web</h1>
              <p class="animated fadeInUp">Trabajamos de forma cercana con nuestros clientes para encontrar las </br> mejores soluciones para sus necesidades en el ambito de la Educación</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Wrapper Start -->
    <section id="intro">
      <div class="container">
        <div class="row">
          <div class="col-md-7 col-sm-12">
            <div class="block">
              <div class="section-title">
                <h2>Sobre Nosotros</h2>
                <p>Con el compromiso de brindar los mejores servicios de asesorías y tutorías en el ambito de la Educación a nivel nacional con la oportunidad de conseguir empleo a lo largo de
                   todo el País</p>
              </div>
              <p> Somos una empresa especializada en desarrollo de plataformas web con mas de 5 años de experiencia en el rubro y queremos que en base a EDU-Web se pueda generar un 
                aprendizaje con respecto a las materias así como también generar oportunidades de trabajo para los clientes que se registren y utilicen este sitio web.
              </p>
            </div>
          </div><!-- .col-md-7 close -->
          <div class="col-md-5 col-sm-12">
            <div class="block">
              <img src="img/wrapper-img.gif" alt="Img">
            </div>
          </div><!-- .col-md-5 close -->
        </div>
      </div>
    </section>

  <section id="feature">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-6">
          <h2>Nosotros creemos en ti</h2>
          <p>Somos una empresa que cree en las oportunidades laborales y el futuro de los estudiantes,
          ofreciendo oportunidades laborales a los docentes, tanto como para trabajar en educación particular y superior.
          Los alumnos pueden tener un contacto con los docentes según sus necesidades academicas.</p>
          <a href="" class="btn btn-view-works">Ver Trabajos</a>
        </div>
      </div>
    </div>
  </section>
        
    <!-- Service Start -->
    <section id="service">
      <div class="container">
        <div class="row">
          <div class="section-title">
            <h2>Nuestros Servicios</h2>
            <p>EduWeb cuenta con una gran variedad de servicios para las necesidades de nuestros clientes en el ambito de la Educación tales como</p>
          </div>
        </div>
        <div class="row ">
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="icon ion-coffee"></i>
              <h4>Tutorías</h4>
              <p>El Tutor puede ofrecer sus servicios a los usuarios con el fin de enseñar materias, especializaciones y capacitaciones que
                 estos requieran</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-compass"></i>
              <h4>Asesorías</h4>
              <p>El Asesor puede ofrecer sus servicios con la finalidad de entregar información valiosa de recomendaciones, sugerencias y 
                consejos <br> en el ámbito de interes del usuario</p>

             
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-planet"></i>
              <h4>Oportunidades Laborales</h4>
              <p>Las Empresas inscritas en Edu-Web tienen la ventaja de poder publicar oportunidades laborales para cubrir 
               <br> sus necesidades</p>
            </div>
          </div>
        <!-- Se pueden agregar mas servicios-->  
        <!--
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-bug"></i>
              <h4>Start Up</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-headphone"></i>
              <h4>Logo Design</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-leaf"></i>
              <h4>Development</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-planet"></i>
              <h4>Brand Identity</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="service-item">
              <i class="ion-earth"></i>
              <h4>Brand Identity</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut </p>
            </div>
          </div>
        -->
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
    <!-- Content Start -->
    <!-- Footer Comentarios -->
    <!--
    <section id="testimonial">
      <div class="container">
        <div class="row">
          <div class="section-title text-center">
            <h2>Fun Facts About Us</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics</p>
          </div>
        </div>
        <div class="row">
         
          <div class="col-md-6">
            <div class="testimonial-carousel">
              <div id="testimonial-slider" class="owl-carousel">
                <div>
                    <img src="img/cotation.png" alt="IMG">
                    <p>"This Company created an e-commerce site with the tools to make our business a success, with innovative ideas we feel that our site has unique elements that make us stand out from the crowd."</p>
                    <div class="user">
                      <img src="img/item-img1.jpg" alt="Pepole">
                      <p><span>Rose Ray</span> CEO</p>
                    </div>
                </div>
                <div>
                  <img src="img/cotation.png" alt="IMG">
                    <p>"This Company created an e-commerce site with the tools to make our business a success, with innovative ideas we feel that our site has unique elements that make us stand out from the crowd."</p>
                    <div class="user">
                      <img src="img/item-img1.jpg" alt="Pepole">
                      <p><span>Rose Ray</span> CEO</p>
                    </div>
                </div>
                <div>
                  <img src="img/cotation.png" alt="IMG">
                    <p>"This Company created an e-commerce site with the tools to make our business a success, with innovative ideas we feel that our site has unique elements that make us stand out from the crowd."</p>
                    <div class="user">
                      <img src="img/item-img1.jpg" alt="Pepole">
                      <p><span>Rose Ray</span> CEO</p>
                    </div>
                </div>
                <div>
                  <img src="img/cotation.png" alt="IMG">
                    <p>"This Company created an e-commerce site with the tools to make our business a success, with innovative ideas we feel that our site has unique elements that make us stand out from the crowd."</p>
                    <div class="user">
                      <img src="img/item-img1.jpg" alt="Pepole">
                      <p><span>Rose Ray</span> CEO</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>    
            -->
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
                       
  <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
           
    </body>
</html>