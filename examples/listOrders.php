<?php

require_once('../vendor/autoload.php');

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key

try {
    writeLog('-------------------------------', $withDate = false);
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
function listMethod()
{
    $asJson = true;
    $withDate = true;
    $queryString = array(
        'channel' => 'ONLINE',
        'pageSize' => 2,
        'page' => 1,
        'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED
    );
    try {
        writeLog('Creating Client', $withDate);
        $orderApiClient = new \Pagantis\OrdersApiClient\Client(
            PUBLIC_KEY,
            PRIVATE_KEY
        );
        writeLog('Client Created', $withDate);
        writeLog('Fetching Orders', $withDate);
        /** WARNING: orders must be confirmed on your back office or you will get a empty object */
        $orders = $orderApiClient->listOrders($queryString, $asJson);
        writeLog('Orders Fetched', $withDate);

        writeLog($orders, $withDate);
        echo $orders;

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
        return file_put_contents('logs/pagantis.old.log', "$date - 'LIST ORDERS' - $message.\n",
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
 * @param $object
 *
 * @return false|string
 */
function jsonEncoded($object)
{
    return json_encode($object,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
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

