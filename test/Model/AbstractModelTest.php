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
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testAllMethod()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);
        $this->assertTrue($order->validate());
        $orderExport = json_decode(json_encode($order->export()));
        $orderExportJson = json_encode($order->export());
        $this->assertEquals($object, $orderExport);
        $this->assertEquals($orderJson, $orderExportJson);
    }
}
