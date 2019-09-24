<?php
$result = $_POST;
if (!isset($result['back_url'])) {
    header("Location: result.php?s=error&ref=");
    exit();
}

require __DIR__ .  '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-090914-5c508e1b02a34fcce879a999574cf5c9-469485398');
$payment = MercadoPago\Payment::find_by_id($result["payment_id"]);

$_SESSION['details'] = json_encode(array(
    'payment_type' => $payment->payment_type_id,
    'payment_method_id' => $payment->payment_method_id,
    'amount' => $payment->transaction_amount,
    'reference' => $payment->external_reference,
    'payment_id' => $payment->id
));

$fp = fopen('orders.txt', 'a');
fwrite($fp, 'Compra: '.$result['external_reference'].PHP_EOL);
fwrite($fp, 'Fecha: '.date('Y-m-d h:i:s a', time())).PHP_EOL;
fwrite($fp, 'Merchant Order ID: '.$result['merchant_order_id'].PHP_EOL);
fwrite($fp, 'Payment ID: '.$result['payment_id'].PHP_EOL);
fwrite($fp, 'Payment Status: '.$result['payment_status'].PHP_EOL);
fwrite($fp, 'Payment Status Detail: '.$result['payment_status_detail'].PHP_EOL);
fwrite($fp, 'Processing Mode: '.$result['processing_mode'].PHP_EOL);
fwrite($fp, PHP_EOL);
fclose($fp);

header("Location: ".$result['back_url']);
exit();
?>
