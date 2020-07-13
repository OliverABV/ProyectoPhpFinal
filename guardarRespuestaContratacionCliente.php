<?php
session_start();
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: ./Login.php');
}
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$categoriaPublicacion = "tutoria";
$respuestaCliente = $_POST['textRespuesta'];

$confirmacionCliente = $_POST['Confirmacion'];

$idContratacion = $_GET['id'];
//$confirmacionDueño = 1;

$consultaSQL = ConexionBD::abrirConexion()->prepare("UPDATE public.contratacion_servicio
SET confirmacion_contratante = ?, mensaje_contratante = ?
WHERE id_contratacion = ?");

$fechaCompleta = date_create(null, timezone_open("America/Santiago"));
//$fechaSubida = date_format($fechaCompleta, "d-m-Y H-i-s");
$fechaSubida = date_format($fechaCompleta, "d-m-Y");

$consultaSQL->bindParam(1, $confirmacionCliente);
$consultaSQL->bindParam(2, $respuestaCliente);
$consultaSQL->bindParam(3, $idContratacion);
$consultaSQL->execute();
$listaPreguntas = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
ConexionBD::cerrarConexion();
header('Location: ./verContratacionCliente.php');
?>