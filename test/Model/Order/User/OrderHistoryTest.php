<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\User;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\User\OrderHistory;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class OrderHistoryTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\User
 */
class OrderHistoryTest extends AbstractTest
{
    /**
     * testSetAmount
     */
    public function testSetAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $orderHistory = new OrderHistory();
        $orderHistory->setAmount($number);
        $this->assertEquals($orderHistory->getAmount(), $number);
    }
}
