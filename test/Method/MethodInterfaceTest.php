<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class MethodInterfaceTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Method;
 */
class MethodInterfaceTest extends AbstractTest
{
    /**
     * testInterfaceExists
     */
    public function testInterfaceExists()
    {
        $interfaceMock = $this->getMock('PagaMasTarde\OrdersApiClient\Method\MethodInterface');
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Method\MethodInterface', $interfaceMock);
    }

    /**
     * testInterfaceHasMethodCall
     */
    public function testInterfaceHasMethodCall()
    {
        $interfaceMock = $this->getMock('PagaMasTarde\OrdersApiClient\Method\MethodInterface');
        $this->assertTrue(method_exists($interfaceMock, 'call'));
    }
}
