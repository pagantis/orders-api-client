<?php

//Require the Client library using composer: composer require pagantis/orders-api-client
require_once('../vendor/autoload.php');

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const MERCHANT_ID = '400124024'; //Set your public key
const SECRET_KEY = 'b9d0c0e5bfcab220b3ccea5d56ce02e336ccd5d7ad664cd662a33ae2fdaf282b4fe46e3a1b0a65077e278d179935d3e7e62063d32cd619dd4e8bd65bf7b76820'; //Set your private key
const ORDER_ID = 'order_4159972708';

try {
    session_start();
    $method = (isset($_GET['action'])) ? ($_GET['action']) : 'createOrder';
    call_user_func($method);
} catch (Exception $e) {
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
    //1. User Object
    writeLog('Creating Total Amount object');
    $totalAmount =  new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $totalAmount
        ->setAmount('40.99')
        ->setCurrency('GBP')
    ;

    //2. Consumer Object
    writeLog('Creating Consumer object');
    $consumer =  new \Pagantis\OrdersApiClient\Model\Order\Consumer();
    $consumer
        ->setGivenNames('Anthony Peter')
        ->setSurname('Jackson')
        ->setEmail('anthony@yourbrand.com')
        ->setPhoneNumber('+34699696969')
    ;

    //3. Billing address Object
    writeLog('Creating Billing address object');
    $billingAddress =  new \Pagantis\OrdersApiClient\Model\Order\Address();
    $billingAddress
        ->setName('Shara Mary Clepton')
        ->setLine1('Av Michigan 11')
        ->setLine2('P03, 8-4')
        ->setPostCode('28765')
        ->setSuburb('Leganés')
        ->setState('Madrid')
        ->setCountryCode('GB')
        ->setPhoneNumber('+34688776655')
    ;

    //4. Shipping address Object
    writeLog('Creating Shipping address object');
    $shippingAddress =  new \Pagantis\OrdersApiClient\Model\Order\Address();
    $shippingAddress
        ->setName('Ana Victoria Lauper')
        ->setLine1('Cl Portobello 34')
        ->setLine2('10-B')
        ->setPostCode('28888')
        ->setSuburb('Alcalá de Henares')
        ->setState('Madrid')
        ->setCountryCode('GB')
        ->setPhoneNumber('+34911919191')
    ;

    //5. Courier Object
    writeLog('Creating Courier object');
    $courier =  new \Pagantis\OrdersApiClient\Model\Order\Courier();
    $courier
        ->setShippedAt('')
        ->setName('MRW')
        ->setTracking('926e27eecdbc7a18858b3798ba99bddd')
        ->setPriority('STANDARD')
    ;

    //6. Items and Product Objects
    writeLog('Creating Items and Product Objects');
    $productA = new \Pagantis\OrdersApiClient\Model\Order\Items\Product();
    $priceA = new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $priceA
        ->setAmount('9.99')
        ->setCurrency('GBP')
    ;
    $productA
        ->setPrice($priceA)
        ->setName('Collection brilliants')
        ->setSku('sku77998')
        ->setQuantity(1)
    ;
    $productB = new \Pagantis\OrdersApiClient\Model\Order\Items\Product();
    $priceB = new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $priceB
        ->setAmount('5')
        ->setCurrency('GBP')
    ;
    $productB
        ->setPrice($priceA)
        ->setName('pendants')
        ->setSku('sku66765')
        ->setQuantity(6)
    ;

    //7. Discounts
    writeLog('Creating Discounts Objects');
    $discount = new \Pagantis\OrdersApiClient\Model\Order\Discounts\Discount();
    $discountPrice = new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $discountPrice
        ->setAmount('1.00')
        ->setCurrency('GBP')
    ;
    $discount
        ->setAmount($discountPrice)
        ->setDisplayName('1€ discount')
    ;

    //8. Merchant Object
    writeLog('Creating Merchant object');
    $merchant =  new \Pagantis\OrdersApiClient\Model\Order\Merchant();
    $merchant
        ->setRedirectConfirmUrl('https://example.com/checkout/confirm')
        ->setRedirectCancelUrl('https://example.com/checkout/cancel')
    ;

    //9. Tax Amount Object
    writeLog('Creating Tax Amount object');
    $taxAmount = new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $taxAmount
        ->setAmount('5.00')
        ->setCurrency('GBP')
    ;

    //10. Shipping Amount Object
    writeLog('Creating Shipping Amount object');
    $shippingAmount = new \Pagantis\OrdersApiClient\Model\Order\Amount();
    $shippingAmount
        ->setAmount('10.00')
        ->setCurrency('GBP')
    ;

    //11. Order Object
    $order = new \Pagantis\OrdersApiClient\Model\Order();
    $order
        ->setTotalAmount($totalAmount)
        ->setConsumer($consumer)
        ->setShippingAddress($shippingAddress)
        ->setBillingAddress($billingAddress)
        ->setCourier($courier)
        ->addItem($productA)
        ->addItem($productB)
        ->addDiscount($discount)
        ->setMerchant($merchant)
        ->setTaxAmount($taxAmount)
        ->setShippingAmount($shippingAmount)
        ->setMerchantReference(ORDER_ID)
        ->setDescription('Test order to check ClearPay integration')
    ;

    writeLog('Creating OrdersApiClient');
    if (MERCHANT_ID=='' || SECRET_KEY == '') {
        throw new \Exception('You need set the merchant_id and private key');
    }
    $orderClient = new \Pagantis\OrdersApiClient\Client(MERCHANT_ID, SECRET_KEY, 'https://api.eu-sandbox.afterpay.com/v1');

    writeLog('Creating Pagantis order');
    try {
        $response = $orderClient->createOrder($order);
    } catch (\Exception $exception) {
        writeLog($exception->getMessage());
    }
    if ($response instanceof \Pagantis\OrdersApiClient\Model\Order) {
        //If the order is correct and created then we have the redirection URL here:
        $token = $response->getToken();
        writeLog(json_encode(
            $order->export(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        )); writeLog(json_encode(
            response->export(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        ));
    } else {
        throw new \Exception('Order not created');
    }

    // You can use our test credit cards to fill the Pagantis form
    writeLog("Generating ClearPay form Url by token => $token");
    die;
    //header('Location:'. $url);
}

/**
 * Confirm order in Pagantis
 *
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws \Pagantis\OrdersApiClient\Exception\HttpException
 */
function confirmOrder()
{
    /* Once the user comes back to the OK url or there is a notification upon callback url you will have to confirm
     * the reception of the order. If not it will expire and will never be paid.
     *
     * Add this parameters in your database when you create a order and map it to your own order. Or search orders by
     * your own order id. Both options are possible.
     */

    writeLog('Creating OrdersApiClient');
    $orderClient = new \Pagantis\OrdersApiClient\Client(MERCHANT_ID, SECRET_KEY);

    $order = $orderClient->getOrder($_SESSION['order_id']);

    if ($order instanceof \Pagantis\OrdersApiClient\Model\Order &&
        $order->getStatus() == \Pagantis\OrdersApiClient\Model\Order::STATUS_AUTHORIZED) {
        //If the order exists, and the status is authorized, means you can mark the order as paid.

        //DO WHATEVER YOU NEED TO DO TO MARK THE ORDER AS PAID IN YOUR OWN SYSTEM.
        writeLog('Confirming order');
        $order = $orderClient->confirmOrder($order->getId());

        writeLog('Order confirmed');
        writeLog(json_encode(
            $order->export(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        ));
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
 * UTILS
 */

/**
 * Write log file
 *
 * @param $message
 */
function writeLog($message)
{
    file_put_contents('pagantis.log', "$message.\n", FILE_APPEND);
}
