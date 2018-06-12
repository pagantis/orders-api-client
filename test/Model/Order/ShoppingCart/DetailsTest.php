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

    /**
     * testImport
     *
     * Fully test of import
     */
    public function testImport()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $object = $object->shopping_cart->details;
        $details = new Details();
        $details->import($object);
        $products = $details->getProducts();
        $this->assertSame($object->shipping_cost, $details->getShippingCost());
        $this->assertSame(count($object->products), count($details->getProducts()));

        foreach ($object->products as $key => $product) {
            /** @var Details\Product $detailsProduct */
            $detailsProduct = $products[$key];
            $this->assertSame($product->amount, $detailsProduct->getAmount());
            $this->assertSame($product->description, $detailsProduct->getDescription());
            $this->assertSame($product->quantity, $detailsProduct->getQuantity());
        }

        //Finally test that the result of the export == the import
        $this->assertEquals($object, json_decode(json_encode($details->export())));
    }


    /**
     * testImport
     *
     * @expectedException \Exceptions\Data\IntegrityException
     */
    public function testImportCrashForNonExistingProperty()
    {
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $object = $object->shopping_cart->details;
        $object->fake_property = 50;
        $details = new Details();
        $details->import($object);
    }
}
