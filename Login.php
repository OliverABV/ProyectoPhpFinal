<?php
session_start();
include_once './PostgreSQL/ConexionBD.php'; // llamamos la clase conexion
//verifica que los campos este vacios
if (!empty($_POST['user']) && !empty($_POST['pass'])) {
    //preparamos la consulta a la vez que llamamos la conexion
    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM usuario2 WHERE rut_usuario = ?");
    $consultaSQL->bindParam(1, $_POST['user']);
    $consultaSQL->execute();
    $total = $consultaSQL->rowCount();
    //obtenemos los resultados como un array, si no llega nada se resive el bolean false
    $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);

    $message = '';
    ConexionBD::cerrarConexion();
    if (($total > 0) && (password_verify($_POST['pass'], $resultadoSQL['password_usuario']))) {
        $_SESSION['inicioSesion'] = $resultadoSQL;
        echo "ESTE ES UN USUARIO";
        header('Location: ./MaquetaPublicaciones.php');
    } else {
        $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM entidad WHERE rut_entidad = ?");
        $consultaSQL->bindParam(1, $_POST['user']);
        $consultaSQL->execute();
        $total = $consultaSQL->rowCount();
        //obtenemos los resultados como un array, si no llega nada se resive el bolean false
        $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);

        $message = '';

        if (($total > 0) && (password_verify($_POST['pass'], $resultadoSQL['password_entidad']))) {
            $_SESSION['inicioSesion'] = $resultadoSQL;
            echo "ESTE ES UNA ENTIDAD";
            header('Location: ./MaquetaPublicaciones.php');
        } else {
            $message = "USUARIO O ENTIDAD NO EXISTE";
          //  echo "USUARIO O ENTIDAD NO EXISTE";
        }
    }
}
?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
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
  <header>
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
                      <li><a href="index.html">Inicio</a></li>
                      <li><a href="Registro.php">Publicaciones</a></li>
                      <li><a href="RegistroUsuario.php">Empezar</a></li>
                      <li><a href="#">Registro Entidad</a></li>
                      <li><a href="contacto.html">Contacto</a></li>
                      <li><a href="#">Iniciar Sesion</a></li>

                  </div>
                  </ul>
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
                  <h1>Ingresa</h1>
                  <p>No te pierdas las ultimas publicaciones y noticias de la Educación</p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- contact form start -->
        <section id="contact-form">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="block">
                <h2>Ubicación</h2>
                  <ul class="address-block">
                    <li>
                      <i class="fa fa-map-marker"></i>Providencia #4562
                    </li>
                    <li>
                      <i class="fa fa-envelope-o"></i>Email: Edu-web@gmail.com
                    </li>
                    <li>
                      <i class="fa fa-phone"></i>Phone:+569 25672975
                    </li>
                  </ul>

                  <ul class="social-icons">
                    <li>
                      <a href="#"><i class="fa fa-google"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-linkedin"></i></a>
                    </li>                                                     
                    <li>
                      <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">                  
              <div class="block">
              <form action="Login.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group" validate-input" data-validate="Dato Requerido">
                      <input type="text" id="user" name="user" class="form-control" size="10" maxlength="10" placeholder="Ingrese su Rut" required oninput="checkRut(this)" required />
	                   <script src="./JavaScript/FormatoValidaRut.js"></script>
                    </div>
                    <div class="form-group" validate-input" data-validate="Dato Requerido">
                      <input type="password" id="pass" name="pass" class="form-control" placeholder="Ingrese Contraseña" data-type="password" required />                      
                    </div> 
                    <button class="btn btn-default" type="submit" name="Login.php" >Ingresar</button>    
                  </form>
                </div>
              </div>
            </div>
            <div id="contact-box" class="row">
              <div class="col-md-6 col-sm-12">
                <div class="block">
               
                </div>
              </div>             
            </div>
          </div>
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