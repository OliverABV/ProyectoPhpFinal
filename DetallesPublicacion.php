<?php

//require_once 'PHP-Mail/ConexionPHPMail.php';


if (!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['asunto']) && !empty($_POST['mensaje'])){

//VERSION LOCALHOST



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
                      <li><a href="Login.php">Iniciar Sesion</a></li>

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
                  <h1>Contáctanos</h1>
                  <p>Comunícate con nosotros, envíanos tus comentarios o sugerencias </p>
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
   
     <img src="img/foto.jpg" alt=""  style="float:left; width:250px; height:250px; padding-top:30px; padding-right:15px; ">
    
     <h2 style= "padding-top:5px ;">Datos:</h2>  
     <label for="">Nombre:</label> <label for="">asdasdasdsas</label> <br>
     <label for="">Edad:</label> <label for="">asdasd</label> <br>
     <label for="">Residencia:</label> <label for="">asdasd</label> <br>
     <label for="">Disponibilidad:</label> <label for="">asdasd</label> <br>
     <br>
     <label for="">Calificación:</label>
       <br><br><br>
      <h2>Descripción</h2> <label for="">Aca va la info</label>
    
</div>
<div  class="column2" >
 <h2>Titulo Publicaciones</h2>

      <label for="">Tipo de Clases Ofrecidas:</label> <label for=""></label> <br>
      <label for="">Incluye:</label> <label for=""></label> <br>
      <label for="">Excluye:</label> <label for=""></label> <br>
      <label for="">Valor Hora:</label> <label for=""></label> <br>
      <br><br>
      <button class="btn btn-default" type="submit" name="" style="margin-left:35%">Solicitar</button>
      <h4 style="margin-top:240px">Problemas con esta persona? <a href="">Reportala aqui</a></h4>
</div>
          </div>
<div class="row">

    <div  class="column3" style="background-color:#bbb;">
       <h2>Deseas Preguntar algo?</h2>
       <input type="text" id="" name="" style="width: 60%; padding: 5px 5px; margin: 2px 5px; box-sizing: border-box;border: 2px solid red; 
       border-radius: 4px;">
       <button class="btn btn-default" type="submit" name="" >Preguntar</button>
     
       <h3>Preguntas de otros usuarios:</h3>
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
  flex: 1;
  padding: 10px;
  height: 550px;
  width:50%;
  border: solid;  
  margin-right: 15px;

}

.column2 {
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  padding: 10px;
  height: 550px;
  width:50%;
  border: solid;
}

.column3 {
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  padding: 10px;
  height: 300px;
  width:50%;
  border: solid;
  margin-top: 15px;
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