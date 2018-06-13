<?php
namespace Test\PagaMasTarde\OrdersApiClient;

use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
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
}
