<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Exceptions\Http\Client\NotFoundException;
use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Method\GetOrderMethod;

/**
 * Class GetOrderMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class GetOrderMethodTest extends AbstractTest
{
    /**
     * testEndpointConstant
     */
    public function testEndpointConstant()
    {
        $constant = GetOrderMethod::ENDPOINT;
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
        $getOrderMethod = new GetOrderMethod($this->get200ApiConfiguration());
        $getOrderMethod->setOrderId($orderId);
        $reflectGetOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\GetOrderMethod');
        $property = $reflectGetOrderMethod->getProperty('orderId');
        $property->setAccessible(true);
        $this->assertEquals($orderId, $property->getValue($getOrderMethod));
    }

    /**
     * testGetOrder
     *
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

        $getOrderMethod = new GetOrderMethod($this->get200ApiConfiguration());
        $this->assertFalse($getOrderMethod->getOrder());
        $reflectGetOrderMethod = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\GetOrderMethod');
        $property = $reflectGetOrderMethod->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($getOrderMethod, $responseMock);

        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\Order', $getOrderMethod->getOrder());
    }

    /**
     * testCall
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function testCall()
    {
        $getOrderMethod = new GetOrderMethod($this->get404ApiConfiguration());
        try {
            $getOrderMethod->call();
            $this->assertTrue(false);
        } catch (ValidationException $exception) {
            $this->assertInstanceOf('Exceptions\Data\ValidationException', $exception);
        }
        $faker = Factory::create();
        $getOrderMethod->setOrderId($faker->uuid);
        try {
            $getOrderMethod->call();
            $this->assertTrue(false);
        } catch (NotFoundException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\NotFoundException', $exception);
        }
        $getOrderMethod = new GetOrderMethod($this->get200ApiConfiguration());
        $getOrderMethod->setOrderId($faker->uuid);
        $getOrderMethod->call();
        $this->assertInstanceOf('Httpful\Response', $getOrderMethod->getResponse());
    }
}
