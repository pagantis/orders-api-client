<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Faker\Factory;
use Httpful\Http;
use Httpful\Request;
use PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PagaMasTarde\OrdersApiClient\Model\Order\Upsell;
use PHPUnit\Framework\TestCase;

/**
 * Class UpsellOrderMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class UpsellOrderMethodTest extends TestCase
{
    /**
     * testEndpointConstant
     */
    public function testEndpointConstant()
    {
        $constant = UpsellOrderMethod::ENDPOINT;
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
        $upsellOrderMethod = new UpsellOrderMethod($apiConfigurationMock);
        $upsellOrderMethod->setOrderId($orderId);
        $reflectUpsellOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod');
        $property = $reflectUpsellOrderMethod->getProperty('orderId');
        $property->setAccessible(true);
        $this->assertEquals($orderId, $property->getValue($upsellOrderMethod));
    }

    /**
     * testSetOrderId
     *
     * @throws \ReflectionException
     */
    public function testSetUpsell()
    {
        $upsell = new Upsell();
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $upsellOrderMethod = new UpsellOrderMethod($apiConfigurationMock);
        $upsellOrderMethod->setUpsell($upsell);
        $reflectUpsellOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod');
        $property = $reflectUpsellOrderMethod->getProperty('upsell');
        $property->setAccessible(true);
        $this->assertSame($upsell, $property->getValue($upsellOrderMethod));
    }

    /**
     * testGetOrder
     *
     * @throws \ReflectionException
     */
    public function testGetUpsell()
    {
        $orderJson = file_get_contents('test/Resources/Upsell.json');
        $responseMock = $this->getMockBuilder('Httpful\Response')->disableOriginalConstructor()->getMock();
        $responseMockReflect = new \ReflectionClass('Httpful\Response');
        $property = $responseMockReflect->getProperty('body');
        $property->setAccessible(true);
        $property->setValue($responseMock, json_decode($orderJson));

        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $upsellOrderMethod = new UpsellOrderMethod($apiConfigurationMock);
        $this->assertFalse($upsellOrderMethod->getUpsell());
        $reflectUpsellOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod');
        $property = $reflectUpsellOrderMethod->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($upsellOrderMethod, $responseMock);

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order\Upsell', $upsellOrderMethod->getUpsell());
    }

    /**
     * testPrepareRequest
     *
     * @throws \ReflectionException
     */
    public function testPrepareRequest()
    {
        $faker = Factory::create();
        $url = $faker->url;
        $orderId = $faker->uuid;
        $upsell = new Upsell();
        $upsell
            ->setTotalAmount($faker->randomDigitNotNull)
        ;
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->setBaseUri($url);
        $upsellOrderMethod = new UpsellOrderMethod($apiConfiguration);
        $upsellOrderMethod->setUpsell($upsell);
        $reflectUpsellOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod');
        $method = $reflectUpsellOrderMethod->getMethod('prepareRequest');
        $method->setAccessible(true);
        $property = $reflectUpsellOrderMethod->getProperty('request');
        $property->setAccessible(true);
        $this->assertNull($property->getValue($upsellOrderMethod));
        $upsellOrderMethod->setOrderId($orderId);
        $method->invoke($upsellOrderMethod);
        /** @var Request $request */
        $request = $property->getValue($upsellOrderMethod);
        $this->assertInstanceOf('Httpful\Request', $request);
        $this->assertSame(Http::PUT, $request->method);
        $uri =
            $url .
            UpsellOrderMethod::SLASH .
            UpsellOrderMethod::ENDPOINT .
            UpsellOrderMethod::SLASH .
            $orderId .
            UpsellOrderMethod::SLASH .
            UpsellOrderMethod::UPSELL_ENDPOINT
        ;
        $this->assertSame($uri, $request->uri);
    }

    /**
     * testCall
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testCall()
    {
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $upsellOrderMethod = new UpsellOrderMethod($apiConfigurationMock);
        try {
            $upsellOrderMethod->call();
            $this->assertTrue(false);
        } catch (ValidationException $exception) {
            $this->assertInstanceOf('Exceptions\Data\ValidationException', $exception);
        }
    }
}
