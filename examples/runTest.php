<?php


///Require the Client library using composer: composer require pagantis/orders-api-client
require_once '../vendor/autoload.php';


//
//try {
//    session_start();
//    $method = ($_GET['action']) ? ($_GET['action']) : 'createOrder';
//    call_user_func($method);
//} catch (\Exception $e) {
//    echo $e->getMessage();
//    exit;
//}

if (isset($_POST['submit'])) {
    try {
        process();
    } catch (\Exception $e) {
        $e->getMessage();
    }
}

function process()
{
    try {
        session_start();
        $method = $_POST('custom_method');
        $customAction =  getCustomAction($method);
        //echo dump($customAction);
        $test = new \Examples\OrdersApiClient\testOrder();
        $test->createOrder();
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit;
    }
}


/**
 * @param  string $action
 * @return mixed
 */
function getCustomAction($action)
{
    $method = $_GET[$action];
    return $method;
}


