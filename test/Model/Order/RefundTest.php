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
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $refund = new Refund();

        $refund->setTotalAmount($number);
        $this->assertEquals($number, $refund->getTotalAmount());

        $refund->setTotalAmount(0);
    }

    /**
     * testSetPromotedAmount
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetPromotedAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $refund = new Refund();

        //Case int
        $refund->setPromotedAmount($number);
        $this->assertEquals($number, $refund->getPromotedAmount());

        //Case 0
        $refund->setPromotedAmount(0);
        $this->assertEquals(0, $refund->getPromotedAmount());

        //Case Negative
        $refund->setPromotedAmount(-1);
    }

    /**
     * testValidate
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testValidate()
    {
        $refund = new Refund();

        try {
            $refund->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Total Amount cannot be empty
            $this->assertTrue(true);
        }

        $refund->setTotalAmount($refund->getPromotedAmount() + 1);
        $this->assertTrue($refund->validate());
        $refund->setPromotedAmount($refund->getTotalAmount() + 1);

        try {
            $refund->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Total Promoted amount cannot be higher than Total amount
            $this->assertTrue(true);
        }
    }
}
