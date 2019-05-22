<?php

namespace Test\Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\Order\Configuration;
use Test\Pagantis\OrdersApiClient\AbstractTest;

/**
 * Class ConfigurationTest
 * @package Test\Pagantis\OrdersApiClient\Model\Order
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
            'Pagantis\OrdersApiClient\Model\Order\Configuration\Channel',
            $configuration->getChannel()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\Configuration\Urls',
            $configuration->getUrls()
        );
    }

    /**
     * Test setter and getter for purchase country
     */
    public function testSetPurchaseCountry()
    {
        $configuration = new Configuration();
        $purchaseCountry = 'IT';
        $configuration->setPurchaseCountry($purchaseCountry);
        $this->assertSame($purchaseCountry, $configuration->getPurchaseCountry());
    }

    /**
     * Test setter and getter for lower letter purchase country
     */
    public function testSetLowerPurchaseCountry()
    {
        $configuration = new Configuration();
        $purchaseCountry = 'it';
        $configuration->setPurchaseCountry($purchaseCountry);
        $this->assertSame(strtoupper($purchaseCountry), $configuration->getPurchaseCountry());
    }

    /**
     * Test setter and getter for a wrong purchase country
     */
    public function testSetWrongPurchaseCountry()
    {
        $configuration = new Configuration();
        $purchaseCountry = 'en';
        $configuration->setPurchaseCountry($purchaseCountry);
        $this->assertNull($configuration->getPurchaseCountry());
    }

    /**
     * Test setter and getter for a empty purchase country
     */
    public function testSetEmptyPurchaseCountry()
    {
        $configuration = new Configuration();
        $purchaseCountry = '';
        $configuration->setPurchaseCountry($purchaseCountry);
        $this->assertNull($configuration->getPurchaseCountry());
    }

    /**
     * Test setter and getter for a null purchase country
     */
    public function testSetNullPurchaseCountry()
    {
        $configuration = new Configuration();
        $purchaseCountry = null;
        $configuration->setPurchaseCountry($purchaseCountry);
        $this->assertNull($configuration->getPurchaseCountry());
    }
}
