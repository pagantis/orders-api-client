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
     * testClassExists
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('PagaMasTarde\OrdersApiClient\Client'));
    }

    /**
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testGetOrder()
    {
        $ordersClient = new Client(
            'tk_9343d98abb794449a46ccf25',
            '76efd4c7193840e0',
            ApiConfiguration::SANDBOX_BASE_URI
        );
        $order = $ordersClient->getOrderById('5b1906b4e659900006a7c623');

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
    }

    /**
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testListOrders()
    {
        $ordersClient = new Client(
            'tk_9343d98abb794449a46ccf25',
            '76efd4c7193840e0',
            ApiConfiguration::SANDBOX_BASE_URI
        );
        $orders = $ordersClient->listOrders(array('page' => 3));

        $this->assertTrue(is_array($orders));
    }

    /**
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testCreateOrder()
    {
        $ordersClient = new Client(
            'tk_9343d98abb794449a46ccf25',
            '76efd4c7193840e0',
            ApiConfiguration::SANDBOX_BASE_URI
        );

        $order = new Order();

        //Create BasicOrder
        $configuration = new Order\Configuration();
        $configuration
            ->getUrls()
                ->setCancel('http://cancel.com')
                ->setKo('http://ko.com')
                ->setOk('http://ok.com')
                ->setNotificationCallback('http://noticy.com')
        ;
        $configuration
            ->getChannel()
                ->setType(Order\Configuration\Channel::ONLINE)
        ;
        $order->setConfiguration($configuration);
        $product = new Order\ShoppingCart\Details\Product();
        $product
            ->setAmount(2000)
            ->setDescription('Tonight is the night')
            ->setQuantity(5)
        ;
        $details = new Order\ShoppingCart\Details();
        $details
            ->setShippingCost(100)
            ->addProduct($product)
        ;
        $shoppingCart = new Order\ShoppingCart();
        $shoppingCart
            ->setOrderReference(time())
            ->setTotalAmount(2000)
            ->setDetails($details)
        ;
        $order->setShoppingCart($shoppingCart);
        $address = new Order\User\Address();
        $address
            ->setAddress('Micasa, 256')
            ->setFullName('Cesar Romero Latorre')
            ->setCity('Madrid')
            ->setCountryCode('ES')
            ->setZipCode('29999')
        ;
        $user = new Order\User();
        $user
            ->setDni('02294008B')
            ->setEmail('cromero+spam@digitalorigin.com')
            ->setFullName('Cesar Romero Latorre')
            ->setAddress($address)
            ->setBillingAddress($address)
            ->setShippingAddress($address)
        ;
        $order->setUser($user);
        $order = $ordersClient->createOrder($order);

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
    }
}
