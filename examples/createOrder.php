<?php

//Require the Client library using composer: composer require pagantis/orders-api-client
require_once('../vendor/autoload.php');
require_once('../examples/utils/Helpers.php');
/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your public key
const ORDER_ID = 'order_4159972708';


try {
    session_start();
    $withDate = true;
    $fileName = basename(__FILE__);
    $method = get_GetMethod();
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
 * @throws \Pagantis\OrdersApiClient\Exception\HttpException
 * @throws \Exception
 */
function createOrder()
{
    // There are 3 objects which are mandatory: User object, ShoppingCart object and Configuration object.
    //1. User Object
    $withDate = true;
    $fileName = basename(__FILE__);
    writeLog('Creating User object', $fileName, $withDate);
    $userAddress = setAddress();
    $orderBillingAddress = setAddress();
    writeLog('Adding the address of the user', $fileName, $withDate);
    $orderShippingAddress = setShippingAddress();

    writeLog('Adding the information of the user', $fileName, $withDate);
    $orderUser = setOrder($userAddress, $orderBillingAddress,
        $orderShippingAddress);
    writeLog('Created User object', $fileName, $withDate);

    //2. ShoppingCart Object
    writeLog('Creating ShoppingCart object', $fileName, $withDate);
    writeLog('Adding the purchases of the customer, if there are.', $fileName, $withDate);
    $orderHistory = setOrderHistory();

    writeLog('Adding cart products. Minimum 1 required', $fileName, $withDate);
    $product = setProduct();

    $details = setProductDetails($product);

    $orderShoppingCart = setShoppingCart($details, ORDER_ID);
    writeLog('Created OrderShoppingCart object', $fileName, $withDate);

    //3. Configuration Object
    writeLog('Creating Configuration object', $fileName, $withDate);
    writeLog('Adding urls to redirect the user according each case', $fileName, $withDate);

    $orderConfigurationUrls = setConfigurationUrls();

    writeLog('Adding channel info', $fileName, $withDate);
    $orderChannel = setOrderChannel();

    $orderConfiguration = setOrderConfiguration($orderChannel,
        $orderConfigurationUrls);
    writeLog('Created Configuration object', $fileName, $withDate);

    $order = sendOrder($orderConfiguration, $orderShoppingCart,
        $orderUser);

    writeLog('Creating OrdersApiClient', $fileName, $withDate);
    $orderClient = getClient();

    writeLog('Creating Pagantis order', $fileName, $withDate);
    $order = $orderClient->createOrder($order);

    writeLog("Pagantis Order Created ID: "
        . jsonEncoded($_SESSION['order_id']), $fileName, $withDate);

    processOrder($order);
    $url = getFormURL($order);
    writeLog("Session " . $_SESSION['order_id'], $fileName, $withDate);
    // You can use our test credit cards to fill the Pagantis form
    writeLog("Redirecting to Pagantis form => $url", $fileName, $withDate);
    header('Location:' . $url);
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
    /* Once the user comes back to the OK url or there is a notification upon callback url you will have to confirm
     * the reception of the order. If not it will expire and will never be paid.
     *
     * Add this parameters in your database when you create a order and map it to your own order. Or search orders by
     * your own order id. Both options are possible.
     */

    $fileName = basename(__FILE__);
    writeLog('Creating OrdersApiClient', $fileName, true);
    $orderClient = new \Pagantis\OrdersApiClient\Client(PUBLIC_KEY, PRIVATE_KEY);

    $order = $orderClient->getOrder($_SESSION['order_id']);

    if ($order instanceof \Pagantis\OrdersApiClient\Model\Order
        && $order->getStatus() == \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED
    ) {
        //If the order exists, and the status is authorized, means you can mark the order as paid.

        //DO WHATEVER YOU NEED TO DO TO MARK THE ORDER AS PAID IN YOUR OWN SYSTEM.
        writeLog('Confirming order', $fileName, true);
        $order = $orderClient->confirmOrder($order->getId());

        writeLog('Order confirmed', $fileName, true);
        writeLog(json_encode(
            $order->export(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        ), $fileName, true);
        $message = "The order {$_SESSION['order_id']} has been confirmed successfully";
    } else {
        $message = "The order {$_SESSION['order_id']} can't be confirmed";
    }

    /* The order has been marked as paid and confirmed in Pagantis so you will send the product to your customer and
     * Pagantis will pay you in the next 24h.
     */

    echo $message;
    exit;
}

/**
 * Action after redirect to cancelUrl
 */
function cancelOrder()
{
    $message = "The order {$_SESSION['order_id']} can't be created";

    echo $message;
    exit;
}

/**
 * Internal Functions
 */
/**
 * @return \Pagantis\OrdersApiClient\Model\Order\User\Address
 */
function setAddress()
{
    $userAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();

    $userAddress
        ->setZipCode('28031')
        ->setFullName('María Sanchez Escudero')
        ->setCountryCode('ES')
        ->setCity('Madrid')
        ->setAddress('Paseo de la Castellana, 95')
        ->setDni('59661738Z')
        ->setNationalId('59661738Z')
        ->setFixPhone('911231234')
        ->setMobilePhone('600123123');
    return $userAddress;
}

/**
 * @return \Pagantis\OrdersApiClient\Model\Order\User\Address
 */
function setShippingAddress()
{
    $orderShippingAddress = new \Pagantis\OrdersApiClient\Model\Order\User\Address();

    $orderShippingAddress
        ->setZipCode('08029')
        ->setFullName('Alberto Escudero Sanchez')
        ->setCountryCode('ES')
        ->setCity('Barcelona')
        ->setAddress('Avenida de la diagonal 525')
        ->setDni('77695544A')
        ->setNationalId('59661738Z')
        ->setFixPhone('931232345')
        ->setMobilePhone('600123124');
    return $orderShippingAddress;
}

/**
 * @param $userAddress
 * @param $orderBillingAddress
 * @param $orderShippingAddress
 *
 * @return \Pagantis\OrdersApiClient\Model\Order\User
 */
function setOrder(
    $userAddress,
    $orderBillingAddress,
    $orderShippingAddress
) {
    $orderUser = new \Pagantis\OrdersApiClient\Model\Order\User();
    $orderUser
        ->setFullName('María Sanchez Escudero')
        ->setAddress($userAddress)
        ->setBillingAddress($orderBillingAddress)
        ->setShippingAddress($orderShippingAddress)
        ->setDateOfBirth('1985-12-30')
        ->setEmail('user@my-shop.com')
        ->setFixPhone('911231234')
        ->setMobilePhone('600123123')
        ->setDni('59661738Z')
        ->setNationalId('59661738Z');
    return $orderUser;
}

/**
 * @return \Pagantis\OrdersApiClient\Model\Order\User\OrderHistory
 */
function setOrderHistory()
{
    $orderHistory = new \Pagantis\OrdersApiClient\Model\Order\User\OrderHistory();
    $orderUser = new \Pagantis\OrdersApiClient\Model\Order\User();
    $orderHistory
        ->setAmount('2499')
        ->setDate('2010-01-31');
    $orderUser->addOrderHistory($orderHistory);
    return $orderHistory;
}

/**
 * @return \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product
 */
function setProduct()
{
    $product = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product();
    $product
        ->setAmount('59999')
        ->setQuantity('1')
        ->setDescription('TV LG UltraPlasma');
    return $product;
}

/**
 * @param \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product $product
 *
 * @return \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details
 */
function setProductDetails(
    \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details\Product $product
) {
    $details = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart\Details();
    $details->setShippingCost('0');
    $details->addProduct($product);
    return $details;
}

/**
 * @param $details
 * @param $orderID
 *
 * @return \Pagantis\OrdersApiClient\Model\Order\ShoppingCart
 */
function setShoppingCart($details, $orderID)
{
    $orderShoppingCart = new \Pagantis\OrdersApiClient\Model\Order\ShoppingCart();

    $orderShoppingCart
        ->setDetails($details)
        ->setOrderReference($orderID)
        ->setPromotedAmount(0) // This amount means that the merchant will assume the interests.
        ->setTotalAmount('59999');
    return $orderShoppingCart;
}

/**
 * @return \Pagantis\OrdersApiClient\Model\Order\Configuration\Urls
 */
function setConfigurationUrls()
{
    $confirmUrl
        = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=confirmOrder";
    $errorUrl
        = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=cancelOrder";

    $orderConfigurationUrls = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Urls();
    $orderConfigurationUrls
        ->setCancel($errorUrl)
        ->setKo($errorUrl)
        ->setAuthorizedNotificationCallback($confirmUrl)
        ->setRejectedNotificationCallback($confirmUrl)
        ->setOk($confirmUrl);
    return $orderConfigurationUrls;
}

/**
 * @return \Pagantis\OrdersApiClient\Model\Order\Configuration\Channel
 */
function setOrderChannel()
{
    $orderChannel = new \Pagantis\OrdersApiClient\Model\Order\Configuration\Channel();
    $orderChannel
        ->setAssistedSale(false)
        ->setType(\Pagantis\OrdersApiClient\Model\Order\Configuration\Channel::ONLINE);
    return $orderChannel;
}

/**
 * @param $orderChannel
 * @param $orderConfigurationUrls
 *
 * @return \Pagantis\OrdersApiClient\Model\Order\Configuration
 */
function setOrderConfiguration(
    $orderChannel,
    $orderConfigurationUrls
) {
    $orderConfiguration
        = $orderConfiguration = new \Pagantis\OrdersApiClient\Model\Order\Configuration();
    $orderConfiguration
        ->setChannel($orderChannel)
        ->setUrls($orderConfigurationUrls);
    return $orderConfiguration;
}

/**
 * @param $orderConfiguration
 * @param $orderShoppingCart
 * @param $orderUser
 *
 * @return \Pagantis\OrdersApiClient\Model\Order
 */
function sendOrder(
    $orderConfiguration,
    $orderShoppingCart,
    $orderUser
) {
    $order = new \Pagantis\OrdersApiClient\Model\Order();
    $order
        ->setConfiguration($orderConfiguration)
        ->setShoppingCart($orderShoppingCart)
        ->setUser($orderUser);
    return $order;
}

/**
 * @param $method
 *
 * @return bool
 */

function isFunctionNameValid($method)
{
    return function_exists($method);
}

/**
 * @param $order
 *
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
 * @return \Pagantis\OrdersApiClient\Client
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function getClient()
{
    if (PUBLIC_KEY == '' || PRIVATE_KEY == '') {
        throw new \Exception('You need set the public and private key');
    }
    $orderClient = new \Pagantis\OrdersApiClient\Client(PUBLIC_KEY, PRIVATE_KEY);
    return $orderClient;
}

/**
 * @param \Pagantis\OrdersApiClient\Model\Order $order
 *
 * @throws Exception
 */
function processOrder(\Pagantis\OrdersApiClient\Model\Order $order)
{
    if (!isOrderIdValid($order)) {
        throw new \Exception('Order not valid');
    }
    //If the order is correct and created then we have the redirection URL here:
    // $url = $order->getActionUrls()->getForm();
    $_SESSION['order_id'] = $order->getId();
    writeLog(jsonEncoded($order->export()), basename(__FILE__), $withDate = true);
}

/**
 * @param \Pagantis\OrdersApiClient\Model\Order $order
 *
 * @return string
 */
function getFormURL(\Pagantis\OrdersApiClient\Model\Order $order)
{
    $url = $order->getActionUrls()->getForm();
    return $url;
}

/**
 * @return bool
 */
function isGetActionValid()
{

    if (!$_GET['action']) {
        return false;
    }
    return true;
}

/**
 * @return mixed|string
 */
function get_GetMethod()
{
    if (!isGetActionValid()) {
       return 'createOrder';

    };
    $method = json_decode(json_encode($_GET));
    return $method->action;
}