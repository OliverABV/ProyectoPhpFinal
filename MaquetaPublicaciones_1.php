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
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Pagina Principal</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap-grid.css">
        <link rel="stylesheet" href="css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Eedu WEb </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <!-- clase class="navbar navbar-expand-lg navbar-light bg-light sirve para centrar -->
                        <li class="navbar navbar-expand-lg navbar-light bg-light">
                            <!-- clase class="nav-link" sirve para que sea un link atributo disabled lo bloquea -->
                            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="nav-link" href="#">Sobre Nosotros</a>
                        </li>
                        <li class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="nav-link " href="#">Publicaciones</a>
                        </li>
                        <li class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="nav-link " href="#">Contactos</a>
                        </li>
                        <li class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="nav-link " href="#">Bienvenido </a>
                        </li>
                        <!-- clase class="nav-item" sirve para que la foto ocupe todo el casilla -->
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">
                                <!-- clase class="rounded-circle" permite redondear una imagen -->
                                <?php
                                if (!empty($_SESSION['inicioSesion']['nombre_usuario'])) {
                                    $avatar = $_SESSION['inicioSesion']['foto_usuario'];
                                    //echo $_SESSION['inicioSesion']['nombre_usuario'];
                                    echo' ';
                                    echo '<img class="rounded-circle" src="' . $avatar . '" width="50" height="50">';
                                } else {
                                    $avatar = $_SESSION['inicioSesion']['foto_entidad'];
                                    //echo $_SESSION['inicioSesion']['nombre_comercial_entidad'];
                                    echo ' ';
                                    echo '<img class="rounded-circle" src="' . $avatar . '" width="50" height="50">';
                                }
                                ?>  
                            </a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="#" method="POST" enctype="multipart/form-data">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </nav>
        </header>
    </body>
</html>
