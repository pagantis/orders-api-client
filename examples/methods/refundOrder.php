<?php
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
//Require the Client library using composer: composer require pagantis/orders-api-client
?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../assets/pics/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../assets/css/styles.css" type="text/css">
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/jquery-slim.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <title> Refund Order</title>
    </head>
    <body>
    <div class="container">
        <div class="col-md-auto">
            <img src="../assets/pics/Pagantis_Logo_RGB.svg" alt="Pagantis logo">
            <div>
                <h5>Refund Order Example</h5>
            </div>
            <div class="fixed-top">
                <?php
                if (!areKeysSet()) {
                    echo showKeysMissingErrorMessage();
                } ?>
            </div>
            <div class="">
                <button type="button" class="btn btn-primary btn-lg" onclick="redirectHome()">Home</button>
            </div>
        </div>
    </div>
    </body>
    </html>

<?php

try {
    call_user_func('refundOrder');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

// ADD WAY TO GO BACK TO INDEX OR SHOW RESULT OF REFUND IN INDEX
// IF TIME ALLOWS ONLY ALLOW TO REFUND ORDER IF LOGIC ALLOWS REFUND TO BE PROCESSED
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

        $orderArray = jsonToArray($refundedOrder);

        writeLog(count($orderArray['refunds']) . ' refunds found ', $logsFileName, $logsWithDate);
        print("<legend>" . count($orderArray['refunds']) . ' refund(s) found '. "</legend>");

        print("<pre>" . jsonEncoded($orderArray['refunds']) . "</pre>");
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}
