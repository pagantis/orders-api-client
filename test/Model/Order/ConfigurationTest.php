<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use Faker\Factory;
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

    /**
     * testValidate
     *
     * @throws ValidationException
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $configuration = new Configuration();

        try {
            $configuration->validate();
            $this->assertTrue(false);
        } catch (ValidationException $exception) {
            //Failed because of child validation
            $this->assertTrue(true);
        };

        //Make the child valid:
        $configuration->getUrls()
            ->setKo($faker->url)
            ->setOk($faker->url)
        ;

        $configuration->getChannel()
            ->setType(Configuration\Channel::ONLINE)
        ;

        $this->assertTrue($configuration->validate());
    }
}
