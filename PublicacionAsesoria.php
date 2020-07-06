<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');


//$_SESSION['inicioSesion']['nombre_usuario'])
}

$id_usuario = $_SESSION['inicioSesion']['id_usuario'];
$categoriaPublicacion = "tutoria";
//echo '<script>alert ("Prueba Id_usuario: ' . $id_usuario . '");</script>';
include_once './PostgreSQL/ConexionBD.php';

$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_region, nombre_region FROM region");
$consultaSQL->execute();
$cboRegion = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();


// CAMBIOS
 if (!empty($_POST['txtNamePost'])) {
    echo "<script>alert('ENTRO EN IF');</script>";
    $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO publicacion_usuario (titulo, descripcion, si_incluye, no_incluye, categoria_publicacion, precio, telefono_opcional, sitio_web, tipo_publicacion, id_usuario, id_region, id_ciudad, id_comuna) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $consultaSQL->bindParam(1, $_POST['txtNamePost']);
    $consultaSQL->bindParam(2, $_POST['txtDescripcion']);
    $consultaSQL->bindParam(3, $_POST['txtIncluye']);
    $consultaSQL->bindParam(4, $_POST['txtNoIncluye']);
    $consultaSQL->bindParam(5, $categoriaPublicacion);
    $consultaSQL->bindParam(6, $_POST['txtPrecio']);
    $consultaSQL->bindParam(7, $_POST['txtTelefonoOpc']);
    $consultaSQL->bindParam(8, $_POST['txtSitioWeb']);
    $consultaSQL->bindParam(9, $_POST['rbTipo']);
    $consultaSQL->bindParam(10, $id_usuario);
    $consultaSQL->bindParam(11, $_POST['region']);
    $consultaSQL->bindParam(12, $_POST['ciudad']);
    $consultaSQL->bindParam(13, $_POST['comuna']);


    if ($consultaSQL->execute()) {

        echo "<script>alert('Publicacion Generada');</script>";
    } else {

        echo "<script>alert('Error al generar la publicacion');</script>";
    }
    ConexionBD::cerrarConexion();
}
?>

<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Asesoría</title>
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

    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
        <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">

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

    <script language="javascript">
            $(document).ready(function () {
                $("#region").change(function () {

                    $('#comuna').find('option').remove().end().append('<option selected value="0">Seleccione una ciudad primero...</option>');

                    $("#region option:selected").each(function () {
                        id_region = $(this).val();
                        $.post("./PostgreSQL/LLenarCiudad.php", {id_region: id_region}, function (data) {
                            $("#ciudad").html(data);
                        });
                    });
                })
            });

            $(document).ready(function () {
                $("#ciudad").change(function () {
                    $("#ciudad option:selected").each(function () {
                        id_ciudad = $(this).val();
                        $.post("./PostgreSQL/LLenarComuna.php", {id_ciudad: id_ciudad}, function (data) {
                            $("#comuna").html(data);
                        });
                    });
                })
            });


        </script>
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
                      <li>
                            <a href="#">Bienvenido <span class="glyphicon glyphicon-user"></span> <?php
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
                       <li><a href="#">Mi Cuenta</a></li>
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
                  <h1>Asesoría</h1>
                  <p>Crea tu publicación de Asesoría</p>
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
                  <form action="PublicacionAsesoria.php" method="POST" enctype="multipart/form-data">
                  <h3>Publicaci&oacute;n</h3> 

                    <div class="form-group">
                        <input type="text" id="txtnamePost" name="txtNamePost" class="form-control" placeholder="Nombre De La Publicaci&oacute;n" required>
                    </div>
                      
                    <div class="form-group">
                           <input type="text" id="txtIncluye" name="txtIncluye" class="form-control" placeholder="Que Incluye La Publicaci&oacute;n" required>
                    </div> 
                      
                    <div class="form-group">
                        <input type="text" id="txtNoIncluye" name="txtNoIncluye" class="form-control" placeholder="Que No Incluye La Publicaci&oacute;n" required>
                    </div> 
                      
                    <div class="form-group-2">
                      <textarea style="overflow:auto;resize:none" name="txtDescripcion" class="form-control" rows="3" placeholder="Ingrese su Mensaje"></textarea>
                    </div>

                    <h3>Tu Ubicación</h3>
                    <div class="form-group">                
                       <select id="pais" name="pais" class="form-control">
                        <option value="0">Seleccione Pais...</option> 
                                <option value="Chile">Chile</option>
                                </select>
                    </div>                    
                      
                    <div class="form-group">                         
                      <select id="region" name="region" class="form-control">
                            <option value="0">Seleccione una región...</option> 
                                <?php foreach ($cboRegion as $dato) { ?>
                                    <option value="<?php echo $dato['id_region']; ?>"><?php echo $dato['nombre_region']; ?></option>
                                <?php } ?>
                                </select>
                    </div>
                      
                    <div class="form-group">                        
                             <select id="ciudad" name="ciudad" class="form-control">
                                <option value="0">Seleccione una region primero...</option> 
                                </select>
                    </div>
                      
                      
                      
                    <div class="form-group">                         
                            <select id="comuna" name="comuna" class="form-control">
                                <option value="0">Seleccione una ciudad primero...</option> 
                                </select>
                    </div>
                      
                    <h3>Datos de Contacto</h3> 
                    <div class="form-group">                                               
                       <input type="text" class="form-control" id="txtFelefonoOpc" name="txtTelefonoOpc" placeholder="Ingrese Telefono Opcional">
                      </div>   
                    
                      <div class="form-group">                                               
                        <label for="">Telefono: </label> <input type="text" class="form-control" id="txtFelefono" name="txtTelefono" value="<?php echo $_SESSION['inicioSesion']['telefono_usuario'] ?>" readonly="readonly">
                      </div>
                                                                                                                              
                      <div class="form-group">                          
                      <label for="">Correo: </label>  <input type="text" id="txtEmail" name="txtEmail"  class="form-control" value="<?php echo $_SESSION['inicioSesion']['email_usuario'] ?>" readonly="readonly">
                    </div> 
                          
                      <div class="form-group">                                          
                          <input id="txtSitioWeb" name="txtSitioWeb" type="text" class="form-control" placeholder="Sitio Web">
                       </div>
                      
                       <div class="form-group">                                          
                          <input id="txtPrecio" name="txtPrecio" type="text" class="form-control" placeholder="Precio Por Hora">
                       </div>

                       <div class="form-group">                                          
                          <input id="txtNumClases" name="txtNumClases" type="text" class="form-control" placeholder="Numero De Clases">
                       </div>
                      
                       <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-condensed table-bordered">
                                    <tr>
                                        <td><label for="">Tipo</label></td>
                                        <td> <label for="">Duraci&oacute;n</label> </td>
                                        <td> <label for="">Exposición</label> </td>
                                        <td> <label for="">Publicidad</label> </td>
                                        <td> <label for="">Costo Por Publica</label></td>
                                    </tr>
                                    <tr>
                                        <td> <input type="radio" name="rbTipo" value="Platino180"  /> <label for="">Platino 180</label></td>
                                        <td> <label for="">180 Dias</label> </td>
                                        <td>  
                                            <label for="">Máxima</label>
                                        </td>
                                        <td> 
                                            <label for=""> Ninguna</label>
                                        </td>
                                        <td>
                                            <label for=""> $4000</label>                                          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <input type="radio" name="rbTipo" value="Oro90"/> <label for="">Oro 90</label></td>
                                        <td> <label for="">90 Dias</label> </td>
                                        <td> 
                                            <label for="">Alta</label>
                                        </td>
                                        <td>  
                                            <label for="">Limitado</label>
                                        </td>
                                        <td>
                                            <label for="">$3000</label> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <input type="radio" name="rbTipo" value="Plata180"/> <label for="">Plata 180</label> </td>
                                        <td>  <label for="">180 Dias</label> </td>
                                        <td> 
                                            <label for="">Media</label>
                                        </td>
                                        <td>  
                                            <label for="">Media</label>
                                        </td>
                                        <td>
                                             <label for=""> $2000</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <input type="radio" name="rbTipo" value="Bronce90"/> <label for="">Bronce 90</label></td>
                                        <td>  <label for="">90 Dias</label> </td>
                                        <td>  
                                            <label for="">Limitado</label>
                                        </td>
                                        <td>   
                                             <label for="">Alta</label>  
                                        </td>
                                        <td>
                                                <label for="">$1000</label>  
                                        </td>
                                          


                                    </tr>
                                    <tr>
                                        <td> <input type="radio" name="rbTipo" value="Gratis" checked /> <label for="">Gratis</label></td>
                                        <td> <label for="">60 Dias</label> </td>
                                        <td>  
                                            <label for="">Ninguna</label>
                                        </td>
                                        <td>  
                                             <label for="">Máxima</label>  

                                        </td>
                                        <td> 
                                             <label for="">Gratis</label>  
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                      
                                     
                      
                      <button class="btn btn-default" type="submit" name="PublicacionAsesoria.php" >Publicar</button>

                  </form>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="block">
                  <form>
                    <div class="form-group-2">
                        
                        
                    <h2>Ubicación</h2>
                  <ul class="address-block">
                    <li>
                      <i class="fa fa-map-marker"></i>Providencia #4562
                    </li>
                    <li>
                      <i class="fa fa-envelope-o"></i>Email: Edu-web@gmail.com
                    </li>
                    <li>
                      <i class="fa fa-phone"></i>Telefono: +569 25672975
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
                  </form>
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