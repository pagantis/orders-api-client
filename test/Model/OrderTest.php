<?php

namespace Test\Pagantis\OrdersApiClient\Model;

use Pagantis\OrdersApiClient\Model\Order;
use Test\Pagantis\OrdersApiClient\AbstractTest;

/**
 * Class OrderTest
 *
 * @package Test\Pagantis\OrdersApiClient\Model
 */
class OrderTest extends AbstractTest
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $order = new Order();
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\Consumer',
            $order->getConsumer()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\Address',
            $order->getAddress()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\Consumer',
            $order->getConsumer()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\Courier',
            $order->getCourier()
        );

        $this->assertNull($order->getToken());
        $this->assertNull($order->getExpires());
    }

    /**
     * testImport
     * @throws \Exception
     */
    public function testImport()
    {
        $orderJson = file_get_contents($this->resourcePath.'Order.json');
        $object = json_decode($orderJson);

        foreach ($object as $key => $value) {
            if (null === $value) {
                unset($object->$key);
            }
        }

        $order = new Order();
        $order->import($object);
        $orderExport = json_decode(json_encode($order->export()));
        $this->assertEquals($object, $orderExport);
    }

    /**
     * testImport
     * @throws \Exception
     */
    public function testImportEmptyDates()
    {
        $orderJson = file_get_contents($this->resourcePath.'Order.json');
        $object = json_decode($orderJson);

        foreach ($object as $key => $value) {
            if (null === $value) {
                unset($object->$key);
            }
        }

        $order = new Order();
        $order->import($object);
        $orderExport = json_decode(json_encode($order->export()));
        $this->assertEquals($object, $orderExport);
    }

    /**
     * testConstantsNotChange
     */
    public function testConstantsNotChange()
    {
        $this->assertEquals(self::STATUS_AUTHORIZED, Order::STATUS_AUTHORIZED);
        $this->assertEquals(self::STATUS_CONFIRMED, Order::STATUS_CONFIRMED);
        $this->assertEquals(self::STATUS_CREATED, Order::STATUS_CREATED);
        $this->assertEquals(self::STATUS_REJECTED, Order::STATUS_REJECTED);
        $this->assertEquals(self::STATUS_INVALIDATED, Order::STATUS_INVALIDATED);
        $this->assertEquals(self::STATUS_ERROR, Order::STATUS_ERROR);
        $this->assertEquals(self::STATUS_UNCONFIRMED, Order::STATUS_UNCONFIRMED);
    }
}
