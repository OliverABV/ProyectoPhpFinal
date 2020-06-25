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
	//preguntamos si es un USUARIO y si es asi creamos la $_SESSION que se almacena como OBJETO
    if (($total > 0) && (password_verify($_POST['pass'], $resultadoSQL['password_usuario']))) {
        $_SESSION['inicioSesion'] = $resultadoSQL;
        echo "ESTE ES UN USUARIO";
        header('Location: ./MaquetaPublicaciones.php');
    } else {
		//si no es un usuario preguntamos ahora si es una entidad
        $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM entidad WHERE rut_entidad = ?");
        $consultaSQL->bindParam(1, $_POST['user']);
        $consultaSQL->execute();
        $total = $consultaSQL->rowCount();
        //obtenemos los resultados como un array, si no llega nada se resive el bolean false
        $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);

        $message = '';
		//verificamos si es una entidad y si es asi creamos la $_SESSION que se almacena como OBJETO
        if (($total > 0) && (password_verify($_POST['pass'], $resultadoSQL['password_entidad']))) {
            $_SESSION['inicioSesion'] = $resultadoSQL;
            echo "ESTE ES UNA ENTIDAD";
            header('Location: ./MaquetaPublicaciones.php');
        } else {
			//Si no se encontro nada en usuario y luego nada en entidad se niega el acceso
            $message = "USUARIO O ENTIDAD NO EXISTE";
            echo "USUARIO O ENTIDAD NO EXISTE";
        }
    }
}
?>
<html lang="es">
<head>
    <link type="text/css" rel=stylesheet href="css/Login2.css"> 
      <?php include ('HeaderFinal.php'); ?> 

	<title>Inicio de Sesion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="imagenes/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/Login2.css">  
</head>
<body>
	<div class="container-contact100">
		<div class="wrap-contact100">
			
            
    <form class="contact100-form" action="Login2.php" method="POST" enctype="multipart/form-data">
	
        <span class="contact100-form-title">
                        EduWeb
		</span>

                            <!--MENU-->

   
                
	<div class="wrap-input100 validate-input" data-validate="Dato Requerido">
	<label class="label-input100" for="name">Rut</label>
  	<input  id="user" class="input100" type="text" size="10" maxlength="10"  name="user" placeholder="Ingrese su rut" required oninput="checkRut(this)" required />
	  <script src="./JavaScript/FormatoValidaRut.js"></script>
          <span class="focus-input100"></span>
	</div>


	<div class="wrap-input100 validate-input" data-validate="Dato Requerido">
	<label class="label-input100" for="name">Contraseña</label>
	<input id="pass" class="input100" type="password" name="pass" placeholder="Ingrese Contraseña" data-type="password" required />
	<span class="focus-input100"></span>
	</div>
 
                <!--boton para enviar-->    

<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="btning" type="submit">
Ingresar
</button></div>

    <div class="container-contact100-form-btn">
      <button class="contact100-form-btn" name="btnreg" role="link" onclick="window.location='RegistroPrueba.php'" >
    Registrarme
   
</button></div>              
                

  
             
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('img/Imagenes/sistema/bg-01.jpg');">
			</div>
		</div>
	</div>



	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/main.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
</body>
</html>
