<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use Faker\Factory;
use Httpful\Http;
use Httpful\Request;
use PagaMasTarde\OrdersApiClient\Method\ConfirmOrderMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfirmOrderMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class ConfirmOrderMethodTest extends TestCase
{
    /**
     * testEndpointConstant
     */
    public function testEndpointConstant()
    {
        $constant = ConfirmOrderMethod::ENDPOINT;
        $this->assertEquals('api/v1/orders', $constant);
    }

    /**
     * testSetOrderId
     *
     * @throws \ReflectionException
     */
    public function testSetOrderId()
    {
        $faker = Factory::create();
        $orderId = $faker->uuid;
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $confirmOrderMethod = new ConfirmOrderMethod($apiConfigurationMock);
        $confirmOrderMethod->setOrderId($orderId);
        $reflectConfirmOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ConfirmOrderMethod');
        $property = $reflectConfirmOrderMethod->getProperty('orderId');
        $property->setAccessible(true);
        $this->assertEquals($orderId, $property->getValue($confirmOrderMethod));
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
        $confirmOrderMethod = new ConfirmOrderMethod($apiConfigurationMock);
        $this->assertFalse($confirmOrderMethod->getOrder());
        $reflectConfirmOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ConfirmOrderMethod');
        $property = $reflectConfirmOrderMethod->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($confirmOrderMethod, $responseMock);

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $confirmOrderMethod->getOrder());
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
        $orderId = $faker->uuid;
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->setBaseUri($url);
        $confirmOrderMethod = new ConfirmOrderMethod($apiConfiguration);
        $reflectConfirmOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ConfirmOrderMethod');
        $method = $reflectConfirmOrderMethod->getMethod('prepareRequest');
        $method->setAccessible(true);
        $property = $reflectConfirmOrderMethod->getProperty('request');
        $property->setAccessible(true);
        $this->assertNull($property->getValue($confirmOrderMethod));
        $confirmOrderMethod->setOrderId($orderId);
        $method->invoke($confirmOrderMethod);
        /** @var Request $request */
        $request = $property->getValue($confirmOrderMethod);
        $this->assertInstanceOf('Httpful\Request', $request);
        $this->assertSame(Http::PUT, $request->method);
        $uri =
            $url .
            ConfirmOrderMethod::SLASH .
            ConfirmOrderMethod::ENDPOINT .
            ConfirmOrderMethod::SLASH .
            $orderId .
            ConfirmOrderMethod::SLASH .
            ConfirmOrderMethod::CONFIRM_ENDPOINT
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
        $confirmOrderMethod = new ConfirmOrderMethod($apiConfigurationMock);
        try {
            $confirmOrderMethod->call();
            $this->assertTrue(false);
        } catch (ValidationException $exception) {
            $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Exception\ValidationException', $exception);
        }
    }
}
