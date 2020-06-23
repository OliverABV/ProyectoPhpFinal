<?php

include_once '../PostgreSQL/ConexionBD.php';
$region = $_POST['id_region'];
$consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT id_ciudad, nombre_ciudad FROM ciudad WHERE id_region = ?");
$consultaSQL->bindParam(1, $region);
//$consultaSQL->setFetchMode(PDO::FETCH_ASSOC);
$consultaSQL->execute();

$ResultadoSQL = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);
$html = "<option value='0'>" . 'Seleccione una ciudad...' . "</option>";

foreach ($ResultadoSQL as $fila) {
    $html .= "<option value='" . $fila['id_ciudad'] . "'>" . $fila['nombre_ciudad'] . "</option>";
}
echo $html;
ConexionBD::cerrarConexion();
?>