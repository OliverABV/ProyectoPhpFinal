<?php

include_once '../PostgreSQL/ConexionBD.php';
$ciudad = $_POST['id_ciudad'];
echo $ciudad;
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_comuna, nombre_comuna FROM comuna WHERE id_ciudad = ?");
$consultaSQL->bindParam(1, $ciudad);
//$consultaSQL->setFetchMode(PDO::FETCH_ASSOC);
$consultaSQL->execute();

$ResultadoSQL = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
$html = "<option value='0'>" . 'Seleccione una comuna...' . "</option>";

foreach ($ResultadoSQL as $fila) {
    $html = "<option value='" . $fila['id_comuna'] . "'>" . $fila['nombre_comuna'] . "</option>";
}
echo $html;
ConexionBD::cerrarConexion();
?>