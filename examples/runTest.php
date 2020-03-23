<?php


//Require the Client library using composer: composer require pagantis/orders-api-client
use Examples\OrdersApiClient\testOrder;
use Examples\OrdersApiClient\utils\Helpers;
use Examples\OrdersApiClient\utils\Log;
use Pagantis\OrdersApiClient\Exception\ClientException;

require_once '../vendor/autoload.php';
require 'testOrder.php';


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
            //$reflection_object = new ReflectionObject($testOrder);
            $reflection_object = getReflectionMethod($testOrder);
            $method = $reflection_object->getMethod($method);
            echo $method->invoke($testOrder);
            Log::write('Reflection Method Invoked ', $withDate = true);
        } catch (ReflectionException $e) {
            $e->getMessage();
        }
    } catch (\Exception $e) {
        $e->getMessage();
    }

}

function getReflectionMethod(TestOrder $testOrder)
{
    if (!$testOrder instanceof TestOrder) {
        new ClientException('Please Check TestOrder Object');
    }
    try {
        $reflection_object = new ReflectionObject($testOrder);
        return $reflection_object;
    } catch (\Exception $e) {
        $e->getMessage();
    }
}

