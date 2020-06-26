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
if (!empty($_POST['region'])) {
    $region = $_POST['region'];
};



//comprobar que campos tengan datos  ESTO AUN NO ESTA DEFINIDO, ES UNO PROVISORIO SOLO FUNCIONARA SI ELIJES LA 5 REGION
if ($region == "5") {
    echo $iniciar;
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
        password_usuario = ?, 
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


        $password = password_hash($_POST['passwordNuevo'], PASSWORD_BCRYPT);
        $consultaSQL->bindParam(1, $password);
        $consultaSQL->bindParam(2, $_POST['nombre']);
        $consultaSQL->bindParam(3, $_POST['apellidopat']);
        $consultaSQL->bindParam(4, $_POST['apellidomat']);
        $consultaSQL->bindParam(5, $_POST['sexo']);
        $consultaSQL->bindParam(6, $_POST['pais']);
        $consultaSQL->bindParam(7, $_POST['region']);
        $consultaSQL->bindParam(8, $_POST['ciudad']);
        $consultaSQL->bindParam(9, $_POST['comuna']);
        $consultaSQL->bindParam(10, $_POST['fecha_nac']);
        $consultaSQL->bindParam(11, $_POST['email']);
        $consultaSQL->bindParam(12, $_POST['telefono']);
        $consultaSQL->bindParam(13, $rutaAvatar);
        $consultaSQL->bindParam(14, $rutaCertificado);
        $consultaSQL->bindParam(15, $_SESSION['inicioSesion']['id_usuario']);


        if ($consultaSQL->execute()) {
            ConexionBD::cerrarConexion();
            echo "<script>alert('USUARIO ACTUALIZADO');</script>";
            //ACTUALIZAR LA SESSION
            $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM usuario2 WHERE rut_usuario = ?");
            $consultaSQL->bindParam(1, $_SESSION['inicioSesion']['rut_usuario']);
            $consultaSQL->execute();
            $resultadoSQL = $consultaSQL->fetch(PDO::FETCH_ASSOC);
            $_SESSION['inicioSesion'] = $resultadoSQL; //recreamos la seccion con los datos actualizados
            header('Location: ./ActualizarDatosUsuario.php');
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
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
<<<<<<< HEAD
 

=======
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>



>>>>>>> 566b42aa2aa05b28a007a35c831f801ff515bb01
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="css/ActualizarDatos.css">

        <script language="javascript" src="js/jquery-3.3.1.min.js"></script>
        


<<<<<<< HEAD
        <!--SCRIPT QUE LLENA LOS COMBOBOX CIUDAD Y COMUNA - PRIMERO EL DE CIUDAD LUEGO DE ELEGIR REGION Y LUEGO EL DE COMUNA SEGUN LA CIUDAD ESCOGIDA -->
=======
        //SCRIPT QUE LLENA LOS COMBOBOX CIUDAD Y COMUNA - PRIMERO EL DE CIUDAD LUEGO DE ELEGIR REGION Y LUEGO EL DE COMUNA SEGUN LA CIUDAD ESCOGIDA 
>>>>>>> 566b42aa2aa05b28a007a35c831f801ff515bb01
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





        <form action="ActualizarDatosUsuario.php" method="POST" enctype="multipart/form-data">

            <div class="login-wrap">
                <div class="login-html">
                    <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
                    <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Actualiza Tus Datos</label>
                    <div class="login-form">
                        <div class="sign-in-htm">
                            <div class="group">
                                <label for="user" class="label">Username</label>
                                <input id="user" type="text" class="input">
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Password</label>
                                <input id="pass" type="password" class="input" data-type="password">
                            </div>
                            <div class="group">
                                <input id="check" type="checkbox" class="check" checked>
                                <label for="check"><span class="icon"></span> Keep me Signed in</label>
                            </div>
                            <div class="group">
                                <input type="submit" class="button" value="Sign In">
                            </div>
                            <div class="hr"></div>
                            <div class="foot-lnk">
                                <a href="#forgot">Forgot Password?</a>
                            </div>
                        </div>



                        <div class="sign-up-htm">



                            <div class="group">

                                <label for="nombre" class="label">Nombre</label>

                                <input id="nombre" name="nombre" type="text" class="input" value="<?php echo $_SESSION['inicioSesion']['nombre_usuario']; ?>" required />

                            </div>


                            <div class="group">

                                <label for="apellidopat" class="label">Apellido Paterno</label>

                                <input id="apellidopat" name="apellidopat" type="text" class="input" value="<?php echo $_SESSION['inicioSesion']['apellidopat_usuario']; ?>" required />

                            </div>


<<<<<<< HEAD
                            <!-- ESTA ADVERTENCIA AUN NO ESTA PROGRAMADA -->
=======
                            //ESTA ADVERTENCIA AUN NO ESTA PROGRAMADA
>>>>>>> 566b42aa2aa05b28a007a35c831f801ff515bb01
                            <label>NOTA:  Por Razones de Seguridad tu Nombre y Apellidos solo podran ser Actualizados una sola vez por Año </label>

                            <div class="group">

                                <label for="apellidomat" class="label">Apellido Materno</label>

                                <input id="nombre" name="apellidomat" type="text" class="input" value="<?php echo $_SESSION['inicioSesion']['apellidomat_usuario']; ?>" required />

                            </div>

                            <div class="group">

                                <label for="passwordNuevo" class="label">clave</label>

                                <input id="passwordNuevo" name="passwordNuevo" type="password" class="input" required />

                            </div>

                            <div class="group">

                                <label for="sexo" class="label">Sexo</label>

                                <select id="sexoUsuario" name="sexo"  required>
                                    <br />

                                    <option value="seleccionar">seleccionar...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>

                                <script>
                                    $(document).ready();{
                                        <?php if ($_SESSION['inicioSesion']['sexo_usuario'] == "masculino") { ?>
                                            sexoUsuario.selectedIndex = 1;
                                        <?php } else { ?>
                                            sexoUsuario.selectedIndex = 2;
                                        <?php } ?>
                                    }
                                </script>

                            </div>



                            <div class="group">

                                <label for="pais" class="label">Pais</label>

                                <select id="pais" name="pais" required>



                                    <option value="Chile">Chile</option>
                                </select>


                            </div>



                            <div class="group">

                                <label for="region" class="label">Selecciona Region</label>

                                <select id="regionUsuario" name="region">
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
                                            });
                                        });

                                    }



                                </script>
                            </div>





                            <div class="group">

                                <label for="ciudad" class="label">Ciudad</label>

                                <select id="ciudadUsuario" name="ciudad">
                                    <option value="0">Seleccione una region primero...</option> 
                                </select>


                            </div>



                            <div class="group">

                                <label for="comuna" class="label">Comuna</label>

                                <select id="comunaUsuario" name="comuna">
                                    <option value="0">Seleccione una ciudad primero...</option> 
                                </select>

                            </div>



                            <div class="group">

                                <label for="Fecha_Nacimiento" class="label">Fecha Nacimiento</label>

                                <input type="date" class="form-control" id="email" name="fecha_nac" placeholder="Ingrese su Fecha_nac" value="<?php echo $_SESSION['inicioSesion']['fechanac_usuario']; ?>" required />

                            </div>




                            <div class="group">

                                <label for="email" class="label">Email</label>

                                <input id="email" name="email" type="text" class="input" value="<?php echo $_SESSION['inicioSesion']['email_usuario']; ?>" required />

                            </div>



                            <div class="group">

                                <label for="telefono" class="label">Telefono</label>

                                <input id="telefono" name="telefono" type="text" class="input" value="<?php echo $_SESSION['inicioSesion']['telefono_usuario']; ?>" required />

                            </div>


                            <div class="group">

                                <label for="imgup" class="label">Foto</label>

                                <input type="file" id="img-uploader" name="imgAvatar">

                                <img class="rounded-circle" src="<?php echo $_SESSION['inicioSesion']['foto_usuario'] ?>" width="50" height="50">

                            </div> 




                            <div class="group">

                                <label for="imgup" class="label">Certificado De Estudios</label>

                                <input type="file" id="img-uploader" name="imgCertificado">

                            </div> 

                            <label>NOTA: Aqui Puedes Incluir Nuevamente Un Certificado Por Si El Anterior Fue Rechazado, Tambien Puedes Subir Otros Certificados Que Tengas Por Si Tienes
                                Mas De Uno
                            </label>     

                            <div class="group">
                                <input type="submit" class="button" name="RegistroUsuario.php" value="Actualizar">
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </form>


    </body>
</html>

