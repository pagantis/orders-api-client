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

if (!isset($_POST['getOrderID'])) {
    throw new \Exception('You need to input the Order ID');
}
try {
    $logsFileName = basename(__FILE__);
    $logsWithDate = true;

    $orderApiClient = getOrderApiClient();
    writeLog('Client Created', $logsFileName, $logsWithDate);

    $orderID = $_POST['getOrderID'];
    writeLog('Fetching Order with ID: ' . jsonEncoded($orderID), $logsFileName, $logsWithDate);

    $order = $orderApiClient->getOrder($orderID, $asJson = true);
    writeLog('Order with ID ' . jsonEncoded($orderID) . 'found', $logsFileName, $logsWithDate);
    if ($order == 'Not Found') {
        $message = "The order {$_POST['getOrderID']} hasn't been found";
        writeLog(jsonEncoded($_SESSION), $logsFileName, $logsWithDate);
        writeLog($message, $logsFileName, $logsWithDate);
        $_SESSION['order_not_found_message'] = $message;
        $_SESSION['order_not_found_id'] = $_POST['getOrderID'];
        header('Location:' . 'http://0.0.0.0:8000');
    }
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

?>

<?php include('../views/getOrderView.php') ?>

