<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;
use PHPUnit\Framework\TestCase;

/**
 * Class ShoppingCartTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class ShoppingCartTest extends TestCase
{
    /**
     *
    __construct
    getDetails
    getOrderReference
    getPromotedAmount
    getTotalAmount
    setDetails
    setOrderReference
    setPromotedAmount
    setTotalAmount
    validate
     */

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
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetTotalAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $shoppingCart = new ShoppingCart();

        $shoppingCart->setTotalAmount($number);
        $this->assertEquals($number, $shoppingCart->getTotalAmount());

        $shoppingCart->setTotalAmount(0);
    }

    /**
     * testSetPromotedAmount
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetPromotedAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $shoppingCart = new ShoppingCart();

        //Case int
        $shoppingCart->setPromotedAmount($number);
        $this->assertEquals($number, $shoppingCart->getPromotedAmount());

        //Case 0
        $shoppingCart->setPromotedAmount(0);
        $this->assertEquals(0, $shoppingCart->getPromotedAmount());

        //Case Negative
        $shoppingCart->setPromotedAmount(-1);
    }

    /**
     * testValidate
     */
    public function testValidate()
    {
        $shoppingCart = new ShoppingCart();

        //check details->validate() is called:
        $details = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details');
        $details->expects($this->atLeastOnce())->method('validate');
        $shoppingCart->setDetails($details);

        try {
            $shoppingCart->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Total Amount cannot be empty
            $this->assertTrue(true);
        }

        $shoppingCart->setTotalAmount($shoppingCart->getPromotedAmount() + 1);
        $this->assertTrue($shoppingCart->validate());
        $shoppingCart->setPromotedAmount($shoppingCart->getTotalAmount() + 1);

        try {
            $shoppingCart->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Total Promoted amount cannot be higher than Total amount
            $this->assertTrue(true);
        }
    }
}
