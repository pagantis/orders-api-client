<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Model\Order\Configuration;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class ConfigurationTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class ConfigurationTest extends AbstractTest
{
    /**
     * Test Constructor creates entities
     */
    public function testConstruct()
    {
        $configuration = new Configuration();
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel',
            $configuration->getChannel()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Urls',
            $configuration->getUrls()
        );
    }
}
