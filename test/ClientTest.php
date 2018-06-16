<?php
namespace Test\PagaMasTarde\OrdersApiClient;

use PagaMasTarde\OrdersApiClient\Client;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PagaMasTarde\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package PagaMasTarde\Test
 */
class ClientTest extends TestCase
{
    /**
     * Demo Public Key For access the service
     */
    const PUBLIC_KEY = 'tk_9343d98abb794449a46ccf25';

    /**
     * Demo Private Key For access the service
     */
    const PRIVATE_KEY = '76efd4c7193840e0';

    /**
     * @var Order
     */
    protected $order;

    /**
     * testClassExists
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('PagaMasTarde\OrdersApiClient\Client'));
    }

    /**
     * @return ApiConfiguration
     */
    public function getApiConfiguration()
    {
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration
            ->setBaseUri(ApiConfiguration::SANDBOX_BASE_URI)
            ->setPrivateKey(self::PRIVATE_KEY)
            ->setPublicKey(self::PUBLIC_KEY)
        ;

        return $apiConfiguration;
    }

    /**
     * createOrder
     *
     * @return bool|false|Order|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \ReflectionException
     */
    public function testCreateOrder()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);
        $order->validate();
        $order
            ->setActionUrls(null)
            ->setApiVersion(null)
            ->setConfirmedAt(null)
            ->setCreatedAt(null)
            ->setExpiresAt(null)
            ->setGracePeriod(null)
            ->setGracePeriodMonth(null)
            ->setId(null)
            ->setStatus(null)
        ;

        $orderReflectionClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Model\Order');
        $property = $orderReflectionClass->getProperty('refunds');
        $property->setAccessible(true);
        $property->setValue($order, null);
        $property = $orderReflectionClass->getProperty('upsells');
        $property->setAccessible(true);
        $property->setValue($order, null);

        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $orderCreated = $apiClient->createOrder($order);

        $this->assertEquals($order->getConfiguration(), $orderCreated->getConfiguration());
        $this->assertEquals($order->getShoppingCart(), $orderCreated->getShoppingCart());
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
        $formUrl = $orderCreated->getActionUrls()->getForm();
        $this->assertTrue(Order\Configuration\Urls::urlValidate($formUrl));

        $this->order = $orderCreated;
        return $orderCreated;
    }

    /**
     * testGetOrder
     *
     * @return false|Order|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \ReflectionException
     */
    public function testGetOrder()
    {
        if (!$this->order instanceof Order) {
            $this->testCreateOrder();
        }

        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);

        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $orderRetrieved = $apiClient->getOrder($this->order->getId());

        $this->assertEquals($order->getConfiguration(), $orderRetrieved->getConfiguration());
        $this->assertEquals($order->getShoppingCart(), $orderRetrieved->getShoppingCart());
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
        $this->order->setConfirmedAt(null);
        $orderRetrieved->setConfirmedAt(null);
        $this->assertEquals($this->order, $orderRetrieved);
        return $orderRetrieved;
    }

    /**
     * testListOrders
     *
     * @return false | array
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testListOrders()
    {
        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $ordersRetrieved = $apiClient->listOrders(array());

        foreach ($ordersRetrieved as $order) {
            $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
        }

        return $ordersRetrieved;
    }

    /**
     * testConfirmOrder
     *
     * @return false|Order|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \ReflectionException
     */
    public function testConfirmOrder()
    {
        if (!$this->order instanceof Order) {
            $this->testCreateOrder();
        }

        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $order = new Order();
        $order->import($object);

        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $orderRetrieved = $apiClient->confirmOrder($this->order->getId());

        $this->assertEquals($order->getConfiguration(), $orderRetrieved->getConfiguration());
        $this->assertEquals($order->getShoppingCart(), $orderRetrieved->getShoppingCart());
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);

        return $orderRetrieved;
    }

    /**
     * testRefundOrder
     *
     * @return bool|false|Order\Refund|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \ReflectionException
     */
    public function testRefundOrder()
    {
        if (!$this->order instanceof Order) {
            $this->testCreateOrder();
        }

        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $refund = new Order\Refund();
        $refund
            ->setPromotedAmount(0)
            ->setTotalAmount(10)
        ;

        $refund = $apiClient->refundOrder($this->order->getId(), $refund);
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Refund', $refund);

        return $refund;
    }

    /**
     * testUpsellOrder
     *
     * @return bool|false|Order\Refund|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \ReflectionException
     */
    public function testUpsellOrder()
    {
        if (!$this->order instanceof Order) {
            $this->testCreateOrder();
        }

        $apiClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY,
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $upsell = new Order\Upsell();
        $upsell
            ->setTotalAmount(10)
        ;

        $upsellRetrieved = $apiClient->upsellOrder($this->order->getId(), $upsell);
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Upsell', $upsellRetrieved);

        return $upsellRetrieved;
    }
}
