<?php


//Require the Client library using composer: composer require pagantis/orders-api-client
use Examples\OrdersApiClient\testOrder;
use Examples\OrdersApiClient\utils\Helpers;
use Examples\OrdersApiClient\utils\Log;
use Pagantis\OrdersApiClient\Exception\ClientException;

require_once '../vendor/autoload.php';
require 'testOrder.php';

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
        Log::write('Started Session - ' . $_POST['custom_method'],
            $withDate = true);
        $method = Helpers::getValueOfKey($_POST, 'custom_method');
        // https://carlalexander.ca/php-reflection-api-fundamentals/
        try {
            $testOrder = new testOrder();
            $reflection_object = new ReflectionObject($testOrder);
            $method = $reflection_object->getMethod($method);
            echo $method->invoke($testOrder);
            Log::write('Reflection Method Invoked ', $withDate = true);

        } catch (ReflectionException $e) {

            echo "Forbidden!";
        }

    } catch (\Exception $e) {
        $e->getMessage();
    }
    function getReflectionMethod(TestOrder $testOrder)
    {
        if (!$testOrder instanceof TestOrder) {
            throw new ClientException('Please Check TestOrder Object');
        }
        try {
            $reflection_object = new ReflectionObject($testOrder);
            return $reflection_object;
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    function reflectMethod($className, $methodName)
    {
        try {
            $method = new ReflectionMethod($className, $methodName);
            return $method;
        } catch (ReflectionException $e) {
            $e->getCode();
            $e->getFile();
            $e->getTrace();
        }

    }

    function isMethodNameValid($className, $methodName)
    {
        try {
            $reflector = new ReflectionClass($className);
            if ($reflector->hasMethod($methodName)) {
                return true;
            }
            return false;
        } catch (ReflectionException $e) {
            $e->getMessage();
            $e->getFile();
            $e->getCode();
            $e->getTrace();
        }
    }

    /**
     * @param string $action
     *
     * @return mixed
     */
    function getCustomAction($action)
    {
        $method = $_POST('custom_method');
        $method = $_GET[$action];
        return $method;
    }
}
