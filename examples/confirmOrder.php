<?php


require_once('../vendor/autoload.php');
require_once('../examples/utils/Helpers.php');

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key


try {
    call_user_func('confirmOrders');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function confirmOrders()
{
    try {
        $fileName = basename(__FILE__);
        $withDate = true;
        writeLog('Creating Client', $fileName,$withDate);
        $orderApiClient = getClient();
        writeLog('Client Created', $fileName,$withDate);
        writeLog('Fetching Authorized Orders', $fileName,$withDate);
        $authorizedOrders = $orderApiClient->listOrders(array(
            'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED
        ));

        if (!isAuthorizedOrderCountAboveZero($authorizedOrders)) {
            $createdOrders = $orderApiClient->listOrders(array(
                'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CREATED));
            print("<pre>" . print_r("Number of Created Orders: ". count($createdOrders)."\n"."Number of Authorized Orders: " . count($authorizedOrders)."\n"."", true) . "</pre>");
            exit();
        }
        writeLog('Confirming all Authorized Orders', $fileName,$withDate);

        $confirmedOrders = getConfirmedOrdersRecursively($authorizedOrders,$orderApiClient);


        writeLog('Orders Confirmed', $fileName,$withDate);
        writeLog(jsonEncoded($confirmedOrders), $fileName,$withDate);
        /** WARNING: orders must be confirmed on your back office or you will get a empty object */
        print("<pre>" . print_r($confirmedOrders, true) . "</pre>");

    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}



/**
 * @param                                  $authorizedOrders
 *
 * @param \Pagantis\OrdersApiClient\Client $orderApiClient
 *
 * @return array
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function getConfirmedOrdersRecursively(
    $authorizedOrders,
    \Pagantis\OrdersApiClient\Client $orderApiClient
) {

    if (!$orderApiClient instanceof \Pagantis\OrdersApiClient\Client) {
        throw new \Pagantis\OrdersApiClient\Exception\ClientException('Client Instance Error');
    }
    $confirmedOrders = array();
    foreach ($authorizedOrders as $order) {
        $orderConfirmed = $orderApiClient->confirmOrder($order->getId());
        array_push($confirmedOrders, $orderConfirmed);
    }
    return $confirmedOrders;
}