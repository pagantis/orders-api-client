<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractModelTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Model
 */
class AbstractModelTest extends TestCase
{
    /**
     * complete testing, entire order validate, export and import
     */
    public function testAllMethod()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);
        $orderExport = json_decode(json_encode($order->export()));
        $orderExportJson = json_encode(
            $order->export(),
            JSON_UNESCAPED_UNICODE |
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_SLASHES
        );
        $this->assertEquals($object, $orderExport);
        var_dump($orderExportJson);die;
        $this->assertEquals($orderJson, $orderExportJson);
    }
}
