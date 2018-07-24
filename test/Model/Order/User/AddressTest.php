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
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetFullName()
    {
        $faker = Factory::create();
        $address = new Address();
        $fullName = $faker->name.' '.$faker->lastName;
        $address->setFullName($fullName);
        $this->assertSame($fullName, $address->getFullName());
        $address->setFullName('');
    }

    /**
     * testValidate
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $address = new Address();
        $this->assertTrue($address->validate());
        $fullName = $faker->name.' '.$faker->lastName;
        $address->setFullName($fullName);
        $this->assertTrue($address->validate());
    }
}
