<?php
namespace PagaMasTarde\Test\OrdersApiClient;

use PagaMasTarde\OrdersApiClient\Client;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class OrderApiClient
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
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ClientException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\UrlException
     */
    public function testGetOrder()
    {
        $ordersClient = new Client(
            'tk_9343d98abb794449a46ccf25',
            '76efd4c7193840e0',
            ApiConfiguration::SANDBOX_BASE_URI
        );
        $order = $ordersClient->getOrderById('5b17cc0c9949ac000688776a');

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
    }
}
