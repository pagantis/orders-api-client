<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use Faker\Factory;
use Httpful\Http;
use Httpful\Request;
use PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PagaMasTarde\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateOrderMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class CreateOrderMethodTest extends TestCase
{
    /**
     * testEndpointConstant
     */
    public function testEndpointConstant()
    {
        $constant = CreateOrderMethod::ENDPOINT;
        $this->assertEquals('/orders', $constant);
    }

    /**
     * testSetOrderId
     *
     * @throws \ReflectionException
     */
    public function testSetOrderId()
    {
        $order = new Order();
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $createOrderMethod = new CreateOrderMethod($apiConfigurationMock);
        $createOrderMethod->setOrder($order);
        $reflectCreateOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod');
        $property = $reflectCreateOrderMethod->getProperty('order');
        $property->setAccessible(true);
        $this->assertSame($order, $property->getValue($createOrderMethod));
    }

    /**
     * testGetOrder
     *
     * @throws ValidationException
     * @throws \ReflectionException
     */
    public function testGetOrder()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $responseMock = $this->getMockBuilder('Httpful\Response')->disableOriginalConstructor()->getMock();
        $responseMockReflect = new \ReflectionClass('Httpful\Response');
        $property = $responseMockReflect->getProperty('body');
        $property->setAccessible(true);
        $property->setValue($responseMock, json_decode($orderJson));

        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $createOrderMethod = new CreateOrderMethod($apiConfigurationMock);
        $this->assertFalse($createOrderMethod->getOrder());
        $reflectCreateOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod');
        $property = $reflectCreateOrderMethod->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($createOrderMethod, $responseMock);

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $createOrderMethod->getOrder());
    }

    /**
     * testPrepareRequest
     *
     * @throws ValidationException
     * @throws \ReflectionException
     */
    public function testPrepareRequest()
    {
        $faker = Factory::create();
        $url = $faker->url;
        $order = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order');
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->setBaseUri($url);
        $createOrderMethod = new CreateOrderMethod($apiConfiguration);
        $reflectCreateOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod');
        $method = $reflectCreateOrderMethod->getMethod('prepareRequest');
        $method->setAccessible(true);
        $property = $reflectCreateOrderMethod->getProperty('request');
        $property->setAccessible(true);
        $this->assertNull($property->getValue($createOrderMethod));
        $createOrderMethod->setOrder($order);
        $method->invoke($createOrderMethod);
        /** @var Request $request */
        $request = $property->getValue($createOrderMethod);
        $this->assertInstanceOf('Httpful\Request', $request);
        $this->assertSame(Http::POST, $request->method);
        $uri =
            $url .
            CreateOrderMethod::SLASH .
            CreateOrderMethod::ENDPOINT
        ;
        $this->assertSame($uri, $request->uri);
    }

    /**
     * testCall
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\HttpException
     */
    public function testCall()
    {
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $createOrderMethod = new CreateOrderMethod($apiConfigurationMock);
        try {
            $createOrderMethod->call();
            $this->assertTrue(false);
        } catch (ValidationException $exception) {
            $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Exception\ValidationException', $exception);
        }
    }
}
