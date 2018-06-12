<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;

use Exceptions\Data\ValidationException;
use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details;
use PHPUnit\Framework\TestCase;

/**
 * Class Details
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart
 */
class DetailsTest extends TestCase
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $details = new Details();
        $this->assertTrue(is_array($details->getProducts()));
    }

    /**
     * testAddProduct
     */
    public function testAddProduct()
    {
        $details = new Details();
        $product = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details\Product'
        );
        $details->addProduct($product);
        $products = $details->getProducts();
        $this->assertTrue(is_array($products));
        if (count($products) !== 1) {
            $exception = new \Exception('Product should have 1 element');
            $this->throwException($exception);
        }
        $productFromDetails = array_pop($details->getProducts());
        $this->assertSame($productFromDetails, $product);
    }

    /**
     * testShippingCost
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testShippingCost()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $details = new Details();

        //Working:
        $details->setShippingCost($number);
        $this->assertEquals($details->getShippingCost(), $number);

        //Working: shipping can be 0
        $details->setShippingCost(0);

        //Failure: not negative values nor not int
        $details->setShippingCost(-1);
    }

    /**
     * testValidate
     *
     * Validate at least 1 object and validate that each object is calling validate
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $details = new Details();

        try {
            $details->validate();
        } catch (ValidationException $exception) {
            //At least 1 product is expected
            $this->assertTrue(true);
        };

        $product = new Details\Product();
        $details->addProduct($product);

        try {
            $details->validate();
        } catch (ValidationException $exception) {
            //Product doesn't validate
            $this->assertTrue(true);
        };

        $product->setAmount($faker->randomDigitNotNull);
        $product->setQuantity($faker->randomDigitNotNull);
        $product->setDescription($faker->sentence);

        $this->assertTrue($details->validate());
    }
}
