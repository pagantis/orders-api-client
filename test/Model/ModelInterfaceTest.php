<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model;

use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class ModelInterfaceTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Model
 */
class ModelInterfaceTest extends AbstractTest
{
    /**
     * testInterfaceExists
     */
    public function testInterfaceExists()
    {
        $interfaceMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ModelInterface');
        $this->assertInstanceOf('PagaMasTarde\OrdersApiClient\Model\ModelInterface', $interfaceMock);
    }

    /**
     * testInterfaceExists
     */
    public function testInterfaceHasMethodExport()
    {
        $interfaceMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ModelInterface');
        $this->assertTrue(method_exists($interfaceMock, 'export'));
    }

    /**
     * testInterfaceExists
     */
    public function testInterfaceHasMethodImport()
    {
        $interfaceMock = $this->getMock('PagaMasTarde\OrdersApiClient\Model\ModelInterface');
        $this->assertTrue(method_exists($interfaceMock, 'import'));
    }
}
