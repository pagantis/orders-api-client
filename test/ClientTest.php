<?php
namespace Test\PagaMasTarde\OrdersApiClient;

use PagaMasTarde\OrdersApiClient\Client;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
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
}
