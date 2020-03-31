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
    <nav>
        <div class="fixed-top">

            <?php
            if (!areKeysSet()) {
                echo showKeysMissingErrorMessage();
            } ?>
        </div>
        <?php include('../views/navBar.php') ?>

        <div class="col-md-auto">
            <div class="row justify-content-center">
                <h5>Confirm Order Example</h5>
            </div>
        </div>
    </nav>
    <orderCards>

            <?php
            try {
                $logsWithDate = true;
                $logsFileName = basename(__FILE__);
                $orderApiClient = getOrderApiClient();
                $confirmedOrders = getConfirmedOrders($orderApiClient, $asJson = true);
            } catch (\Exception $e) {
                $e->getMessage();
            }
            $confirmedOrdersArray = json_decode($confirmedOrders, true);
            ?>
            <div class="col-md-auto">
                <div class="row"></div>
                <div class="alert alert-success" role="alert">
                    <?php echo count($confirmedOrdersArray) . ' Confirmed orders found' ?>
                </div>
            </div>
        <div class="card-columns">
        <?php if ($confirmedOrdersArray >= 1) : ?>
            <?php foreach ($confirmedOrdersArray as $order) : ?>
            <div class="card bg-light mt-2 mb-2">
                <div class="card-body">
                    <p class="card-title"> Order ID: <?php echo $id = $order['id']; ?></p>
                    <p class="card-text"> Order Status : <?php echo $status = $order['status']; ?> </p>
                    <p class="card-text"> Shop Order
                        Reference: <?php echo $shopOrderID = $order['shopping_cart']['order_reference']; ?> </p>
                </div>
            </div>
            <?php endforeach; ?>
</div>

</orderCards>

        <?php else : ?>
            <?php
            try {
                $orderApiClient = getOrderApiClient();
                $createdOrders = getCreatedOrders($orderApiClient, $asJson = true);
                $invalidatedOrders = getInvalidatedOrders($orderApiClient, $asJson = true);
            } catch (\Exception $e) {
                $e->getMessage();
            }
            ?>

            <?php $createdOrdersArray = json_decode($createdOrders, true); ?>
            <?php $invalidatedOrdersArray = json_decode($invalidatedOrders, true); ?>
<alertBoxes>
    <div class="container-fluid align-content-center">

        <!--First row-->
        <div class="row align-content-center">
            <!--First column-->
            <div class="col-lg-auto mb-4">
                <div class="alert alert-info"
                     role="alert">  <?php echo count($invalidatedOrdersArray) . ' Invalidated Orders Found' ?></div>
            </div>
            <!--First column-->
            <!--Second column-->
            <div class="col-lg-auto mb-4">
                <div class="alert alert-info"
                     role="alert">  <?php echo count($confirmedOrdersArray) . ' Confirmed Orders Found' ?>
                </div>
            </div>
            <!--Second column-->
        </div>
        <!--First row-->

        <?php endif; ?>
    </div>
</alertBoxes>
<footer>
    <?php include('../views/footer.php') ?>
</footer>
</div>
</body>
</html>
