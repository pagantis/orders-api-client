<?php
require_once('../vendor/autoload.php');

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = 'tk_45fe164c88c646a8a993d755'; //Set your public key
const PRIVATE_KEY = '4efe623438e14e3d'; //Set your public key
const ORDER_ID = 'order_4159972708';

try {
    session_start();
    $method = ($_GET['action']) ? ($_GET['action']) : 'ListOrders';
    call_user_func($method);
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

/**
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function listOrders()
{

    $pgClient = getClient();
    $order = $pgClient->getOrder(ORDER_ID);
    writeLog('Client Created', $withDate = true);
    writeLog(jsonEncoded($order), $withDate = true);
    writeLog(jsonEncoded($_SERVER), $withDate = true);

    if (isQueryURLValid()) {
        $queryParameters = parsedQueryString();
        $orders = $pgClient->listOrders($queryParameters);
        writeLog(jsonEncoded($orders), $withDate = true);

    }

}

function writeLog(
    $message,
    $withDate
) {
    $dateFormat = '[D M j G:i:s o]';
    if ($withDate) {
        $date = getCurrentDate($dateFormat);
        return file_put_contents('logs/pagantis.log', "$date - 'LIST ORDERS' - $message.\n",
            FILE_APPEND);
    }
    return file_put_contents('logs/pagantis.log', "$message.\n",
        FILE_APPEND);
}

function getCurrentDate($dateFormat)
{
    $currentDate = date($dateFormat);
    return $currentDate;
}

function jsonEncoded($object)
{
    return json_encode($object,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
}

function getClient()
{
    if (PUBLIC_KEY == '' || PRIVATE_KEY == '') {
        throw new \Exception('You need set the public and private key');
    }
    $orderClient = new \Pagantis\OrdersApiClient\Client(PUBLIC_KEY, PRIVATE_KEY);
    return $orderClient;
}

function getQueryString()
{
    $queryString = $_SERVER["QUERY_STRING"];
    return $queryString;
}

function isQueryURLValid()
{
    if ($_SERVER["QUERY_STRING"] === null) {
        return false;
    }
    return true;
}

function getQueryURL()
{
    $url = $_SERVER["QUERY_STRING"];
    $parsed_url = parse_url($url, PHP_URL_QUERY);
    return $parsed_url;
}

function parsedQueryString()
{
    parse_str($_SERVER["QUERY_STRING"], $query_array);
    $parsedString = $query_array;
    return $parsedString;
}

function listOrderQuery()
{

}

