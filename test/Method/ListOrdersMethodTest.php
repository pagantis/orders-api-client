<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Faker\Factory;
use Httpful\Http;
use Httpful\Request;
use PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class ListOrdersMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class ListOrdersMethodTest extends TestCase
{
    /**
     * testEndpointConstant
     */
    public function testEndpointConstant()
    {
        $constant = ListOrdersMethod::ENDPOINT;
        $this->assertEquals('api/v1/orders', $constant);
    }

    /**
     * testSetOrderId
     *
     * @throws \ReflectionException
     */
    public function testSetQueryParameters()
    {
        $queryParameters = array('id' => 'uuid', 'created_at' => '2014-05-05');
        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $listOrderMethod = new ListOrdersMethod($apiConfigurationMock);
        $listOrderMethod->setQueryParameters($queryParameters);
        $reflectGetOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod');
        $property = $reflectGetOrderMethod->getProperty('queryParameters');
        $property->setAccessible(true);
        $this->assertEquals($queryParameters, $property->getValue($listOrderMethod));
    }

    /**
     * testGetOrders
     *
     * @throws \ReflectionException
     */
    public function testGetOrders()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $arrayOfOrders = '[' . $orderJson . ',' . $orderJson . ',' .$orderJson . ']';
            $responseMock = $this->getMockBuilder('Httpful\Response')->disableOriginalConstructor()->getMock();
        $responseMockReflect = new \ReflectionClass('Httpful\Response');
        $property = $responseMockReflect->getProperty('body');
        $property->setAccessible(true);
        $property->setValue($responseMock, json_decode($arrayOfOrders));

        $apiConfigurationMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ApiConfiguration');
        $listOrderMethod = new ListOrdersMethod($apiConfigurationMock);
        $this->assertFalse($listOrderMethod->getOrders());
        $reflectGetOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod');
        $property = $reflectGetOrderMethod->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($listOrderMethod, $responseMock);

        $this->assertNotEmpty($listOrderMethod->getOrders());
        $orders = $listOrderMethod->getOrders();
        foreach ($orders as $order) {
            $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $order);
        }
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
        $queryParameters = array(
            'username' => $faker->userName,
            'created' => $faker->date('Y-m-d')
        );
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->setBaseUri($url);
        $listOrdersMethod = new ListOrdersMethod($apiConfiguration);
        $reflectGetOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod');
        $method = $reflectGetOrderMethod->getMethod('prepareRequest');
        $method->setAccessible(true);
        $property = $reflectGetOrderMethod->getProperty('request');
        $property->setAccessible(true);
        $this->assertNull($property->getValue($listOrdersMethod));
        $listOrdersMethod->setQueryParameters($queryParameters);
        $method->invoke($listOrdersMethod);
        /** @var Request $request */
        $request = $property->getValue($listOrdersMethod);
        $this->assertInstanceOf('Httpful\Request', $request);
        $this->assertSame(Http::GET, $request->method);
        $uri = $url . ListOrdersMethod::SLASH . ListOrdersMethod::ENDPOINT . '?' . http_build_query($queryParameters);
        $this->assertSame($uri, $request->uri);
    }
}
