<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ActionUrls;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class ActionUrlsTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class ActionUrlsTest extends AbstractTest
{
    /**
     * testValidate
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $actionUrls = new ActionUrls();
        $this->assertTrue($actionUrls->validate());
        $url = $faker->url;
        $actionUrls->setConfirm($url);
        $this->assertTrue($actionUrls->validate());
    }
}
