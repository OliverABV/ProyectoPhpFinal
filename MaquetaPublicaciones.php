<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login2.php');
}
?>
<?php
include_once './PostgreSQL/ConexionBD.php';
$publicacionesDatosSQL = ConexionBD::abrirConexion()->prepare("(SELECT publicacion_usuario.*, usuario2.foto_usuario, usuario2.certificado_usuario
FROM publicacion_usuario 
INNER JOIN usuario2
ON publicacion_usuario.id_usuario = usuario2.id_usuario)
UNION
(SELECT publicacion_entidad.*, entidad.foto_entidad, entidad.nombre_comercial_entidad
FROM publicacion_entidad 
INNER JOIN entidad
ON publicacion_entidad.id_entidad = entidad.id_entidad)
ORDER BY fecha_registro");
$publicacionesDatosSQL->execute();
ConexionBD::cerrarConexion();

$publicacionesTutoriaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario INNER JOIN usuario2 ON publicacion_usuario.id_usuario = usuario2.id_usuario WHERE categoria_publicacion = 'tutoria'");
$publicacionesTutoriaSQL->execute();
ConexionBD::cerrarConexion();
$publicacionesAsesoriaSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_usuario INNER JOIN usuario2 ON publicacion_usuario.id_usuario = usuario2.id_usuario WHERE categoria_publicacion = 'asesoria'");
$publicacionesAsesoriaSQL->execute();
ConexionBD::cerrarConexion();
$publicacionesOportunidadSQL = ConexionBD::abrirConexion()->prepare("SELECT * FROM publicacion_entidad INNER JOIN entidad ON publicacion_entidad.id_entidad = entidad.id_entidad WHERE categoria_publicacion = 'oportunidad'");
$publicacionesOportunidadSQL->execute();
ConexionBD::cerrarConexion();

if (!empty($_GET['filtro'])) {
    if ($_GET['filtro'] == "tutoria") {
        $filtro = $publicacionesTutoriaSQL;
    } elseif ($_GET['filtro'] == "asesoria") {
        $filtro = $publicacionesAsesoriaSQL;
    } elseif ($_GET['filtro'] == "oportunidad") {
        $filtro = $publicacionesOportunidadSQL;
    }
} else {
    $filtro = $publicacionesDatosSQL;
}
?>

<!DOCTYPE html>

<html lang="es">
    <head>
        <title>Publicaciones</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/Publicaciones2.css">
        <link rel="stylesheet" href="css/bootstrap-grid.css">
        <link rel="stylesheet" href="css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/jquery.rateyo.css"/>
        <link rel="stylesheet" href="css/jquery.rateyo.min.css"/>
        <!--SCRIPT -->
        <script src="JavaScript/jquery-3.2.1.js"></script>
        <script src="JavaScript/script.js"></script>
        <script src="JavaScript/jquery.rateyo.js"></script>
        <script src="JavaScript/jquery.min.js"></script>
        <script src="JavaScript/jquery.rateyo.min.js"></script>

    </head>
    <body>

        <div id="wrapper">

            <header>
                <div class="inner_header">
                    <ul class="navigation">

                        <nav class="navbar navbar-light bg-light">
                        <a><img src="img/logo.png" alt=""></a>
                        <a href="index.php">Inicio</a>
                        <a href="index.php">Acerca De</a>
                        <a href="index.php">Publicaciones</a>
                        <a href="index.php">Contacto</a>
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
                            <a href="#">Mi Cuenta </a>
                            <a href="CerrarSesion.php">Cerrar Sesion</a>
                        </nav>

                    </ul>

                </div>
            </header>
            <div>
            <?php include('MenuLateral.php'); ?>
            </div>

        </div>


        <!-- El contenedor Contiene Todo lo que biene despues del header con una anchura difinida simpre del 90% sea el tamaño que esta pagian tenga
    -->
        <div id="contenedor" style="
                        width: 90%;
                        background: ;
                        margin: auto;
                        " > 
            <!--  el contenido es el cuadro lateral izquierdo para llenar con weas-->
            <div id="contenido"> 
                <div class="lateral" style="
                        width: 25%;
                        height: 100%;
                        margin: left;
                        position: absolute;
                        " ></div>
                        
            <!-- esto contiene la grilla-->
                <div id="section" style="
                                            background:;
                                            width: 50%;
                                            height: 50%;
                                            margin: auto;
                                        ">
                                        Lista de Publicaciones:
                    <hr>
                    <!-- FOREACH QUE CREA LA LISTA DE LAS PUBLICACIONES "filtro" RESIVE LOS DATOS SEGUN EL FILTRO QUE SE SELECCIONA-->
                    <?php foreach ($filtro as $publicacion) { ?>     


                        <div class="container-fluid" id="publicacion-container">



                            <div class="row">
                                <div class="col-3 bg" id="publicacion-foto">

                                    <div class="row">
                                        <div class="col bg">
                                            <!-- SE COLOCA EL AVATAR DEL USUARIO DUEÑO DE LA PUBLICACION LISTADA -->
                                            <img src="<?php
                                            if (!empty($publicacion['foto_usuario'])) {
                                                echo $publicacion['foto_usuario'];
                                            } else {
                                                echo $publicacion['foto_entidad'];
                                            }
                                            ?>" width="100" height="100" alt="Imagen.Publicacion" class="img-responsive">

                                        </div>
                                    </div>
                                </div>


                                <div class="col-6 bg">
                                    <div class="row row-cols-1">
                                        <div class="col bg">
                                            <!-- TITULO CON LINK PARA REDIRIGIR A LA VISTA DETALLADA DE LA PUBLICACION SELECCIONADA CLIKEANDO SU TITULO -->
                                            <?php if (!empty($publicacion['id_publicacion_usuario'])) { ?>
                                                <?php if ($publicacion['categoria_publicacion'] == "tutoria") { ?>
                                                    <div class="titulo">
                                                        Titulo: <?php echo "<a class='publicacion' href=DetallesTuroria.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                                    </div>
                                                <?php } elseif ($publicacion['categoria_publicacion'] == "asesoria") { ?>
                                                    Titulo:  <?php echo "<a class='publicacion' href=DetallesAsesoria.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                                <?php } elseif ($publicacion['categoria_publicacion'] == "oportunidad") { ?>
                                                    Titulo: <?php echo "<a class='publicacion' href=DetallesOportunidad.php?id=" . $publicacion['id_publicacion_usuario'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                                <?php } ?>

                                            <?php } elseif (!empty($publicacion['id_publicacion_entidad'])) { ?>
                                                Titulo: <?php echo "<a class='publicacion' href=DetallesOportunidad.php?id=" . $publicacion['id_publicacion_entidad'] . ">" . $publicacion['titulo'] . "</a>"; ?>
                                            <?php } ?>

                                        </div>
                                        <!-- INCLUYE Y NO INCLUYE -->
                                        <div class="col bg">Incluye: <?php echo $publicacion['si_incluye'] ?></div>
                                        <div class="col bg">Excluye: <?php echo $publicacion['no_incluye'] ?></div>
                                        <div class="col bg">Tipo: Tipo</div>
                                        <div class="col bg">Certificado: <?php
                                            if (!empty($publicacion['certificado_usuario'])) {
                                                echo $publicacion['certificado_usuario'];
                                            }
                                            ?></div>
                                        <!-- DESCRIPCION-->
                                        <div class="col bg">Descripcion: <?php echo $publicacion['descripcion'] ?></div>
                                        <!-- PRECIO -->
                                        <div class="col bg">$: <?php echo $publicacion['precio'] ?></div>

                                    </div>

                                </div>


                                <div class="col-3 bg" id="calificacion">

                                    <div class="row row-cols-1">

                                        <div id="imagen1">

                                            <div class="col bg">
                                                <!-- CALIFICACION -->
                                                <?php
                                                if (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "tutoria")) {

                                                    $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario = ? AND id_publicacion_usuario = ?");
                                                    $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                                    $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
                                                    $calificacionSQL->execute();
                                                    $sumaCalificacionUsuario = 0;
                                                    $contadorCalificacionUsuario = 0;
                                                    $resultadoCalificacionUsuario = 0;
                                                    foreach ($calificacionSQL as $calificacion) {
                                                        $sumaCalificacionUsuario += $calificacion['estrellas'];
                                                        $contadorCalificacionUsuario++;
                                                    }
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        $resultadoCalificacionUsuario = $sumaCalificacionUsuario / $contadorCalificacionUsuario;
                                                        // echo $resultadoCalificacionUsuario;
                                                    } else {
                                                        //  echo 'Sin Calificaciones';
                                                    }
                                                    ConexionBD::cerrarConexion();
                                                } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "asesoria")) {

                                                    $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_usuario WHERE id_usuario = ? AND id_publicacion_usuario = ?");
                                                    $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                                    $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
                                                    $calificacionSQL->execute();
                                                    $sumaCalificacionUsuario = 0;
                                                    $contadorCalificacionUsuario = 0;
                                                    $resultadoCalificacionUsuario = 0;
                                                    foreach ($calificacionSQL as $calificacion) {
                                                        $sumaCalificacionUsuario += $calificacion['estrellas'];
                                                        $contadorCalificacionUsuario++;
                                                    }
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        $resultadoCalificacionUsuario = $sumaCalificacionUsuario / $contadorCalificacionUsuario;
                                                        // echo $resultadoCalificacionUsuario;
                                                    } else {
                                                        //  echo 'Sin Calificaciones';
                                                    }
                                                    ConexionBD::cerrarConexion();
                                                } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "oportunidad")) {

                                                    $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_entidad WHERE id_entidad = ? AND id_publicacion_entidad = ?");
                                                    $calificacionSQL->bindParam(1, $publicacion['id_usuario']);
                                                    $calificacionSQL->bindParam(2, $publicacion['id_publicacion_usuario']);
                                                    $calificacionSQL->execute();
                                                    $sumaCalificacionUsuario = 0;
                                                    $contadorCalificacionUsuario = 0;
                                                    $resultadoCalificacionUsuario = 0;
                                                    foreach ($calificacionSQL as $calificacion) {
                                                        $sumaCalificacionUsuario += $calificacion['estrellas'];
                                                        $contadorCalificacionUsuario++;
                                                    }
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        $resultadoCalificacionUsuario = $sumaCalificacionUsuario / $contadorCalificacionUsuario;
                                                        // echo $resultadoCalificacionUsuario;
                                                    } else {
                                                        //  echo 'Sin Calificaciones';
                                                    }
                                                    ConexionBD::cerrarConexion();
                                                } elseif (!empty($publicacion['id_publicacion_entidad'])) {
                                                    $calificacionSQL = ConexionBD::abrirConexion()->prepare("SELECT estrellas FROM calificacion_publicacion_entidad WHERE id_entidad = ? AND id_publicacion_entidad = ?");
                                                    $calificacionSQL->bindParam(1, $publicacion['id_entidad']);
                                                    $calificacionSQL->bindParam(2, $publicacion['id_publicacion_entidad']);
                                                    $calificacionSQL->execute();
                                                    $sumaCalificacionEntidad = 0;
                                                    $contadorCalificacionEntidad = 0;
                                                    $resultadoCalificacionEntidad = 0;

                                                    foreach ($calificacionSQL as $calificacion) {
                                                        $sumaCalificacionEntidad += $calificacion['estrellas'];
                                                        $contadorCalificacionEntidad++;
                                                    }
                                                    if ($contadorCalificacionEntidad != 0) {
                                                        $resultadoCalificacionEntidad = $sumaCalificacionEntidad / $contadorCalificacionEntidad;
                                                        //   echo $resultadoCalificacionEntidad;
                                                    } else {
                                                        //   echo 'Sin Calificaciones';
                                                    }
                                                    ConexionBD::cerrarConexion();
                                                }
                                                ?>

                                                <img src="img/Imagenes/Sistema/gif-estrella.gif"  width="25%" height="25%" alt="Puntuacion.img" class="img-responsive">
                                                <?php
                                                if ($publicacion['categoria_publicacion'] == "tutoria") {
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        ?>
                                                        <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                                    <?php } else { ?>
                                                        <b> SIN CLASIFICACION</b>
                                                        <?php
                                                    }
                                                } elseif ($publicacion['categoria_publicacion'] == "asesoria") {
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        ?>
                                                        <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                                    <?php } else { ?>
                                                        <b> SIN CLASIFICACION</b>
                                                        <?php
                                                    }
                                                } elseif (!empty($publicacion['id_publicacion_usuario']) && ($publicacion['categoria_publicacion'] == "oportunidad")) {
                                                    if ($contadorCalificacionUsuario != 0) {
                                                        ?>
                                                        <b><?php echo $resultadoCalificacionUsuario; ?></b>
                                                    <?php } else { ?>
                                                        <b> SIN CLASIFICACION</b>
                                                        <?php
                                                    }
                                                } elseif ($publicacion['categoria_publicacion'] == "oportunidad") {
                                                    if ($contadorCalificacionEntidad != 0) {
                                                        ?>
                                                        <b><?php echo $resultadoCalificacionEntidad; ?></b>
                                                    <?php } else { ?>
                                                        <b> SIN CLASIFICACION</b>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div id="imagen1">
                                            <div class="col bg">
                                                <!-- SELLOS (tutoria, asesoria, oportunidad -->
                                                <?php if ($publicacion['categoria_publicacion'] == "tutoria") { ?>
                                                    <img src="img/Imagenes/Sistema/tutoria.png" alt="tutoria.img" width="50%" height="50%" class="img-responsive">
                                                <?php } elseif ($publicacion['categoria_publicacion'] == "asesoria") { ?>
                                                    <img src="img/Imagenes/Sistema/asesoria.png" alt="asesoria.img" width="50%" height="50%" class="img-responsive">
                                                <?php } else { ?>
                                                    <img src="img/Imagenes/Sistema/opportunity.png" alt="oportunidad.img" width="50%" height="50%" class="img-responsive">
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                        <hr>
                    <?php } ?>
                </div>   
                <!-- BARRA LATERAL -->
             <?php // include('MenuLateral.php'); ?> 
            </div>        

        </div>
    </body>
   
</html>
