<?php

require_once('../vendor/autoload.php');


/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key
const ORDER_ID = '5e78c725929d29591bd8922f';


try {
    writeLog('-------------------------------', $withDate = false);
    call_user_func('refundMethod');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function refundMethod()
{
    $asJson = true;
    $withDate = true;
    $refundTotalAmount = 10;
    try {
        writeLog('Creating Client', $withDate);
        $orderApiClient = getClient();
        writeLog('Client Created', $withDate);
        writeLog('Setting Refund', $withDate);
        $refund = new \Pagantis\OrdersApiClient\Model\Order\Refund();
        $refund
            ->setPromotedAmount(0)
            ->setTotalAmount($refundTotalAmount);
        writeLog('Refund Set', $withDate);
        $refundCreated = $orderApiClient->refundOrder(ORDER_ID, $refund);
        writeLog(jsonEncoded($refundCreated), $withDate);

        $refundedOrder = $orderApiClient->getOrder(ORDER_ID, $asJson);
        $refundsArray = jsonToArray($refundedOrder);

        echo jsonEncoded($refundsArray['refunds']);

    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}

/**
 * @param $message
 * @param $withDate
 *
 * @return false|int
 */
function writeLog(
    $message,
    $withDate
) {
    $dateFormat = '[D M j G:i:s o]';
    if ($withDate) {
        $date = getCurrentDate($dateFormat);
        return file_put_contents('logs/pagantis.old.log', "$date - 'REFUND ORDERS' - $message.\n",
            FILE_APPEND);
    }
    return file_put_contents('logs/pagantis.old.log', "$message.\n",
        FILE_APPEND);
}


/**
 * @param $dateFormat
 *
 * @return false|string
 */
function getCurrentDate($dateFormat)
{
    $currentDate = date($dateFormat);
    return $currentDate;
}

/**
 * @return \Pagantis\OrdersApiClient\Client
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 */
function getClient()
{
    if (PUBLIC_KEY == '' || PRIVATE_KEY == '') {
        throw new \Exception('You need set the public and private key');
    }
    $orderClient = new \Pagantis\OrdersApiClient\Client(PUBLIC_KEY, PRIVATE_KEY);
    return $orderClient;
}

/**
 * @param $jsonString
 *
 * @return mixed
 */
function jsonToArray($jsonString)
{
    $myArray = json_decode($jsonString, true);
    return $myArray;
}

/**
 * @param $object
 *
 * @return false|string
 */
function jsonEncoded($object)
{
    return json_encode($object,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}