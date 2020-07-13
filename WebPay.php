<?php

//require_once './vendor/autoload.php';
require_once ('./transbank-sdk-php-1.7.1/init.php');

use Transbank\Webpay\Webpay;
use Transbank\Webpay\Configuration;

$idPublicacion = $_GET['id'];
$idDueñoPublicacion = $_GET['dueño'];
$tituloPublicacion = $_GET['titulo'];
$valorHora = $_GET['valorHora'];
$cantidadHoras = $_POST['txtCantidadHoras'];
$idContratante = $_GET['idContratante'];

$total = $valorHora * $cantidadHoras;

$transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))->getNormalTransaction();

$amount = round($total);
//$sessionId = 'sessionId';
$sessionId = $tituloPublicacion;
//$buyOrder = strval(round(10000,9999999));
$buyOrder = $tituloPublicacion;
//$returnUrl = 'http://localhost/ProyectoPhpFinal/return.php';
$returnUrl = 'http://localhost/ProyectoPhpFinal/return.php'.'?id='.$idPublicacion.'&dueño='.$idDueñoPublicacion.'&titulo='.$tituloPublicacion.'&valorHora='.$valorHora.'&cantidadHoras='.$cantidadHoras.'&idContratante='.$idContratante;
//$finalUrl = 'http://localhost/ProyectoPhpFinal/final.php';
$finalUrl = 'http://localhost/ProyectoPhpFinal/final.php'.'?id='.$idPublicacion.'&dueño='.$idDueñoPublicacion.'&titulo='.$tituloPublicacion.'&valorHora='.$valorHora.'&cantidadHoras='.$cantidadHoras.'&idContratante='.$idContratante;

$initResult = $transaction->initTransaction(
    $amount, $sessionId, $buyOrder, $returnUrl, $finalUrl
);

$formAction = $initResult->url;
$tokenWs = $initResult->token;

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
    <h2>Pago con webpay</h2>
    <p><b>Valor</b>: <?php echo $amount ?></p>
    <p><b>Orden de compra</b>: <?php echo $buyOrder ?></p>


<form action="<?php echo $formAction ?>" method="POST" class="form-inline" role='form'>
    <input type="hidden" name="token_ws" value="<?php echo $tokenWs ?>">
    <button type="submit" class="btn btn-primary">Pagar</button>
</form>


    </div>
</div>
<a href="http://localhost/ProyectoPhpFinal/MaquetaPublicaciones.php">Volver a las publicaciones</a>
</body>
</html>