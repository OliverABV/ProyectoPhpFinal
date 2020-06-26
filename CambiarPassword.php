<?php
session_start();
include_once './PostgreSQL/ConexionBD.php'; // llamamos la clase conexion
//verifica que los campos este vacios
if (!empty($_POST['claveAntigua']) && !empty($_POST['claveNueva']) && !empty($_POST['claveNueva2'])) {

    //COMPARAR QUE CLAVE NUEVA Y REPETIR CLAVE NUEVA SEAN IGUALES
    if ($_POST['claveNueva'] == $_POST['claveNueva2']) {
        //COMPRBOBAR QUIEN SOLICITA CAMBIO CONTRASEÑA
        //USUARIO
        if (!empty($_SESSION['inicioSesion']['id_usuario'])) {

            if (password_verify($_POST['claveAntigua'], $_SESSION['inicioSesion']['password_usuario'])) {
                $consultaSQL = ConexionBD::abrirConexion()->prepare("UPDATE usuario2 SET password_usuario = ? WHERE id_usuario = ?");
                $password = password_hash($_POST['claveNueva2'], PASSWORD_BCRYPT);
                $consultaSQL->bindParam(1, $password);
                $consultaSQL->bindParam(2, $_SESSION['inicioSesion']['id_usuario']);
                if ($consultaSQL->execute()) {

                    echo "<script>alert('CLAVE DE ACCESO ACTUALIZADA');</script>";
                    ConexionBD::cerrarConexion();
                    //ACTUALIZAR LA SESSION
                    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM usuario2 WHERE rut_usuario = ?");
                    $consultaSQL->bindParam(1, $_SESSION['inicioSesion']['rut_usuario']);
                    $consultaSQL->execute();
                    $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['inicioSesion'] = $resultadoSQL; //recreamos la seccion con los datos actualizados
                    header('Location: ./CambiarPassword.php'); // REDIRIGIR CUANDO LA CLAVE SE ACTUALIZA
                    ConexionBD::cerrarConexion();
                } else {

                    echo "<script>alert('ERROR SQL EXECUTE');</script>";
                    ConexionBD::cerrarConexion();
                }
            } else {
                echo "<script>alert('LA CLAVE ACTUAL NO COINCIDE');</script>";
            }
            //ENTIDAD
        } elseif (!empty($_SESSION['inicioSesion']['id_entidad'])) {

            if (password_verify($_POST['claveAntigua'], $_SESSION['inicioSesion']['password_entidad'])) {
                $consultaSQL = ConexionBD::abrirConexion()->prepare("UPDATE entidad SET password_entidad = ? WHERE id_entidad = ?");
                $password = password_hash($_POST['claveNueva2'], PASSWORD_BCRYPT);
                $consultaSQL->bindParam(1, $password);
                $consultaSQL->bindParam(2, $_SESSION['inicioSesion']['id_entidad']);
                if ($consultaSQL->execute()) {

                    echo "<script>alert('CLAVE DE ACCESO ACTUALIZADA');</script>";
                    ConexionBD::cerrarConexion();
                    //ACTUALIZAR LA SESSION
                    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM entidad WHERE rut_entidad = ?");
                    $consultaSQL->bindParam(1, $_SESSION['inicioSesion']['rut_entidad']);
                    $consultaSQL->execute();
                    $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['inicioSesion'] = $resultadoSQL; //recreamos la seccion con los datos actualizados
                    header('Location: ./CambiarPassword.php'); // REDIRIGIR CUANDO LA CLAVE SE ACTUALIZA
                    ConexionBD::cerrarConexion();
                } else {

                    echo "<script>alert('ERROR SQL EXECUTE');</script>";
                    ConexionBD::cerrarConexion();
                }
            } else {
                echo "<script>alert('LA CLAVE ACTUAL NO COINCIDE');</script>";
            }
        }
        //CLAVES NUEVA Y REPETICION NO COINCIDEN  
    } else {
        echo "<script>alert('LA NUEVA CLAVE NO COINCIDE CON LA COMPROBACION');</script>";
    }
}
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cambiar Contraseña</title>
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
                            <h1>Cambiar Contraseña</h1>
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

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">                  
                        <div class="block">
                            <form action="CambiarPassword.php" method="POST" enctype="multipart/form-data">

                                <div class="form-group" validate-input" data-validate="Dato Requerido">
                                    <input type="password" id="pass" name="claveAntigua" class="form-control" placeholder="Ingresar Contraseña Actual" data-type="password" required />                      
                                </div> 

                                <div class="form-group" validate-input" data-validate="Dato Requerido">
                                    <input type="password" id="pass" name="claveNueva" class="form-control" placeholder="Ingresar nueva Contraseña" data-type="password" required />                      
                                </div> 
                                <div class="form-group" validate-input" data-validate="Dato Requerido">
                                    <input type="password" id="pass" name="claveNueva2" class="form-control" placeholder="Repetir nueva Contraseña" data-type="password" required />                      
                                </div>
                                <button class="btn btn-default" type="submit" name="CambiarPassword.php" >Cambiar</button>    
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