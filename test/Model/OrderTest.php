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
     * Initial status of a order.
     */
    const STATUS_CREATED = 'CREATED';

    /**
     * Order has been authorized and initial payment has been approved. For finalizing the order
     * it's mandatory to confirm it.
     */
    const STATUS_AUTHORIZED = 'AUTHORIZED';

    /**
     * Order confirmed has been paid by customer and merchant has confirmed it. Payment is complemeted
     * and settlement will be created.
     */
    const STATUS_CONFIRMED = 'CONFIRMED';

    /**
     * Rejected by the risk engine, the transaction has been rejected and payment is no longer
     * expected nor possible.
     */
    const STATUS_REJECTED = 'REJECTED';

    /**
     * The order has been invalidated due to the expiration limit. If no action happens during the
     * defined time, the order could turn to invalidated.
     */
    const STATUS_INVALIDATED = 'INVALIDATED';

    /**
     * Undefined ERROR has occured, please double check with the account manager or PMT support channels.
     */
    const STATUS_ERROR = 'ERROR';

    /**
     * If a order is not confirmed given the default confirmation time, defined previously, it will turn to
     * unconfirmed and this will refund any possible payment taken from the customer. The loan shall not be created.
     */
    const STATUS_UNCONFIRMED = 'UNCONFIRMED';

    /**
     * The order cancelled is a concecuence of a total refund or sum of partial refunds generating the total refund.
     */
    const STATUS_CANCELLED = 'CANCELLED';

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

        foreach ($object as $key => $value) {
            if (null === $value) {
                unset($object->$key);
            }
        }

        $order = new Order();
        $order->import($object);
        $this->assertTrue($order->validate());
        $orderExport = json_decode(json_encode($order->export()));
        $this->assertEquals($object, $orderExport);
    }

    /**
     * testImport
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testImportEmptyDates()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);

        foreach ($object as $key => $value) {
            if (null === $value) {
                unset($object->$key);
            }
        }

        $order = new Order();
        $order->import($object);
        $this->assertTrue($order->validate());
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
        $this->assertEquals(self::STATUS_CANCELLED, Order::STATUS_CANCELLED);
    }
}
