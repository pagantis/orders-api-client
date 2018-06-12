<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details\Product;
use PHPUnit\Framework\TestCase;

/**
 * Class Product
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details
 */
class ProductTest extends TestCase
{
    /**
     * testSetAmount
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetAmount()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $product = new Product();

        $product->setQuantity($number);
        $this->assertEquals($product->getQuantity(), $number);

        $product->setQuantity(0);
    }

    /**
     * testSetDescription
     */
    public function testSetDescription()
    {
        $faker = Factory::create();
        $sentence = $faker->sentence;
        $product = new Product();
        $product->setDescription($sentence);
        $this->assertEquals($product->getDescription(), $sentence);
        $product->setDescription(null);
        $this->assertEquals(null, $product->getDescription());
    }

    /**
     * testSetQuantity
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetQuantity()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $product = new Product();

        $product->setQuantity($number);
        $this->assertEquals($product->getQuantity(), $number);

        $product->setQuantity(0);
    }

    /**
     * Test validate calls setters.
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testValidate()
    {
        $faker = Factory::create();

        //Working:
        $product = new Product();
        $product->setQuantity($faker->randomDigitNotNull);
        $product->setDescription($faker->sentence);
        $product->setAmount($faker->randomDigitNotNull);
        $this->assertTrue($product->validate());

        //Failure: amount and quantity have to be set
        $product = new Product();
        $product->validate();
    }
}
