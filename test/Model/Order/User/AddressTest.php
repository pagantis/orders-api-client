<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\User;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\User\Address;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\User
 */
class AddressTest extends TestCase
{
    /**
     * testSetFullName
     *
     * @expectedException \Exceptions\Data\ValidationException
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
