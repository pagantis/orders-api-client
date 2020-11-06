<?php

/**
 * PLEASE FILL YOUR PUBLIC KEY AND PRIVATE KEY
 */
const PUBLIC_KEY = ''; //Set your public key
const PRIVATE_KEY = ''; //Set your private key
const ORDER_ID = '';

try {
    session_start();
    $method = (isset($_GET['action']) && $_GET['action']) ? ($_GET['action']) : 'createOrder';
    call_user_func($method);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

/**
 * Create order in Pagantis
 *
 * @throws Exception
 */
function createOrder()
{
    // There are 3 objects which are mandatory: User object, ShoppingCart object and Configuration object.
    //1. User Object
    writeLog('Creating User object');
    writeLog('Adding the address of the user');
    $userAddress = array();
    $userAddress['zip_code'] = '28008';
    $userAddress['full_name'] = 'María Sanchez Escudero';
    $userAddress['country_code'] = 'ES';
    $userAddress['city'] = 'Madrid';
    $userAddress['address'] = 'Paseo de la Castellana, 95';
    $userAddress['dni'] = '59661738Z';
    $userAddress['fix_phone'] = '911231234';
    $userAddress['mobile_phone'] = '600123123';
    $userAddress['national_id'] = '59661738Z';

    $orderBillingAddress = $userAddress;

    $orderShippingAddress =  array();
    $orderShippingAddress['zip_code'] = '08029';
    $orderShippingAddress['full_name'] = 'Alberto Escudero Sanchez';
    $orderShippingAddress['country_code'] = 'ES';
    $orderShippingAddress['city'] = 'Barcelona';
    $orderShippingAddress['address'] = 'Avenida de la diagonal 525';
    $orderShippingAddress['dni'] = '77695544A';
    $orderShippingAddress['fix_phone'] = '931232345';
    $orderShippingAddress['mobile_phone'] = '600123124';
    $orderShippingAddress['national_id'] = '77695544A';

    writeLog('Adding the purchases of the customer, if there are.');
    $orderHistory =  array (
        0 => array (
                'date' => '2020-01-31',
                'amount' => 989,
            ),
        1 => array (
                'date' => '2020-01-31',
                'amount' => 898,
            )
    );

    writeLog('Adding the information of the user');
    $orderUser = array();
    $orderUser['full_name'] = 'María Sanchez Escudero';
    $orderUser['email'] = 'user@my-shop.com';
    $orderUser['date_of_birth'] = '1985-12-30';
    $orderUser['address'] = '';
    $orderUser['dni'] = '59661738Z';
    $orderUser['national_id'] = '59661738Z';
    $orderUser['fix_phone'] = '911231234';
    $orderUser['mobile_phone'] = '600123123';
    $orderUser['address'] = $userAddress;
    $orderUser['billing_address'] = $orderBillingAddress;
    $orderUser['shipping_address'] = $orderShippingAddress;
    $orderUser['order_history'] = $orderHistory;
    writeLog('Created User object');

    //2. ShoppingCart Object
    writeLog('Creating ShoppingCart object');
    writeLog('Adding cart products. Minimum 1 required');

    $product = array();
    $product['amount'] = '59999';
    $product['quantity'] = 1;
    $product['description'] = 'TV LG UltraPlana';

    $details = array();
    $details['shipping_cost'] = 0;
    $details['products'][0] = $product;

    $orderShoppingCart = array();
    $orderShoppingCart['details'] = $details;
    $orderShoppingCart['order_reference'] = ORDER_ID;
    $orderShoppingCart['promoted_amount'] = 0; // This amount means that the merchant will asume the interests.
    $orderShoppingCart['total_amount'] = 59999;
    writeLog('Created OrderShoppingCart object');

    //3. Configuration Object
    writeLog('Creating Configuration object');
    writeLog('Adding urls to redirect the user according each case');
    $confirmUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=confirmOrder";
    $errorUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?action=cancelOrder";

    $orderConfigurationUrls = array();
    $orderConfigurationUrls['cancel'] = $errorUrl;
    $orderConfigurationUrls['ko'] = $errorUrl;
    $orderConfigurationUrls['authorized_notification_callback'] = $confirmUrl;
    $orderConfigurationUrls['rejected_notification_callback'] = $confirmUrl;
    $orderConfigurationUrls['ok'] = $confirmUrl;

    writeLog('Adding channel info');
    $orderChannel = array();
    $orderChannel['assisted_sale'] = false;
    $orderChannel['type'] = 'ONLINE';

    $orderConfiguration = array();
    $orderConfiguration['channel'] = $orderChannel;
    $orderConfiguration['urls'] = $orderConfigurationUrls;
    writeLog('Created Configuration object');

    $order = array();
    $order['configuration'] = $orderConfiguration;
    $order['shopping_cart'] = $orderShoppingCart;
    $order['user'] = $orderUser;

    writeLog('Preparing connection');
    if (PUBLIC_KEY=='' || PRIVATE_KEY == '') {
        throw new \Exception('You need set the public and private key');
    }

    writeLog('Creating Pagantis order');
    $params_json = json_encode($order);

    $cliente = curl_init();
    curl_setopt($cliente, CURLOPT_URL, "https://api.pagamastarde.com/v2/orders/");
    curl_setopt($cliente, CURLOPT_POST, 1);
    curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cliente, CURLOPT_POSTFIELDS, $params_json);
    curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json",
        "Authorization: Bearer ".PRIVATE_KEY
    ));

    $raw_response = curl_exec($cliente);
    $order = json_decode($raw_response);
    if (is_object($order)) {
        //If the order is correct and created then we have the redirection URL here:
        $url = $order->action_urls->form;
        $_SESSION['order_id'] = $order->id;
        writeLog(json_encode(
            $order,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        ));
    } else {
        throw new \Exception('Order not created');
    }

    // You can use our test credit cards to fill the Pagantis form
    writeLog("Redirecting to Pagantis form => $url");
    header('Location:'. $url);
}

/**
 * Confirm order in Pagantis
 *
 * @throws Exception
 */
function confirmOrder()
{
    /* Once the user comes back to the OK url or there is a notification upon callback url you will have to confirm
     * the reception of the order. If not it will expire and will never be paid.
     *
     * Add this parameters in your database when you create a order and map it to your own order. Or search orders by
     * your own order id. Both options are possible.
     */

    writeLog('Getting order information');

    writeLog('Preparing connection');
    if (PUBLIC_KEY=='' || PRIVATE_KEY == '') {
        throw new \Exception('You need set the public and private key');
    }

    $cliente = curl_init();
    curl_setopt($cliente, CURLOPT_URL, "https://api.pagamastarde.com/v2/orders/".$_SESSION['order_id']."/");
    curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json",
        "Authorization: Bearer ".PRIVATE_KEY
    ));

    $raw_response = curl_exec($cliente);
    $order = json_decode($raw_response);
    if (is_object($order) && $order->status == "AUTHORIZED") {
        //If the order exists, and the status is authorized, means you can mark the order as paid.

        //DO WHATEVER YOU NEED TO DO TO MARK THE ORDER AS PAID IN YOUR OWN SYSTEM.
        writeLog('Confirming order');

        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_URL, "https://api.pagamastarde.com/v2/orders/".$order->id."/confirm");
        curl_setopt($cliente, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".PRIVATE_KEY
        ));

        $raw_response = curl_exec($cliente);
        $order = json_decode($raw_response);
        writeLog("Order confirmed");
        writeLog(json_encode(
            $order,
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
