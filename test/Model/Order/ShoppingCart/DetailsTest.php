<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class Details
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart
 */
class DetailsTest extends AbstractTest
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
        $products = $details->getProducts();
        $productFromDetails = array_pop($products);
        $this->assertSame($productFromDetails, $product);
    }

    /**
     * testShippingCost
     */
    public function testShippingCost()
    {
        $faker = Factory::create();
        $number = $faker->randomDigitNotNull;
        $details = new Details();
        $details->setShippingCost($number);
        $this->assertEquals($details->getShippingCost(), $number);
    }

    /**
     * test Import
     */
    public function testImport()
    {
        $orderJson = file_get_contents($this->resourcePath.'Order.json');
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
}
