  <?php
//habilitar BD

include_once './PostgreSQL/ConexionBD.php';

$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_region, nombre_region FROM region");
$consultaSQL->execute();
$cboRegionUsuario = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
$cboRegionEntidad = $cboRegionUsuario;
ConexionBD::cerrarConexion();

$message = '';
//comrpobar que campos tengan datos
if (!empty($_POST['rut']) && !empty($_POST['passwordNuevo']) && !empty($_POST['nombre']) && !empty($_POST['apellidopat']) && !empty($_POST['apellidomat']) && !empty($_POST['sexo']) && !empty($_POST['pais']) && !empty($_POST['region']) && !empty($_POST['ciudad']) && !empty($_POST['comuna']) && !empty($_POST['fecha_nac']) && !empty($_POST['email']) && !empty($_POST['telefono'])) {

    //verificar que ya no exista el RUT en la BD
    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(rut_usuario) FROM usuario2 WHERE rut_usuario = ?");
    $consultaSQL->bindParam(1, $_POST['rut']);
    $consultaSQL->execute();

    if ($consultaSQL->fetchColumn() == 0) {
        ConexionBD::cerrarConexion();
        //echo "<script>alert('ENTRO EN SI');</script>";
        //echo '<script>alert (" Ha respondido '.$acumulador.' respuestas afirmativas");</script>';
        //verifica si se incluye o no avatar
        if (!empty($_FILES['imgAvatar']['name'])) {
            $extencion = pathinfo($_FILES['imgAvatar']['name'], PATHINFO_EXTENSION);
            $nom_archivo = $_POST['rut'] . "." . $extencion;

            //date_default_timezone_set("America/Santiago");
            $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
            $fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
            $rutaAvatar = "img/Imagenes/FotosPerfiles/Usuarios/" . $fechaSubida . " " . $nom_archivo;
            $archivo = $_FILES['imgAvatar']['tmp_name'];
            move_uploaded_file($archivo, $rutaAvatar);
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
            $nom_archivo = $_POST['rut'] . "." . $extencion;

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
        $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO usuario2 (rut_usuario, password_usuario, nombre_usuario, apellidopat_usuario, apellidomat_usuario, sexo_usuario, pais_usuario, id_region, id_ciudad, id_comuna, fechanac_usuario, email_usuario, telefono_usuario, Foto_usuario, certificado_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $consultaSQL->bindParam(1, $_POST['rut']);
        $password = password_hash($_POST['passwordNuevo'], PASSWORD_BCRYPT);
        $consultaSQL->bindParam(2, $password);
        $consultaSQL->bindParam(3, $_POST['nombre']);
        $consultaSQL->bindParam(4, $_POST['apellidopat']);
        $consultaSQL->bindParam(5, $_POST['apellidomat']);
        $consultaSQL->bindParam(6, $_POST['sexo']);
        $consultaSQL->bindParam(7, $_POST['pais']);
        $consultaSQL->bindParam(8, $_POST['region']);
        $consultaSQL->bindParam(9, $_POST['ciudad']);
        $consultaSQL->bindParam(10, $_POST['comuna']);
        $consultaSQL->bindParam(11, $_POST['fecha_nac']);
        $consultaSQL->bindParam(12, $_POST['email']);
        $consultaSQL->bindParam(13, $_POST['telefono']);
        $consultaSQL->bindParam(14, $rutaAvatar);
        $consultaSQL->bindParam(15, $rutaCertificado);


        if ($consultaSQL->execute()) {

            echo "<script>alert('USUARIO REGISTRADO');</script>";
        } else {

            echo "<script>alert('ERROR EN REGISTRO');</script>";
        }
        ConexionBD::cerrarConexion();
    } else {
        // si el rut ya existe ejecutar esto
        ConexionBD::cerrarConexion();
        echo "<script>alert('EL RUT INGRESADO YA EXISTE');</script>";
    }
}
ConexionBD::cerrarConexion();
// Conexion Entidad
include_once './PostgreSQL/ConexionBD.php';

$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_region, nombre_region FROM region");
$consultaSQL->execute();
$cboRegion = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();
$message = '';
//comrpobar que campos tengan datos
if (!empty($_POST['rut']) && !empty($_POST['email']) && !empty($_POST['passwordNuevoEnt2']) && !empty($_POST['razonSocial']) && !empty($_POST['nombreComercial']) && !empty($_POST['rol']) && !empty($_POST['pais']) && !empty($_POST['region']) && !empty($_POST['ciudad']) && !empty($_POST['comuna']) && !empty($_POST['calle']) && !empty($_POST['numero']) && !empty($_POST['piso']) && !empty($_POST['telefono'])) {

    //verificar que ya no exista el RUT en la BD
    $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(rut_entidad) FROM entidad WHERE rut_entidad = ?");
    $consultaSQL->bindParam(1, $_POST['rut']);
    $consultaSQL->execute();

    if ($consultaSQL->fetchColumn() == 0) {
        ConexionBD::cerrarConexion();
        //echo "<script>alert('ENTRO EN SI');</script>";
        //echo '<script>alert (" Ha respondido '.$acumulador.' respuestas afirmativas");</script>';
        //verifica si se incluye o no certificado
        if (!empty($_FILES['imgFotoEntidad']['name'])) {
            $extencion = pathinfo($_FILES['imgFotoEntidad']['name'], PATHINFO_EXTENSION);
            $nom_archivo = $_POST['rut'] . "." . $extencion;

            //date_default_timezone_set("America/Santiago");
            $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
            $fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
            $ruta = "img/Imagenes/FotosPerfiles/Entidades/" . $fechaSubida . " " . $nom_archivo;
            $archivo = $_FILES['imgFotoEntidad']['tmp_name'];
            move_uploaded_file($archivo, $ruta);
        } else {
            $ruta = "Sin Foto";
        }
        //crear la query para almacenar los datos
        $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO entidad (rut_entidad, email_entidad, password_entidad, razon_social_entidad, nombre_comercial_entidad, rol_entidad, pais_entidad, id_region, id_ciudad, id_comuna, calle_entidad, numero_entidad, piso_entidad, telefono_entidad, foto_entidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $consultaSQL->bindParam(1, $_POST['rut']);
        $consultaSQL->bindParam(2, $_POST['email']);
        $password = password_hash($_POST['passwordNuevoEnt2'], PASSWORD_BCRYPT);
        $consultaSQL->bindParam(3, $password);
        $consultaSQL->bindParam(4, $_POST['razonSocial']);
        $consultaSQL->bindParam(5, $_POST['nombreComercial']);
        $consultaSQL->bindParam(6, $_POST['rol']);
        $consultaSQL->bindParam(7, $_POST['pais']);
        $consultaSQL->bindParam(8, $_POST['region']);
        $consultaSQL->bindParam(9, $_POST['ciudad']);
        $consultaSQL->bindParam(10, $_POST['comuna']);
        $consultaSQL->bindParam(11, $_POST['calle']);
        $consultaSQL->bindParam(12, $_POST['numero']);
        $consultaSQL->bindParam(13, $_POST['piso']);
        $consultaSQL->bindParam(14, $_POST['telefono']);
        $consultaSQL->bindParam(15, $ruta);


        if ($consultaSQL->execute()) {

            echo "<script>alert('USUARIO REGISTRADO');</script>";
        } else {

            echo "<script>alert('ERROR EN REGISTRO');</script>";
        }
        ConexionBD::cerrarConexion();
    } else {
        // si el rut ya existe ejecutar esto
        ConexionBD::cerrarConexion();
        echo "<script>alert('EL RUT INGRESADO YA EXISTE');</script>";
    }
}
ConexionBD::cerrarConexion();

?>





<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Space template</title>
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
    <script src="js/min/waypoints.min.js"></script>
    <script src="js/jquery.counterup.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

       <!-- js Usuario -->
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

               <!-- js Entidad -->
    <script language="javascript">
            $(document).ready(function () {
                $("#regionEntidad").change(function () {

                    $('#comunaEntidad').find('option').remove().end().append('<option selected value="0">Seleccione una ciudad primero...</option>');

                    $("#regionEntidad option:selected").each(function () {
                        id_region = $(this).val();
                        $.post("./PostgreSQL/LLenarCiudad.php", {id_region: id_region}, function (data) {
                            $("#ciudadEntidad").html(data);
                        });
                    });
                })
            });

            $(document).ready(function () {
                $("#ciudadEntidad").change(function () {
                    $("#ciudadEntidad option:selected").each(function () {
                        id_ciudad = $(this).val();
                        $.post("./PostgreSQL/LLenarComuna.php", {id_ciudad: id_ciudad}, function (data) {
                            $("#comunaEntidad").html(data);
                        });
                    });
                })
            });


        </script>
      
    <script type="text/javascript" src="js/jquery.js"></script>

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
                        <h1>Just some of our latest projects.</h1>
                        <p>Don’t just take our word for it. Check out some of our latest work.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <!-- Portfolio Start -->
    <section id="portfolio-work">
        <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="block">
                  <div class="portfolio-menu">
                    <ul>
                        <li id="Usuario" class="filter" data-filter=".Usuario">Usuario</li>
                        <li id="Entidad" class="filter"  data-filter=".Entidad">Entidad</li>
                    </ul>
                  </div>
                  <div class="portfolio-contant">
                    <ul id="portfolio-contant-active">
                    
                  
        <li class="mix Usuario">                          
                        <a href="#">
                          <img src="img/portfolio/work5.jpg" alt="">
                          <div class="overly">
                            <div class="position-center">
                              <h2>EduWeb</h2>
                              <p>Texto Atractivo </p>                            
                            </div>
                          </div>                        
                        </a>
                      </li>
                    
        <li class="mix Usuario">
                      <form action="Registro.php" method="POST" enctype="multipart/form-data">
                     
                    <div class="form-group">
                        <input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut" required oninput="checkRut(this)"  required>
                          <script src="./JavaScript/FormatoValidaRut.js"></script>
                   </div>
                      
                    <div class="form-group">
                           <input type="password" id="pass" name="passwordNuevo" class="form-control" data-type="password" placeholder="Ingrese Password" required>
                    </div> 
                      
                    <div class="form-group">
                          <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                    </div> 
                      
                    <div class="form-group">
                          <input id="apellidopat" name="apellidopat" type="text" class="form-control" placeholder="Ingrese Apellido Paterno" required>
                    </div>
                      
                      
                    <div class="form-group">
                        <input id="apellidomat" name="apellidomat" type="text" class="form-control" placeholder="Ingrese Apellido Materno" required>
                    </div>

                    <div class="form-group">                 
                       <select id="sexo" name="sexo"  class="form-control"  required />
                          <option value="0">Seleccione su Sexo</option> 
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                </select>
                    </div>
                      
                      
                      
                      
                    <div class="form-group">                
                       <select id="paisUsuario" name="pais" class="form-control" required />
                        <option value="0">Seleccione Pais...</option> 
                                <option value="Chile">Chile</option>
                                </select>
                    </div>
                      
                      
                      
                      
                    <div class="form-group">                         
                      <select id="regionUsuario" name="regionUsuario" class="form-control" required />
                            <option value="0">Seleccione una región...</option> 
                                <?php foreach ($cboRegionUsuario as $dato) { ?>
                                    <option value="<?php echo $dato['id_region']; ?>"><?php echo $dato['nombre_region']; ?></option>
                                <?php } ?>
                                </select>
                    </div>
                      
                    <div class="form-group">                        
                             <select id="ciudadUsuario" name="ciudadUsuario" class="form-control" required />
                                <option value="0">Seleccione una region primero...</option> 
                                </select>
                    </div>
                      
                      
                      
                    <div class="form-group">                         
                            <select id="comunaUsuario" name="comunaUsuario" class="form-control" required />
                                <option value="0">Seleccione una ciudad primero...</option> 
                                </select>
                    </div>
                      
                          
                    <div class="form-group">
                        <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Ingrese su Fecha_nac" required />
                    </div>
                      
                      
                          
                 
                      
                    <div class="form-group">                        
                          <input id="email" name="email" type="text" class="form-control" placeholder="Ingrese Email" required>
                    </div> 
                          
                    <div class="form-group">                
                          <input id="telefono" name="telefono" type="text" class="form-control" placeholder="Ingrese Telefono" required>
                    </div>
                      
                          
                    <div class="form-group">                       
                        <label for="FotoPerfil">Foto de Perfil:</label>
                        <input type="file" id="img-uploader" class="form-control" name="imgAvatar" >
                    </div>
                      
                      
                    <div class="form-group">                        
                                <label for="Certificado">Certificado</label>
                                <input type="file" id="img-uploader" name="imgCertificado" class="form-control" >
                    </div>
                   
                      <button class="btn btn-default" type="submit" name="RegistroUsuario.php" >Registrar</button>

                  </form>
                      </li>
                      
                      
                      
          <li class="mix Entidad">
                        <a href="#">
                          <img src="img/portfolio/work5.jpg" alt="">
                          <div class="overly">
                            <div class="position-center">
                              <h2>Tesla Motors</h2>
                              <p>Labore et dolore magna aliqua. Ut enim ad </p>                            
                            </div>
                          </div>
                        </a>
                      </li>

          <li class="mix Entidad">
                     <form action="Registro.php" method="POST" enctype="multipart/form-data">
                     <script>
                     
                     </script>
                            
                    <div class="form-group">
                        <input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese Rut" required oninput="checkRut(this)"  required>
                        <script src="./JavaScript/FormatoValidaRut.js"></script>
                    </div>
                      
                    <div class="form-group">                        
                       <input id="email" name="email" type="text" class="form-control" placeholder="Ingrese Email" required>
                    </div> 

                    <div class="form-group">
                           <input type="password" id="pass" name="passwordNuevoEnt" class="form-control" data-type="password" placeholder="Ingrese Password" required>
                    </div> 
                      
                    <div class="form-group">                        
                       <input id="razonSocial" name="razonSocial" type="text" class="form-control" placeholder="Ingrese Razon Social" required>
                    </div> 

                    <div class="form-group">                        
                       <input id="nombreComercial" name="nombreComercial" type="text" class="form-control" placeholder="Ingrese Nombre Comercial" required>
                    </div>
                    
                    <div class="form-group">                        
                       <input id="rol" name="rol" type="text" class="form-control" placeholder="Ingrese Rol" required>
                    </div> 

                    <div class="form-group">                        
                        <select id="paisEntidad" name="pais" class="form-control" required />
                           <option value="0">Seleccione Pais...</option> 
                                <option value="Chile">Chile</option>
                        </select>
                    </div>                                                                
                      
                    <div class="form-group">                         
                      <select id="regionEntidad" name="regionEntidad" class="form-control" required />
                            <option value="0">Seleccione una región...</option> 
                                <?php foreach ($cboRegionEntidad as $dato) { ?>
                                    <option value="<?php echo $dato['id_region']; ?>"><?php echo $dato['nombre_region']; ?></option>
                                <?php } ?>
                                </select>
                    </div>
                      
                    <div class="form-group">                        
                             <select id="ciudadEntidad" name="ciudadEntidad" class="form-control" required />
                                <option value="0">Seleccione una region primero...</option> 
                                </select>
                    </div>
                      
                      
                      
                    <div class="form-group">                         
                            <select id="comunaEntidad" name="comunaEntidad" class="form-control" required />
                                <option value="0">Seleccione una ciudad primero...</option> 
                                </select>
                    </div>
                                       
                    <div class="form-group">                                            
                      <input type="text" name="calle" class="form-control" placeholder="Calle" onkeypress="return soloLetras(event)" required />
                      <script src="./JavaScript/SoloLetras.js"></script>
                    </div>
                                                                   
                    <div class="form-group">                                           
                      <input type="text" name="numero" class="form-control" placeholder="Numero" onkeypress="return soloNumeros(event)" required />
                       <script src="./JavaScript/SoloNumeros.js"></script>
                    </div>
                                               
                    <div class="form-group">                        
                      <input type="text" name="piso" class="form-control" placeholder="Piso"  />
                    </div>

                    <div class="form-group">                        
                      <input type="text" name="telefono" class="form-control" placeholder="Telefono"  />
                    </div>
                      
                    <div class="form-group">                       
                        <label for="FotoPerfil">Foto de Perfil:</label>
                        <input type="file" id="img-uploader" class="form-control" name="imgFotoEntidad" >
                    </div>
                                                                                                       
                      <button class="btn btn-default" type="submit" name="RegistroUsuario.php" >Registrar</button>
                  </form>                                                                                                      
         </li>                                                                                                                                               
                    </ul>
                  </div>
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

<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
        
    </body>
</html>
