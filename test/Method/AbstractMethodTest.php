<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Client\BadRequestException;
use PagaMasTarde\OrdersApiClient\Method\AbstractMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractMethodTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class AbstractMethodTest extends TestCase
{
    /**
     * Has Slash
     */
    public function testHasSlashConstant()
    {
        $constant = AbstractMethod::SLASH;
        $this->assertEquals('/', $constant);
    }

    /**
     * Test Constructor
     *
     * @throws \ReflectionException
     */
    public function testConstructor()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $property = $reflectedClass->getProperty('apiConfiguration');
        $property->setAccessible(true);
        $this->assertSame($apiConfiguration, $property->getValue($abstractMethod));
    }

    /**
     * Test get Request
     *
     * @throws \ReflectionException
     */
    public function testGetRequest()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('getRequest');
        $method->setAccessible(true);
        $this->assertInstanceOf('Httpful\Request', $method->invoke($abstractMethod));
    }

    /**
     * testGetResponse
     *
     * @throws \ReflectionException
     */
    public function testGetResponse()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('getResponse');
        $method->setAccessible(true);
        $this->assertFalse($method->invoke($abstractMethod));

        $responseMock = $this->getMockBuilder('Httpful\Response')->disableOriginalConstructor()->getMock();
        $property = $reflectedClass->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($abstractMethod, $responseMock);
        $this->assertInstanceOf('Httpful\Response', $method->invoke($abstractMethod));
    }

    /**
     * testGetResponseAsJson
     *
     * @throws \ReflectionException
     */
    public function testGetResponseAsJson()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('getResponseAsJson');
        $method->setAccessible(true);
        $this->assertFalse($method->invoke($abstractMethod));

        $json = 'body';
        $responseMock = $this->getMockBuilder('Httpful\Response')->disableOriginalConstructor()->getMock();
        $responseMockReflect = new \ReflectionClass('Httpful\Response');
        $property = $responseMockReflect->getProperty('body');
        $property->setAccessible(true);
        $property->setValue($responseMock, $json);

        $property = $reflectedClass->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($abstractMethod, $responseMock);
        $this->assertSame($json, $method->invoke($abstractMethod));
    }

    /**
     * Test Add get parameters work correctly
     *
     * @throws \ReflectionException
     */
    public function testAddGetParameters()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('addGetParameters');
        $method->setAccessible(true);
        $this->assertEquals('', $method->invoke($abstractMethod, array()));
        $this->assertEquals('?id=123', $method->invoke($abstractMethod, array('id' => 123)));
    }

    /**
     * Test Parse HTTP Exceptions
     *
     * @throws \ReflectionException
     */
    public function testParseHttpException()
    {
        $apiConfiguration = new ApiConfiguration();
        $abstractMethod = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            array('call'),
            array($apiConfiguration)
        );

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('parseHttpException');
        $method->setAccessible(true);
        $this->setExpectedException('Exceptions\Http\Client\BadRequestException');
        $method->invoke($abstractMethod, BadRequestException::HTTP_CODE);
        $this->getExpectedException();
    }
}
