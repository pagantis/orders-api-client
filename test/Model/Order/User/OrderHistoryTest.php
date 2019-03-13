<?php

namespace Test\Pagantis\OrdersApiClient\Model\Order\User;

use Faker\Factory;
use Pagantis\OrdersApiClient\Model\Order\User\OrderHistory;
use Test\Pagantis\OrdersApiClient\AbstractTest;

/**
 * Class OrderHistoryTest
 * @package Test\Pagantis\OrdersApiClient\Model\Order\User
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
