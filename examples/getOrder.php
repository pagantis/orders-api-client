<?php

require_once('../vendor/autoload.php');
require_once('utils/Helpers.php');

use Pagantis\OrdersApiClient\Client;

const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key

if (!isset($_POST['getOrderID'])){
    throw new \Exception('You need to input the Order ID');
}
try {

    $orderID = $_POST['getOrderID'];
    $orderApiClient = getClient();
    $order = $orderApiClient->getOrder($orderID);
    $fileName = basename(__FILE__);
    writeLog("Order ID: ".$order->getId(),$fileName, true);
    print("<pre>" . print_r($order, true) . "</pre>");

} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
