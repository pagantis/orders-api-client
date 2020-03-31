<?php
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
//Require the Client library using composer: composer require pagantis/orders-api-client


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
        <title> List Orders </title>
    </head>
<body>
<div class="container">
    <div class="fixed-top">

        <?php
        if (!areKeysSet()) {
            echo showKeysMissingErrorMessage();
        } ?>
    </div>
    <?php include('../views/navBar.php') ?>

    <div class="col-md-auto">
        <div class="row justify-content-center">
            <h5>List Orders Example</h5>
        </div>
    </div>
</div>
<?php include('../views/footer.php') ?>

</body>
</html>

<?php
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
//TODO FETCH ALL ORDERS BY STATUS AND RETURN A QUICK SUMMARY ORDERS : STATUS : COUNT($orders)
// only show some status and not all because some order statuses are not displayed to merchants
//TODO  orders by desc to improve ux
function listMethod()
{
    $queryString = array(
        'channel' => 'ONLINE',
        'pageSize' => 20,
        'page' => 1,
        'status' => \Pagantis\OrdersApiClient\Model\Order::STATUS_CONFIRMED
    );

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
            print("<legend>" . "Number of Confirmed Orders: ". count($confirmedOrders) . "</legend>");
            print("<pre>" . print_r($confirmedOrders, true) . "</pre>");
        }
        writeLog(count($confirmedOrders) . ' Confirmed orders found ', $logsFileName, $logsWithDate);
        print("<legend>" . "Number of Confirmed Orders: ". count($confirmedOrders) . "</legend>");
    } catch (\Exception $exception) {
        $exception->getMessage();
    }
}
