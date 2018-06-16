<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Client\BadRequestException;
use Exceptions\Http\Client\ForbiddenException;
use Exceptions\Http\Client\MethodNotAllowedException;
use Exceptions\Http\Client\NotFoundException;
use Exceptions\Http\Client\UnauthorizedException;
use Exceptions\Http\Client\UnprocessableEntityException;
use Exceptions\Http\Server\InternalServerErrorException;
use Exceptions\Http\Server\ServiceUnavailableException;
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
        $property = $responseMockReflect->getProperty('raw_body');
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
        try {
            $method->invoke($abstractMethod, BadRequestException::HTTP_CODE);
        } catch (BadRequestException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\BadRequestException', $exception);
        }
        try {
            $method->invoke($abstractMethod, UnauthorizedException::HTTP_CODE);
        } catch (UnauthorizedException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\UnauthorizedException', $exception);
        }
        try {
            $method->invoke($abstractMethod, ForbiddenException::HTTP_CODE);
        } catch (ForbiddenException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\ForbiddenException', $exception);
        }
        try {
            $method->invoke($abstractMethod, NotFoundException::HTTP_CODE);
        } catch (NotFoundException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\NotFoundException', $exception);
        }
        try {
            $method->invoke($abstractMethod, MethodNotAllowedException::HTTP_CODE);
        } catch (MethodNotAllowedException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\MethodNotAllowedException', $exception);
        }
        try {
            $method->invoke($abstractMethod, UnprocessableEntityException::HTTP_CODE);
        } catch (UnprocessableEntityException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Client\UnprocessableEntityException', $exception);
        }
        try {
            $method->invoke($abstractMethod, InternalServerErrorException::HTTP_CODE);
        } catch (InternalServerErrorException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Server\InternalServerErrorException', $exception);
        }
        try {
            $method->invoke($abstractMethod, ServiceUnavailableException::HTTP_CODE);
        } catch (ServiceUnavailableException $exception) {
            $this->assertInstanceOf('Exceptions\Http\Server\ServiceUnavailableException', $exception);
        }
    }

    /**
     * testSetResponse
     *
     * @expectedException \Exceptions\Http\Server\InternalServerErrorException
     *
     * @throws \ReflectionException
     */
    public function testSetResponseException()
    {
        $responseMock = $this
            ->getMockBuilder('Httpful\Response')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $abstractMethod = $this
            ->getMockBuilder('PagaMasTarde\OrdersApiClient\Method\AbstractMethod')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('setResponse');
        $method->setAccessible(true);

        $responseMock->code = InternalServerErrorException::HTTP_CODE;
        $responseMock->method('hasErrors')->willReturn(true);
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            $method->invoke($abstractMethod, $responseMock)
        );
    }

    /**
     * testSetResponse
     *
     * @throws \ReflectionException
     */
    public function testSetResponse()
    {
        $responseMock = $this
            ->getMockBuilder('Httpful\Response')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $abstractMethod = $this
            ->getMockBuilder('PagaMasTarde\OrdersApiClient\Method\AbstractMethod')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflectedClass = new \ReflectionClass('PagaMasTarde\OrdersApiClient\Method\AbstractMethod');
        $method = $reflectedClass->getMethod('setResponse');
        $method->setAccessible(true);

        $responseMock->method('hasErrors')->willReturn(false);
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Method\AbstractMethod',
            $method->invoke($abstractMethod, $responseMock)
        );
    }
}
