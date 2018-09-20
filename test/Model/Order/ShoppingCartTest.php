<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class ShoppingCartTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class ShoppingCartTest extends AbstractTest
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $shoppingCart = new ShoppingCart();
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details',
            $shoppingCart->getDetails()
        );
    }

    /**
     * testSetAmount
     */
    public function testSetTotalAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setTotalAmount($number);
        $this->assertEquals($number, $shoppingCart->getTotalAmount());
    }

    /**
     * testSetPromotedAmount
     */
    public function testSetPromotedAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setPromotedAmount($number);
        $this->assertEquals($number, $shoppingCart->getPromotedAmount());
    }
}
