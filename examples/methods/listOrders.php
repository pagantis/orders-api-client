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


/**
 * PLEASE SET YOUR PUBLIC KEY AND PRIVATE KEY
 * IN examples/utils/Helpers.php
 */


try {
    call_user_func('listMethod');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

/**
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
//TODO FETCH ALL ORDERS BY STATUS AND RETURN A QUICK SUMMARY ORDERS : STATUS : COUNT($orders)
// only show some status and not all because some order statuses are not displayed to merchants
//TODO  orders by desc to improve ux
function listMethod()
{
    $queryString = array(
        'channel' => 'ONLINE',
        'pageSize' => 20,
        'page' => 1,
        'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED
    );

    try {
        $logsWithDate = true;
        $logsFileName = basename(__FILE__);
        writeLog('Creating Client', $logsFileName, $logsWithDate);
        $orderApiClient = getOrderApiClient();
        writeLog('Client Created', $logsFileName, $logsWithDate);
        writeLog('Fetching Orders', $logsFileName, $logsWithDate);
        $confirmedOrders = $orderApiClient->listOrders($queryString);

        if (isOrderCountAboveZero($confirmedOrders)) {
            writeLog('Orders Fetched', $logsFileName, $logsWithDate);
            writeLog(jsonEncoded($confirmedOrders), $logsFileName, $logsWithDate);
            print("<legend>" . "Number of Confirmed Orders: ". count($confirmedOrders) . "</legend>");
            print("<pre>" . print_r($confirmedOrders, true) . "</pre>");
        }
        writeLog(count($confirmedOrders) . ' Confirmed orders found ', $logsFileName, $logsWithDate);
        print("<legend>" . "Number of Confirmed Orders: ". count($confirmedOrders) . "</legend>");
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}
