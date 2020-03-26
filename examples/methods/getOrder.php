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


if (!isset($_POST['getOrderID'])) {
    throw new \Exception('You need to input the Order ID');
}
// TODO IMPROVE UX BY SHOWING RESULT IN INDEX IN A MORE UX FRIENDLY WAY
try {
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;

    $orderApiClient = getOrderApiClient();
    writeLog('Client Created', $logsFileName, $logsWithDate);

    $orderID = $_POST['getOrderID'];
    writeLog('Fetching Order with ID: '. jsonEncoded($orderID), $logsFileName, $logsWithDate);

    $order = $orderApiClient->getOrder($orderID);
    writeLog('Order with ID '. jsonEncoded($orderID) . 'found', $logsFileName, $logsWithDate);
    print("<legend>" . 'Order with ID: '. jsonEncoded($orderID). "has been found". "</legend>");
    print("<pre>" . print_r($order, true) . "</pre>");
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
