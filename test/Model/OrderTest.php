<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Class OrderTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Model
 */
class OrderTest extends TestCase
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $order = new Order();
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\User',
            $order->getUser()
        );
        $this->assertNull(
            $order->getActionUrls()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration',
            $order->getConfiguration()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart',
            $order->getShoppingCart()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\Metadata',
            $order->getMetadata()
        );

        $this->assertNull($order->getConfirmedAt());
        $this->assertNull($order->getCreatedAt());
        $this->assertNull($order->getExpiresAt());
        $this->assertNull($order->getRefunds());
        $this->assertNull($order->getUpsells());
    }

    /**
     * testValidate
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testValidate()
    {
        $order = new Order();

        //test AbstractModel calls validate
        $object = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\ActionUrls');
        $object->expects($this->atLeastOnce())->method('validate');
        $order->setActionUrls($object);
        $object = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\Configuration');
        $object->expects($this->atLeastOnce())->method('validate');
        $order->setConfiguration($object);
        $object = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\Metadata');
        $object->expects($this->atLeastOnce())->method('validate');
        $order->setMetadata($object);
        $object = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart');
        $object->expects($this->atLeastOnce())->method('validate');
        $order->setShoppingCart($object);
        $object = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\User');
        $object->expects($this->atLeastOnce())->method('validate');
        $order->setUser($object);
        $this->assertTrue($order->validate());
    }

    /**
     * testImport
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testImport()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);
        $this->assertTrue($order->validate());
        $orderExport = json_decode(json_encode($order->export()));
        $this->assertEquals($object, $orderExport);
    }
}
