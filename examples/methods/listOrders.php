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
error_reporting(E_ALL);
session_start();
try {
    call_user_func('listMethod');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

function listMethod()
{
    $queryString = array('channel' => 'ONLINE', 'pageSize' => 20, 'page' => 1, 'status' => $_POST['orderStatusInput']);

    try {
        $logsWithDate = true;
        $logsFileName = basename(__FILE__);
        writeLog('Creating Client', $logsFileName, $logsWithDate);
        $orderApiClient = getOrderApiClient();
        writeLog('Client Created', $logsFileName, $logsWithDate);
        writeLog('Fetching Orders', $logsFileName, $logsWithDate);
        $confirmedOrders = $orderApiClient->listOrders($queryString);

        if (count($confirmedOrders) >= 1) {
            writeLog('Orders Fetched', $logsFileName, $logsWithDate);
            writeLog(jsonEncoded($confirmedOrders), $logsFileName, $logsWithDate);
        }
        writeLog(count($confirmedOrders) . ' Confirmed orders found ', $logsFileName, $logsWithDate);
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}

?>
<?php include('../views/listOrdersView.php') ?>



