<?php
//require_once './vendor/autoload.php';
require_once ('./transbank-sdk-php-1.7.1/init.php');


use Transbank\Webpay\Webpay;
use Transbank\Webpay\Configuration;

$idPublicacion = $_GET['id'];
$idDueñoPublicacion = $_GET['dueño'];
$tituloPublicacion = $_GET['titulo'];
$valorHora = $_GET['valorHora'];
$cantidadHoras = $_GET['cantidadHoras'];
$idContratante = $_GET['idContratante'];

$transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))->getNormalTransaction();

$tokenWs = filter_input(INPUT_POST, 'token_ws');
$result = $transaction->getTransactionResult($tokenWs);
$output = $result->detailOutput;
if($output->responseCode == 0){
    echo '<script>window.localStorage.clear();</script>';
    echo '<script>window.localStorage.setItem("authorizationCode",'. $output->authorizationCode .' );</script>';
    echo '<script>window.localStorage.setItem("amount",'. $output->amount .' );</script>';
    echo '<script>window.localStorage.setItem("responseCode",'. $output->responseCode .' );</script>';
}


?>
<?php if($output->responseCode == 0) { ?>
<form action="<?php echo $result->urlRedirection ?>" method="POST" id="return-form">
    <input type="hidden" name="token_ws" value="<?php echo $tokenWs ?>">
</form>

<script>
    document.getElementById('return-form').submit();
</script>
<?php } ?>