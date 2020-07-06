<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$categoriaPublicacion = "tutoria";
$pregunta = $_POST['txtPregunta'];


                                  
                                   if (!empty($pregunta)) {
                                       //echo "<script>alert('ENTRO EN SI');</script>";
                                       $fechaCompleta = date_create(null, timezone_open("America/Santiago"));
                                       $fechaSubida = date_format($fechaCompleta, "d-m-Y H:i:s.u");
                                       //$fechaSubida = date_format($fechaCompleta, "d-m-Y");
                                       $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO Preguntas_publicacion (id_publicacion_usuario, id_usuario, fecha_pregunta_publicacion, pregunta_publicacion) VALUES (?, ?, ?, ?)");
                                       $consultaSQL->bindParam(1, $idPublicacion);
                                       $consultaSQL->bindParam(2, $_SESSION['inicioSesion']['id_usuario']);
                                       $consultaSQL->bindParam(3, $fechaSubida);
                                       $consultaSQL->bindParam(4, $pregunta);
                                       //echo '<script>alert ("Fecha '.$idPublicacion.' ");</script>';
                                       if ($consultaSQL->execute()) {

                                           echo "<script>alert('PREGUNTA REALIZADA');</script>";
                                           isset($pregunta);
                                           header('Location: ./DetallesPublicacion.php?id=' .$idPublicacion);
                                       } else {

                                           echo "<script>alert('ERROR AL CREAR LA PREGUNTA');</script>";
                                       }
                                       ConexionBD::cerrarConexion();
                                   }
                                   ?>
                        