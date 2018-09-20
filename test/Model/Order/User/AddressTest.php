<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\User;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\User\Address;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class AddressTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\User
 */
class AddressTest extends AbstractTest
{
    /**
     * testSetFullName
     */
    public function testSetFullName()
    {
        $faker = Factory::create();
        $address = new Address();
        $fullName = $faker->name.' '.$faker->lastName;
        $address->setFullName($fullName);
        $this->assertSame($fullName, $address->getFullName());
    }
}
