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

const ORDER_ID = 'order_4159972708';

try {
    $method = getGetAction();
    call_user_func($method);
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}


/**
 * Create order in Pagantis
 *
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function createOrder()
{
    // There are  3 mandatory objects: User object, ShoppingCart object and Configuration object.

    //1. User Object
    $logsWithDate = true;
    $logsFileName = basename(__FILE__);

    writeLog('Creating User object', $logsFileName, $logsWithDate);

    $userAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();
    $userAddress->setZipCode('28031')
                ->setFullName('María Sanchez Escudero')
                ->setCountryCode('ES')
                ->setCity('Madrid')
                ->setAddress('Paseo de la Castellana, 95')
                ->setDni('59661738Z')
                ->setNationalId('59661738Z')
                ->setFixPhone('911231234')
                ->setMobilePhone('600123123');

    $orderBillingAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();
    $orderBillingAddress->setZipCode('28031')
                        ->setFullName('María Sanchez Escudero')
                        ->setCountryCode('ES')
                        ->setCity('Madrid')
                        ->setAddress('Paseo de la Castellana, 95')
                        ->setDni('59661738Z')
                        ->setNationalId('59661738Z')
                        ->setFixPhone('911231234')
                        ->setMobilePhone('600123123');
    writeLog('Adding the address of the user', $logsFileName, $logsWithDate);
    $orderShippingAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();

    $orderShippingAddress->setZipCode('08029')
                         ->setFullName('Alberto Escudero Sanchez')
                         ->setCountryCode('ES')
                         ->setCity('Barcelona')
                         ->setAddress('Avenida de la diagonal 525')
                         ->setDni('77695544A')
                         ->setNationalId('59661738Z')
                         ->setFixPhone('931232345')
                         ->setMobilePhone('600123124');
    writeLog('Adding the information of the user', $logsFileName, $logsWithDate);
    $orderUser = new \Pagantis\OrdersApiClient\Model\Order\User();
    $orderUser->setFullName('María Sanchez Escudero')
              ->setAddress($userAddress)
              ->setBillingAddress($orderBillingAddress)
              ->setShippingAddress($orderShippingAddress)
              ->setDateOfBirth('1985-12-30')
              ->setEmail('user@my-shop.com')
              ->setFixPhone('911231234')
              ->setMobilePhone('600123123')
              ->setDni('59661738Z')
              ->setNationalId('59661738Z');
    writeLog('User object created', $logsFileName, $logsWithDate);

    //2. ShoppingCart Object
    writeLog('Creating ShoppingCart object', $logsFileName, $logsWithDate);
    writeLog('Adding the purchases of the customer, if there are any.', $logsFileName, $logsWithDate);
    $orderHistory = new \Pagantis\OrdersApiClient\Model\Order\User\OrderHistory();
    $orderHistory->setAmount('2499')
                 ->setDate('2010-01-31');

    $orderUser->addOrderHistory($orderHistory);

    writeLog('Adding cart products. Minimum 1 required', $logsFileName, $logsWithDate);
    $product = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product();
    $product->setAmount('59999')
            ->setQuantity('1')
            ->setDescription('TV LG UltraPlasma');

    $details = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details();
    $details->setShippingCost('0');
    $details->addProduct($product);

    $orderShoppingCart = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart();
    $orderShoppingCart->setDetails($details)
                      ->setOrderReference(ORDER_ID)
                      ->setPromotedAmount(0) // This amount means that the merchant will assume the interests.
                      ->setTotalAmount('59999');
    writeLog('Created OrderShoppingCart object', $logsFileName, $logsWithDate);

    //3. Configuration Object
    writeLog('Creating Configuration object', $logsFileName, $logsWithDate);
    writeLog('Adding urls to redirect the user according each case', $logsFileName, $logsWithDate);

    $confirmUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=confirmOrder";
    $errorUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=cancelOrder";

    $orderConfigurationUrls = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Urls();
    $orderConfigurationUrls->setCancel($errorUrl)
                           ->setKo($errorUrl)
                           ->setAuthorizedNotificationCallback($confirmUrl)
                           ->setRejectedNotificationCallback($confirmUrl)
                           ->setOk($confirmUrl);
    writeLog('Adding channel info', $logsFileName, $logsWithDate);

    $orderChannel = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Channel();
    $orderChannel->setAssistedSale(false)
                 ->setType(\Pagantis\OrdersApiClient\Model\Order\Configuration\Channel::ONLINE);

    $orderConfiguration = new \Pagantis\OrdersApiClient\Model\Order\Configuration();
    $orderConfiguration->setChannel($orderChannel)
                       ->setUrls($orderConfigurationUrls);

    writeLog('Created Configuration object', $logsFileName, $logsWithDate);

    $order = new \Pagantis\OrdersApiClient\Model\Order();
    $order->setConfiguration($orderConfiguration)
          ->setShoppingCart($orderShoppingCart)
          ->setUser($orderUser);
    $orderClient = getOrderApiClient();
    $order = $orderClient->createOrder($order);
    writeLog(jsonEncoded($order), $logsFileName, $logsWithDate);

    writeLog('Creating Pagantis order', $logsFileName, $logsWithDate);
    writeLog('Processing order ' . $order->getId(), $logsFileName, $logsWithDate);

    if (!isOrderIdValid($order)) {
        throw new \Exception('Order not valid');
    }
    //If the order is created and valid then we have the redirection URL here:
    // $formUrl = $order->getActionUrls()->getForm();

    $_SESSION['order_id'] = $order->getId();

    writeLog(jsonEncoded($order->export()), basename(__FILE__), $logsWithDate);
    $formUrl = $order->getActionUrls()
                     ->getForm();
    // You can use our test credit cards to fill the Pagantis form
    writeLog("Redirecting to Pagantis form => $formUrl", $logsFileName, $logsWithDate);
    header('Location:' . $formUrl);
}

/**
 * Confirm order in Pagantis
 *
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws \Pagantis\OrdersApiClient\Exception\HttpException
 * @throws \Exception
 */
function confirmOrder()
{
    /* Once the user comes back to the OK url or there is a notification upon callback url, you will have to confirm
     * the reception of the order. If not it will expire  and will never be paid out.
     *
     * Add these parameters to your database when you create an order and map them together.
     * Alternatively search orders by internal order id. Both options are possible.
     */

    $logsFileName = basename(__FILE__);
    $logsWithDate = true;
    writeLog('Creating OrdersApiClient', $logsFileName, $logsWithDate);
    $orderClient = getOrderApiClient();

    $order = $orderClient->getOrder($_SESSION['order_id']);

    if ($order instanceof \Pagantis\OrdersApiClient\Model\Order && $order->getStatus() == \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED) {
        //If the order exists, and the status is authorized, means you can mark the order as paid.

        //DO WHATEVER YOU NEED TO DO TO MARK THE ORDER AS PAID IN YOUR OWN SYSTEM.
        writeLog('Confirming order', $logsFileName, $logsWithDate);
        $order = $orderClient->confirmOrder($order->getId());

        writeLog('Order confirmed', $logsFileName, $logsWithDate);
        writeLog(jsonEncoded($order->export()), $logsFileName, $logsWithDate);
        $_SESSION['order_status'] = array();
        array_push($_SESSION['order_status'], $order->getStatus());
        echo getSuccessOrderDetailCard($order->getId());
        echo getHomeButton();

        /* The order has been marked as paid and confirmed in Pagantis so you will send the product to your customer and
         * Pagantis will pay you in the next 24h.
         */
    } else {
        echo getFailureOrderDetailCard($_SESSION['order_id']);
        echo getHomeButton();
    }

    writeLog($message = "The order {$_SESSION['order_id']} can't be confirmed", $logsFileName, $logsWithDate);
}

/**
 * Action after redirect to cancelUrl
 */
function cancelOrder()
{
    $message = "The order {$_SESSION['order_id']} can't be created";
    writeLog($message, basename(__FILE__), true);
    echo $message;
}


/**
 * @return mixed|string
 */
function getGetAction()
{
    if (!isGetActionValid()) {
        return 'createOrder';
    };
    $method = json_decode(json_encode($_GET));
    writeLog("Method->action " . $method->action, basename(__FILE__), $logsWithDate = true);
    return $method->action;
}

/**
 * @param $order
 * @return bool
 */
function isOrderIdValid($order)
{
    if (!$order instanceof \Pagantis\OrdersApiClient\Model\Order) {
        return false;
    }
    return true;
}

/**
 * @return bool
 */
function isGetActionValid()
{
    if (!array_key_exists('action', $_GET)) {
        return false;
    }
    return true;
}

/**
 * @param $orderID
 * @return string
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function getSuccessOrderDetailCard($orderID)
{
    $orderApiClient = getOrderApiClient();
    $order = $orderApiClient->getOrder($orderID, $asJson = true);
    $orderObject = json_decode($order);
    $successCard = "<div class=\"card text-white bg-success mb-3   h-100 justify-content-center \" style=\"max-width: 30rem;\">
  <div class=\"card-header\">Order $orderObject->id Found</div>
  <div class=\"card-body\">
         <p class=\"card-text\"> Order status: $orderObject->status </p>
         <p class=\"card-text\"> Order created at:  $orderObject->created_at </p>
         <p class=\"card-text\"> Order confirmed at: $orderObject->confirmed_at </p>
  </div>
  </div>";

    return $successCard;
}
/**
 * @param $orderID
 * @return string
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function getFailureOrderDetailCard($orderID)
{

    $orderApiClient = getOrderApiClient();
    $order = $orderApiClient->getOrder($orderID, $asJson = true);
    $orderObject = json_decode($order);
    $failureCard = "<div class=\"alert alert-warning\" role=\"alert\"> Order : $orderObject->id couldn't be confirmed</div>";

    return $failureCard;
}

function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}


/**
 * @param      $message
 * @param bool $isError
 * @return string
 */
function showResultMessage($message, $isError = false)
{
    if ($isError) {
        $styledErrorMessage = "<div class=\"alert alert - warning\" role=\"alert\"> $message</div>";
        return $styledErrorMessage;
    }
    $styledNormalMessage = "<div class=\"alert alert - success\" role=\"alert\"> $message</div>";
    return $styledNormalMessage;
}


function getHomeButton()
{
    return "<div><button type=\"button\" class=\"btn btn-primary btn-lg\" onclick=\"redirectHome()\">Home</button></div>";
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
        <title> Get Order by ID</title>
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
                <h5>Create Order Example</h5>
            </div>
        </div>

        </div>
        <?php
        if ($_SESSION['order_status'] == \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED) {
            echo getSuccessOrderDetailCard($order);
        }
        ?>

    </div>
    <?php include('../views/footer.php') ?>

    </body>
    </html>
<?php
