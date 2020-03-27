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


try {
    call_user_func('confirmOrders');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function confirmOrders()
{
    try {
        $logsFileName = basename(__FILE__);
        $logsWithDate = true;
        writeLog('Creating Client', $logsFileName, $logsWithDate);
        $orderApiClient = getOrderApiClient();
        writeLog('Client Created', $logsFileName, $logsWithDate);
        writeLog('Fetching Authorized Orders', $logsFileName, $logsWithDate);
        $authorizedOrders = $orderApiClient->listOrders(array(
            'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED
        ));
        if (!count($authorizedOrders) >= 1) {
            $createdOrders = $orderApiClient->listOrders(array(
                'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CREATED));

            $logMessage = "Number of Created Orders: ". count($createdOrders)."\n"."Number of Authorized Orders: " . count($authorizedOrders);
            print("<pre>" . print_r($logMessage, true) . "</pre>");
            writeLog($logMessage, $logsFileName, $logsWithDate);
            exit;
        }
        writeLog('Confirming all Authorized Orders', $logsFileName, $logsWithDate);

        if (!$orderApiClient instanceof \Pagantis\OrdersApiClient\Client) {
            throw new \Pagantis\OrdersApiClient\Exception\ClientException('Client Instance Error');
        }


        $confirmedOrders = array();
        foreach ($authorizedOrders as $order) {
            $orderConfirmed = $orderApiClient->confirmOrder($order->getId());
            array_push($confirmedOrders, $orderConfirmed);
        }

        writeLog('Orders Confirmed', $logsFileName, $logsWithDate);
        writeLog(jsonEncoded($confirmedOrders), $logsFileName, $logsWithDate);
        print("<pre>" . print_r($confirmedOrders, true) . "</pre>");
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}
