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
    call_user_func('confirmAuthorizedOrders');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}


/**
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function confirmAuthorizedOrders()
{
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;
    writeLog('Creating Client', $logsFileName, $logsWithDate);

    $orderApiClient = getOrderApiClient();
    writeLog('Client Created', $logsFileName, $logsWithDate);

    writeLog('Fetching Authorized Orders', $logsFileName, $logsWithDate);

    $authorizedOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED));
    writeLog('Authorized Orders Fetched', $logsFileName, $logsWithDate);

    writeLog('Confirming Authorized Orders', $logsFileName, $logsWithDate);

    $confirmedOrders = getConfirmedAuthorizedOrders($orderApiClient, $authorizedOrders);
    writeLog('Authorized Orders Confirmed', $logsFileName, $logsWithDate);
    writeLog(jsonEncoded($confirmedOrders), $logsFileName, $logsWithDate);
}


/**
 * @param $authorizedOrders
 * @return array
 * @throws Exception
 */
function getConfirmedAuthorizedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $authorizedOrders)
{
    $confirmedOrders = array();
    foreach ($authorizedOrders as $order) {
        $confirmedOrder = $orderApiClient->confirmOrder($order->getId());
        array_push($confirmedOrders, $confirmedOrder);
    }
    return $confirmedOrders;
}

/**
 * @param \Pagantis\OrdersApiClient\Client $orderApiClient
 * @param bool                             $asJson
 * @return array|bool|string
 * @throws Exception
 */
function getCreatedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $asJson = false)
{
    if ($asJson) {
        $createdOrdersAsJson = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CREATED), $asJson = true);
        return $createdOrdersAsJson;
    }
    $createdOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CREATED));
    return $createdOrders;
}

/**
 * @param \Pagantis\OrdersApiClient\Client $orderApiClient
 * @param bool                             $asJson
 * @return array|bool|string
 * @throws Exception
 */
function getConfirmedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $asJson = false)
{
    if ($asJson) {
        $confirmedOrdersAsJson = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED), $asJson = true);
        return $confirmedOrdersAsJson;
    }
    $confirmedOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED));
    return $confirmedOrders;
}

/**
 * @param \Pagantis\OrdersApiClient\Client $orderApiClient
 * @param bool                             $asJson
 * @return array|bool|string
 * @throws Exception
 */
function getInvalidatedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $asJson = false)
{
    if ($asJson) {
        $unconfirmedOrdersAsJson = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_INVALIDATED), $asJson = true);
        return $unconfirmedOrdersAsJson;
    }
    $unconfirmedOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_INVALIDATED));
    return $unconfirmedOrders;
}


?>

<?php include('../views/confirmOrderView.php'); ?>
