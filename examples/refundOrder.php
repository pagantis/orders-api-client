<?php

require_once('../vendor/autoload.php');
require_once('../examples/utils/Helpers.php');


/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key


try {
    call_user_func('refundOrder');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function refundOrder()
{
    $asJson = true;
    $withDate = true;
    $fileName = basename(__FILE__);
    $refundTotalAmount = $_POST['refundOrderAmount'];
    $refundOrderID = $_POST['refundOrderID'];
    try {
        writeLog('Creating Client', $fileName,$withDate);
        $orderApiClient = getClient();
        writeLog('Client Created', $fileName,$withDate);
        writeLog('Setting Refund', $fileName,$withDate);
        $refund = new \Pagantis\OrdersApiClient\Model\Order\Refund();
        $refund
            ->setPromotedAmount(0)
            ->setTotalAmount($refundTotalAmount);
        writeLog('Refund Set', $fileName,$withDate);
        $refundCreated = $orderApiClient->refundOrder($refundOrderID, $refund);
        writeLog(jsonEncoded($refundCreated), $fileName,$withDate);

        $refundedOrder = $orderApiClient->getOrder($refundOrderID, $asJson);
        $refundsArray = jsonToArray($refundedOrder);

        echo jsonEncoded($refundsArray['refunds']);
        print("<pre>" . print_r($refundsArray['refunds'], true) . "</pre>");

    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}




