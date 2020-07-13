<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login2.php');
}

//habilitar BD
include_once './PostgreSQL/ConexionBD.php';



//prepara el combobox region
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_region, nombre_region FROM region");
$consultaSQL->execute();
$cboRegion = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();

//CODIGO TEMPORTAL PARA EL if ($region == "5") 
$region = "";
if (!empty($_POST['regionUsuario'])) {
    $region = $_POST['regionUsuario'];
};



//comprobar que campos tengan datos  ESTO AUN NO ESTA DEFINIDO, ES UNO PROVISORIO SOLO FUNCIONARA SI ELIJES LA 5 REGION
if ($region == "5") {
  
    //verificar que ya que exista el RUT en la BD
    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(rut_usuario) FROM usuario2 WHERE rut_usuario = ?");
    $consultaSQL->bindParam(1, $_SESSION['inicioSesion']['rut_usuario']);
    $consultaSQL->execute();
    //verificar que ya que exista el RUT en la BD
    if ($consultaSQL->fetchColumn() == 1) {
        ConexionBD::cerrarConexion();
        //verifica si se incluye o no avatar
        if (!empty($_FILES['imgAvatar']['name'])) {

            //ESTE IF CON EL COMANDO UNLINK ELIMINA EL ARCHIVO DEL SERVIDOR, SE LE ENTREGA LA DIRECCION LOCAL DE LA IMAGEN
            if (unlink($_SESSION['inicioSesion']['foto_usuario'])) {
                $extencion = pathinfo($_FILES['imgAvatar']['name'], PATHINFO_EXTENSION);
                $nom_archivo = $_SESSION['inicioSesion']['rut_usuario'] . "." . $extencion;

                //date_default_timezone_set("America/Santiago");
                $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
                $fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
                $rutaAvatar = "img/Imagenes/FotosPerfiles/Usuarios/" . $fechaSubida . " " . $nom_archivo;
                $archivo = $_FILES['imgAvatar']['tmp_name'];
                move_uploaded_file($archivo, $rutaAvatar);
            }
        } else {
            if ($_POST['sexo'] == "masculino") {
                $rutaAvatar = "img/Imagenes/FotosPerfiles/Usuarios/SinFotoHombre.jpg";
            } else {
                $rutaAvatar = "img/Imagenes/FotosPerfiles/Usuarios/SinFotoMujer.jpg";
            }
        }

        //verifica si se incluye o no certificado
        if (!empty($_FILES['imgCertificado']['name'])) {
            $extencion = pathinfo($_FILES['imgCertificado']['name'], PATHINFO_EXTENSION);
            $nom_archivo = $_SESSION['inicioSesion']['rut_usuario'] . "." . $extencion;

            //date_default_timezone_set("America/Santiago");
            $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
            $fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
            $rutaCertificado = "img/Imagenes/Certificados/" . $fechaSubida . " " . $nom_archivo;
            $archivo = $_FILES['imgCertificado']['tmp_name'];
            move_uploaded_file($archivo, $rutaCertificado);
        } else {
            $rutaCertificado = "Sin Certificado";
        }
        //crear la query para almacenar los datos
        $consultaSQL = ConexionBD::abrirConexion()->prepare("UPDATE usuario2 
        SET 
        nombre_usuario = ?, 
        apellidopat_usuario = ?, 
        apellidomat_usuario = ?, 
        sexo_usuario = ?, 
        pais_usuario = ?, 
        id_region = ?, 
        id_ciudad = ?, 
        id_comuna = ?, 
        fechanac_usuario = ?, 
        email_usuario = ?, 
        telefono_usuario = ?,
        foto_usuario = ?, 
        certificado_usuario = ? 
        WHERE 
        id_usuario = ?");

        $consultaSQL->bindParam(1, $_POST['nombre']);
        $consultaSQL->bindParam(2, $_POST['apellidopat']);
        $consultaSQL->bindParam(3, $_POST['apellidomat']);
        $consultaSQL->bindParam(4, $_POST['sexo']);
        $consultaSQL->bindParam(5, $_POST['pais']);
        $consultaSQL->bindParam(6, $_POST['regionUsuario']);
        $consultaSQL->bindParam(7, $_POST['ciudadUsuario']);
        $consultaSQL->bindParam(8, $_POST['comunaUsuario']);
        $consultaSQL->bindParam(9, $_POST['fecha_nac']);
        $consultaSQL->bindParam(10, $_POST['email']);
        $consultaSQL->bindParam(11, $_POST['telefono']);
        $consultaSQL->bindParam(12, $rutaAvatar);
        $consultaSQL->bindParam(13, $rutaCertificado);
        $consultaSQL->bindParam(14, $_SESSION['inicioSesion']['id_usuario']);


        if ($consultaSQL->execute()) {
            ConexionBD::cerrarConexion();
            echo "<script>alert('USUARIO ACTUALIZADO');</script>";
            //ACTUALIZAR LA SESSION
            $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM usuario2 WHERE rut_usuario = ?");
            $consultaSQL->bindParam(1, $_SESSION['inicioSesion']['rut_usuario']);
            $consultaSQL->execute();
            $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);
            $_SESSION['inicioSesion'] = $resultadoSQL; //recreamos la seccion con los datos actualizados
            header('Location: ./ActualizarDatosUsuario2.php');
            ConexionBD::cerrarConexion();
        } else {

            echo "<script>alert('ERROR EN ACTUALIZAR');</script>";
        }
        ConexionBD::cerrarConexion();
    } else {
        // si el rut ya existe ejecutar esto
        ConexionBD::cerrarConexion();
        echo "<script>alert('EL RUT INGRESADO YA EXISTE');</script>";
    }
}
?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Actualizar Datos</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    
    <!-- CSS -->
    <link rel="stylesheet" href="css2/owl.carousel.css">
    <link rel="stylesheet" href="css/bootstrap.css">
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

  <!-- script no se borra -->
 
        <script language="javascript" src="JavaScript/jquery-3.1.1.min.js"></script>



     <!-- SCRIPT QUE LLENA LOS COMBOBOX CIUDAD Y COMUNA - PRIMERO EL DE CIUDAD LUEGO DE ELEGIR REGION Y LUEGO EL DE COMUNA SEGUN LA CIUDAD ESCOGIDA -->
        <script language="javascript">
            $(document).ready(function () {
                $("#regionUsuario").change(function () {

                    $('#comunaUsuario').find('option').remove().end().append('<option selected value="0">Seleccione una ciudad primero...</option>');

                    $("#regionUsuario option:selected").each(function () {
                        id_region = $(this).val();
                        $.post("./PostgreSQL/LLenarCiudad.php", {id_region: id_region}, function (data) {
                            $("#ciudadUsuario").html(data);
                        });
                    });
                })
            });

            $(document).ready(function () {
                $("#ciudadUsuario").change(function () {
                    $("#ciudadUsuario option:selected").each(function () {
                        id_ciudad = $(this).val();
                        $.post("./PostgreSQL/LLenarComuna.php", {id_ciudad: id_ciudad}, function (data) {
                            $("#comunaUsuario").html(data);
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
              <!-- HEADER -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <div class="row">
                    <ul class="nav navbar-nav navbar-right collapse navbar-collapse">
                      <li><img src="img/logo.png" alt="Logo" height="50px" height="50px" style="margin-right: 50px;"></li>
                      <li><a href="indexUsuario.php" style ="margin: auto" >Inicio</a></li>
                      
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
                  <h1>Actualiza tus Datos</h1>
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
                  <form action="ActualizarDatosUsuario.php" method="POST" enctype="multipart/form-data">
             
                      <div class="form-group">
                    <label for="">Nombre:</label>
                          <input id="nombre" name="nombre" type="text" size="15" maxlength="15" class="form-control" value="<?php echo $_SESSION['inicioSesion']['nombre_usuario']; ?>" required>
                    </div> 
                      
                      <div class="form-group">
                          <label for="">Apellido Paterno:</label>
                          <input id="apellidopat" name="apellidopat" type="text" size="20" maxlength="20" class="form-control" value="<?php echo $_SESSION['inicioSesion']['apellidopat_usuario']; ?>" required >
                    </div>

                    <label>Por Razones de Seguridad tu Nombre y Apellidos solo podran ser Actualizados una sola vez por Año </label>
                      
                    <div class="form-group">
                       <label for="">Apellido Materno:</label>
                        <input id="apellidomat" name="apellidomat" type="text" size="20" maxlength="20" class="form-control" value="<?php echo $_SESSION['inicioSesion']['apellidomat_usuario']; ?>" required>
                    </div>
                      
                  <div class="form-group">

                  <label for="sexo">Sexo:</label>

                 <select id="sexoUsuario" name="sexo"  class="form-control">                       
                          <option value="seleccionar">seleccionar...</option>
                          <option value="masculino">Masculino</option>
                          <option value="femenino">Femenino</option>
                  </select>
                              <script>
                                    $(document).ready();
                                      {
                                         <?php if ($_SESSION['inicioSesion']['sexo_usuario'] == "masculino") { ?>
                                              sexoUsuario.selectedIndex = 1;
                                         <?php } else { ?>
                                              sexoUsuario.selectedIndex = 2;
                                        <?php } ?>
                                          }
                               </script>
                            </div>

                            
                      
                      
                        <div class="form-group"> 
                        <label for="">Seleccione Pais:</label>                       
                             <select id="pais" name="pais" class="form-control">
                           <option value="0">Seleccione Pais...</option> 
                                <option value="Chile">Chile</option>
                                </select>
                                <script>
                                    $(document).ready();{
                                        <?php if ($_SESSION['inicioSesion']['pais_usuario'] =="Chile") { ?>
                                            pais.selectedIndex = 1;
                                        <?php } else { ?>
                                            pais.selectedIndex = 0;
                                        <?php } ?>
                                    }
                                </script>
                      </div>
                                                                                     
                <div class="form-group">                        
                    <label for="region">Selecciona Región:</label>
                         <select id="regionUsuario" name="regionUsuario" class="form-control">
                         <option value="0">Seleccione una región...</option> 
                                        <?php foreach ($cboRegion as $dato) { ?>
                                        <option value="<?php echo $dato['id_region']; ?>"><?php echo $dato['nombre_region']; ?></option>
                                    <?php } ?>
                                </select>

                                <script>
                                    $(document).ready();
                                    {
                                        regionUsuario.selectedIndex = <?php echo $_SESSION['inicioSesion']['id_region'] ?>;

                                        $("#regionUsuario option:selected").each(function () {
                                            id_region = $(this).val();
                                            $.post("./PostgreSQL/LLenarCiudad.php", {id_region: id_region}, function (data) {
                                                $("#ciudadUsuario").html(data);

                                                ciudadUsuario.selectedIndex = <?php echo $_SESSION['inicioSesion']['id_ciudad'] ?>;
                                            });
                                        });
                                        $("#ciudadUsuario option:selected").ready(function () {
                                            var dato = <?php echo $_SESSION['inicioSesion']['id_ciudad'] ?>;
                                            id_ciudad = dato;
                                            $.post("./PostgreSQL/LLenarComuna.php", {id_ciudad: id_ciudad}, function (data) {
                                                $("#comunaUsuario").html(data);
                                                comunaUsuario.selectedIndex = <?php echo $_SESSION['inicioSesion']['id_comuna'] ?>;
                                            });
                                        });
                                    }
                                </script>
                        </div>
                      
                        <div class="form-group">  
                            <label for="">Ciudad:</label>                      
                             <select id="ciudadUsuario" name="ciudadUsuario" class="form-control">
                                <option value="0">Seleccione una region primero...</option> 
                                </select>
                       </div>
                                                                
                      <div class="form-group">  
                          <label for="">Comuna:</label>                      
                            <select id="comunaUsuario" name="comunaUsuario" class="form-control">
                                <option value="0">Seleccione una ciudad primero...</option> 
                                </select>
                    </div>                                              
                      <div class="form-group">                                             
                           <label for="">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="<?php echo $_SESSION['inicioSesion']['fechanac_usuario']; ?>">                
                              </div>
                                                                                                     
                      <div class="form-group">
                          <label for="">Correo:</label>
                          <input id="email" name="email" type="text" size="50" maxlength="50" class="form-control" value="<?php echo $_SESSION['inicioSesion']['email_usuario']; ?>">
                      </div> 
                          
                      <div class="form-group">                                           
                            <label for="">Telefono:</label>
                            <label for="">Ejemplo: 946771128</label>
                          <input id="telefono" name="telefono" type="text" size="9" maxlength="9"  class="form-control" value="<?php echo $_SESSION['inicioSesion']['telefono_usuario']; ?>" oninput="soloNumeros(this)">
                          <script src="./JavaScript/SoloNumeros.js"></script>
                    </div>
                      
                          
                      <div class="form-group">                        
                        <label for="FotoPerfil">Foto de Perfil:</label>
                        <img class="rounded-circle" src="<?php echo $_SESSION['inicioSesion']['foto_usuario']?>" width="50" height="50">
                        <input type="file" id="img-uploader" class="form-control" name="imgAvatar" >
                    </div>
                      
                       <div class="form-group">                        
                                <label for="Certificado">Certificado</label>
                                <input type="file" id="img-uploader" name="imgCertificado" class="form-control" >
                                <label for="">Aqui Puedes Incluir Nuevamente Un Certificado Por Si El Anterior Fue Rechazado, Tambien Puedes Subir Otros Certificados Que Tengas Por Si Tienes
                                Mas De Uno</label>
                      </div>
                      
                    
                   
                      <button class="btn btn-default" type="submit" name="ActualizarDatosUsuario.php" >Actualizar</button>

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