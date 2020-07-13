<?php

//require_once './vendor/autoload.php';
require_once ('./transbank-sdk-php-1.7.1/init.php');

use Transbank\Webpay\Webpay;
use Transbank\Webpay\Configuration;

$idPublicacion = $_GET['id'];
$idDueñoPublicacion = $_GET['dueño'];
$tituloPublicacion = $_GET['titulo'];
$valorHora = $_GET['valorHora'];
$cantidadHoras = $_POST['txtCantidadHoras'];
$idContratante = $_GET['idContratante'];

$total = $valorHora * $cantidadHoras;

$transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))->getNormalTransaction();

$amount = round($total);
//$sessionId = 'sessionId';
$sessionId = $tituloPublicacion;
//$buyOrder = strval(round(10000,9999999));
$buyOrder = $tituloPublicacion;
//$returnUrl = 'http://localhost/ProyectoPhpFinal/return.php';
$returnUrl = 'http://localhost/ProyectoPhpFinal/return.php'.'?id='.$idPublicacion.'&dueño='.$idDueñoPublicacion.'&titulo='.$tituloPublicacion.'&valorHora='.$valorHora.'&cantidadHoras='.$cantidadHoras.'&idContratante='.$idContratante;
//$finalUrl = 'http://localhost/ProyectoPhpFinal/final.php';
$finalUrl = 'http://localhost/ProyectoPhpFinal/final.php'.'?id='.$idPublicacion.'&dueño='.$idDueñoPublicacion.'&titulo='.$tituloPublicacion.'&valorHora='.$valorHora.'&cantidadHoras='.$cantidadHoras.'&idContratante='.$idContratante;

$initResult = $transaction->initTransaction(
    $amount, $sessionId, $buyOrder, $returnUrl, $finalUrl
);

$formAction = $initResult->url;
$tokenWs = $initResult->token;

?>


<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mi Perfil</title>
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
    <link href="https://maxcdn.bootstrapcdm.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    
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
                      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Crear Publicación
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="PublicacionTutoria.php"> Tutoria</a>
          <hr>
          <a class="dropdown-item" href="PublicacionAsesoria.php"> Asesoria</a>
        </div>
      </li>
                        
                       <li><a href="MiPerfil.php">Mi Cuenta</a></li>
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
                  <h1></h1>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- contact form start -->
      
        <div class="conetenedor" >
            <div class="row">
                <div class="column1">
    <center>
    <h2>Pago con webpay</h2>
    <p><b>Valor</b>: <?php echo $amount ?></p>
    <p><b>Orden de compra</b>: <?php echo $buyOrder ?></p>


<form action="<?php echo $formAction ?>" method="POST" class="form-inline" role='form'>
    <input type="hidden" name="token_ws" value="<?php echo $tokenWs ?>">
    <button class="btn btn-default" type="submit" name="" ><a href="http://localhost/ProyectoPhpFinal/MaquetaPublicaciones.php">Volver a las publicaciones</a> </button>
    <button type="submit" class="btn btn-primary">Pagar</button>

</form>
   
                </div>
    </div>
</div>
</center>
      


          <style>
                    .conetenedor{
                        margin-left:40%;
                        margin-right:10%;
                    }

                    .row {
                        display: -webkit-flex;
                        display: flex;
                        
                    }
                    .column1 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 0.4;
                        margin-top: 50px ;
                        margin-bottom: 100px;
                        padding: 10px;
                        height: auto;
                        width:auto;
                           border: 2px solid #019CDE;
                           box-shadow: 1px 1px 4px #019CDE;                   

                    }

                    .column2 {
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 0.4;
                        padding: 10px;
                        height: auto;
                        width:auto;
                        background:#019CDE;
                        border: 2px solid black;
                        box-shadow: 1px 1px 4px black; 
                                     

                        
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


