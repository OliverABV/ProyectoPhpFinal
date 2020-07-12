<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$categoriaPublicacion = "tutoria";
$pregunta = $_POST['txtPregunta'];

$idPregunta = $_GET['id'];


$consultaSQL = ConexionBD::abrirConexion()->prepare("UPDATE public.preguntas_publicacion
SET fecha_respuesta_publicacion= ?, respuesta_publicacion= ?
WHERE id_pregunta_publicacion = ?;");

$fechaCompleta = date_create(null, timezone_open("America/Santiago"));
//$fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
$fechaSubida = date_format($fechaCompleta, "d-m-Y");

$consultaSQL->bindParam(1, $fechaSubida);
$consultaSQL->bindParam(2, $_POST['textRespuesta']);
$consultaSQL->bindParam(3, $idPregunta);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();
header('Location: ./ResponderPreguntas.php');
?>