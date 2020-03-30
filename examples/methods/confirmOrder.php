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
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;
    writeLog('Creating Client', $logsFileName, $logsWithDate);
    $orderApiClient = getOrderApiClient();
    writeLog('Client Created', $logsFileName, $logsWithDate);
    writeLog('Fetching Authorized Orders', $logsFileName, $logsWithDate);
    $createdOrders = getCreatedOrders($orderApiClient, $asJson = false);
    $previousConfirmedOrders = getConfirmedOrders($orderApiClient, $asJson = true);
    writeLog('$createdOrders :' . jsonEncoded($createdOrders), $logsFileName, $logsWithDate);
    $authorizedOrders = getAuthorizedOrders($orderApiClient, $asJson = true);
    $createdOrdersOrderObject = json_decode($createdOrders, true);
    print("<pre>" . print_r($authorizedOrders, true)."\n"."</pre>");

    writeLog('$createdOrdersOrderObject :' .jsonEncoded($createdOrdersOrderObject), $logsFileName, $logsWithDate);

    writeLog('Confirming all Authorized Orders', $logsFileName, $logsWithDate);

    $confirmedOrders = array();
    foreach ($authorizedOrders as $order) {
        $confirmedOrder = $orderApiClient->confirmOrder($order->getId());
        array_push($confirmedOrders, $confirmedOrder);
        return $confirmedOrders;
    }
    //$confirmedOrdersDifference = count($previousConfirmedOrders) - count($confirmedOrders);
    $dd = getConfirmedOrdersIDsArray($authorizedOrders);

    writeLog('Orders Confirmed', $logsFileName, $logsWithDate);
    writeLog('Confirmed Orders: ' . jsonEncoded($confirmedOrders), $logsFileName, $logsWithDate);
}

/**
 * @return array
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function pushOrderIdToArray()
{
    $confirmedOrders = array();
    $authorizedOrders = getAuthorizedOrders();
    foreach ($authorizedOrders as $order) {
        array_push($confirmedOrders, $order->getId());
    }
    return $confirmedOrders;
}


function showOrdersMessage($confirmedOrders)
{
    $message = "<div class=\"panel panel-default\">
  <div class=\"panel-body\">$confirmedOrders->id</div>
</div>";

    return $message;
}

/**
 * @param \Pagantis\OrdersApiClient\Client $orderApiClient
 * @param bool                             $asJson
 * @return array|bool|string
 * @throws Exception
 */
function getAuthorizedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $asJson = false)
{
    if ($asJson) {
        $authorizedOrdersAsJson = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED));
        return $authorizedOrdersAsJson;
    }
    $authorizedOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED));
    return $authorizedOrders;
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
    $createdOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CREATED), $asJson = true);
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
function getUnconfirmedOrders(\Pagantis\OrdersApiClient\Client $orderApiClient, $asJson = false)
{
    if ($asJson) {
        $unconfirmedOrdersAsJson = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_UNCONFIRMED), $asJson = true);
        return $unconfirmedOrdersAsJson;
    }
    $unconfirmedOrders = $orderApiClient->listOrders(array('status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_UNCONFIRMED));
    return $unconfirmedOrders;
}

/**
 * @param $authorizedOrders
 * @return array
 */
function getConfirmedOrdersIDsArray($authorizedOrders)
{
    $confirmedOrdersIDs = array();
    foreach ($authorizedOrders as $order) {
        array_push($confirmedOrdersIDs, $order['id']);
    }
    return $confirmedOrdersIDs;
}

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
    <title> Confirm Orders</title>
</head>
<body>
<div class="container">
    <div class="fixed-top">
        <?php
        if (!areKeysSet()) {
            echo showKeysMissingErrorMessage();
            echo "<div><button type=\"button\" class=\"btn btn-primary btn-lg\" onclick=\"redirectHome()\">Home</button></div>";
        }
        ?>
    </div>
    <div class="col-md-auto">
        <img src="../assets/pics/Pagantis_Logo_RGB.svg" alt="Pagantis logo">
        <div>
            <h5>Confirm Order Example</h5>
        </div>

    </div>

    <ul class="list-group">
        <?php
        $confirmedOrdersArr = getConfirmedOrders($orderApiClient = getOrderApiClient(), $asJson = false);
        $confirmedOrders = array_shift($confirmedOrdersArr);
        foreach ($confirmedOrders as $order) {
            $id = $order['id'];
            print("<pre>" . $id."</pre>");


            echo "<li class=\"list-group-item\"> $id </li>";
        }
        ?>
        <li class="list-group-item">First item</li>
        <li class="list-group-item">Second item</li>
        <li class="list-group-item">Third item</li>
    </ul>

</div>
</body>
</html>
