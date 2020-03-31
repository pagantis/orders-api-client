<?php

//Require the Client library using composer: composer require pagantis/orders-api-client
require_once('../../vendor/autoload.php');

/**
 * Require the helper functions
 * ⚠⚠⚠
 * PLEASE SET YOUR PUBLIC KEY AND PRIVATE KEY
 * IN examples/utils/Helpers.php
 * ⚠⚠⚠
 */
require_once('../utils/Helpers.php');
error_reporting(E_ALL);

try {
    call_user_func('refundOrder');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function refundOrder()
{
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;

    $refundTotalAmount = $_POST['refundOrderAmount'];
    $refundOrderID = $_POST['refundOrderID'];

    try {
        writeLog('Creating Client', $logsFileName, $logsWithDate);
        $orderApiClient = getOrderApiClient();
        writeLog('Client Created', $logsFileName, $logsWithDate);
        writeLog('Setting Refund', $logsFileName, $logsWithDate);
        $refund = new \Pagantis\OrdersApiClient\Model\Order\Refund();
        $refund
            ->setPromotedAmount(0)
            ->setTotalAmount($refundTotalAmount);
        writeLog('Refund Set', $logsFileName, $logsWithDate);
        $orderApiClient->refundOrder($refundOrderID, $refund);
        writeLog('Refund Processed', $logsFileName, $logsWithDate);

        $refundedOrder = $orderApiClient->getOrder($refundOrderID, true);
        writeLog('Refunded Order Fetched for Verification', $logsFileName, $logsWithDate);

        $orderArray = json_decode($refundedOrder, true);

        writeLog(count($orderArray['refunds']) . ' refunds found ', $logsFileName, $logsWithDate);
        print("<legend>" . count($orderArray['refunds']) . ' refund(s) found '. "</legend>");

        print("<pre>" . jsonEncoded($orderArray['refunds']) . "</pre>");
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}

?>
<?php include('../views/refundOrderView.php') ?>

