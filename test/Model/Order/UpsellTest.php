<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\Upsell;
use PHPUnit\Framework\TestCase;

/**
 * Class UpsellTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class UpsellTest extends TestCase
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $upsell = new Upsell();
        $this->assertInstanceOf('\DateTime', $upsell->getUpsellAt());
    }

    /**
     * testSetAmount
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $upsell = new Upsell();

        $upsell->setTotalAmount($number);
        $this->assertEquals($number, $upsell->getTotalAmount());

        $upsell->setTotalAmount(0);
    }

    /**
     * Test Validate
     */
    public function testValidate()
    {
        $upsell = new Upsell();

        try {
            $upsell->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Total Amount cannot be empty
            $this->assertTrue(true);
        }
    }
}
