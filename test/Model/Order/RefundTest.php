<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\Refund;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class RefundTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class RefundTest extends AbstractTest
{
    /**
     * testSetAmount
     */
    public function testSetAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $refund = new Refund();
        $refund->setTotalAmount($number);
        $this->assertEquals($number, $refund->getTotalAmount());
    }

    /**
     * testSetPromotedAmount
     */
    public function testSetPromotedAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $refund = new Refund();
        $refund->setPromotedAmount($number);
        $this->assertEquals($number, $refund->getPromotedAmount());
    }
}
