<?php
header("HTTP/1.1 200 OK");

require __DIR__ .  '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-090914-5c508e1b02a34fcce879a999574cf5c9-469485398');

$payment = FALSE;
switch($_POST["type"]) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($_POST["id"]);
        break;
}

if ($payment) {
    $fp = fopen('payments.txt', 'a');
    fwrite($fp, "Payment ID: ".$_POST['id'].PHP_EOL);
    fwrite($fp, "Compra: ".$payment->external_reference.PHP_EOL);
    fwrite($fp, "Type: ".$payment->operation_type.PHP_EOL);
    fwrite($fp, "Status: ".$payment->status.PHP_EOL);
    fwrite($fp, "Status Detail: ".$payment->status_detail.PHP_EOL);
    fwrite($fp, "Date Created: ".$payment->date_created.PHP_EOL);
    fwrite($fp, "Date Approved: ".$payment->date_approved.PHP_EOL);
    fwrite($fp, "Amount: ".$payment->transaction_amount.PHP_EOL);
    fwrite($fp, "Customer: ".$payment->payer->first_name.' '.$payment->payer->last_name.' <'.$payment->payer->email.'>'.PHP_EOL);
    fwrite($fp, "Payment Type: ".$payment->payment_type_id.PHP_EOL);
    fwrite($fp, "Payment Method: ".$payment->payment_method_id.PHP_EOL);
    fwrite($fp, PHP_EOL);
    fclose($fp);
}
?>
