<?php
include_once './PostgreSQL/ConexionBD.php';
$idPublicacion = $_GET['id'];
$idDueñoPublicacion = $_GET['dueño'];
$tituloPublicacion = $_GET['titulo'];
$valorHora = $_GET['valorHora'];
$valorHora = $_GET['valorHora'];
$cantidadHoras = $_GET['cantidadHoras'];
$idContratante = $_GET['idContratante'];

$consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO contratacion_servicio (id_contratante, id_publicacion, id_dueno, valor_hora, horas_contratadas) VALUES (?, ?, ?, ?, ?)");

$consultaSQL->bindParam(1, $idContratante);
$consultaSQL->bindParam(2, $idPublicacion);
$consultaSQL->bindParam(3, $idDueñoPublicacion);
$consultaSQL->bindParam(4, $valorHora);
$consultaSQL->bindParam(5, $cantidadHoras);



if ($consultaSQL->execute()) {

    echo "<script>alert('Pago Guardado');</script>";
} else {

    echo "<script>alert('error SQL en Pago Guardado');</script>";
}
ConexionBD::cerrarConexion();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <title>Webpay PHP</title>
        <link href="https://maxcdn.bootstrapcdm.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <div class="container">
    <div class="col-md-6 col-md-offset=3">
    <h3>Pago Exitoso! </h3>
    <table class="table table-striped table-hover">
    <thead><tr><th>Campo</th><th>Valor</th></tr></thead>
    <tbody>
    <tr>
    <td>Monto</td>
    <td id="amount"></td>
    </tr>
    <tr>
    <td>Codigo de autorizacion</td>
    <td id="authorizationCode"></td>
    </tr>
    <tr>
    <td>Codigo de respuesta</td>
    <td id="responseCode"></td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    <script>
        document.getElementById('amount').innerHTML = window.localStorage.getItem('amount');
        document.getElementById('authorizationCode').innerHTML = window.localStorage.getItem('authorizationCode');
        document.getElementById('responseCode').innerHTML = window.localStorage.getItem('responseCode');
    </script>
    <a href="http://localhost/ProyectoPhpFinal/MaquetaPublicaciones.php">Volver a las publicaciones</a>
    </body>
    </html>
