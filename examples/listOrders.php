<?php

require_once('../vendor/autoload.php');
require_once('../examples/utils/Helpers.php');

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key

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
function listMethod()
{
    $queryString = array(
        'channel' => 'ONLINE',
        'pageSize' => 2,
        'page' => 1,
        'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED
    );
    try {
        $withDate = true;
        $fileName = basename(__FILE__);
        writeLog('Creating Client', $fileName,$withDate);
        $orderApiClient = new \Pagantis\OrdersApiClient\Client(
            PUBLIC_KEY,
            PRIVATE_KEY
        );
        writeLog('Client Created', $fileName,$withDate);
        writeLog('Fetching Orders', $fileName,$withDate);
        /** WARNING: orders must be confirmed on your back office or you will get a empty object */
        $orders = $orderApiClient->listOrders($queryString);
        writeLog('Orders Fetched', $fileName,$withDate);

        writeLog(jsonEncoded($orders), $fileName,$withDate);
        print("<pre>" . print_r($orders, true) . "</pre>");

    } catch (\Exception $exception) {
        $exception->getMessage();
    }
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

