<?php

namespace Test\Pagantis\OrdersApiClient\Model\Order;

use Faker\Factory;
use Pagantis\OrdersApiClient\Model\Order\User;
use Test\Pagantis\OrdersApiClient\AbstractTest;

/**
 * Class UserTest
 * @package Test\Pagantis\OrdersApiClient\Model\Order
 */
class UserTest extends AbstractTest
{
    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $user = new User();
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\User\Address',
            $user->getAddress()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\User\Address',
            $user->getBillingAddress()
        );
        $this->assertInstanceOf(
            'Pagantis\OrdersApiClient\Model\Order\User\Address',
            $user->getShippingAddress()
        );
        $this->assertTrue(is_array($user->getOrderHistory()));
    }

    /**
     * testSetDateOfBirth
     */
    public function testSetDateOfBirth()
    {
        $beforeFiftyYears = date('Y-m-d', strtotime('-18 years'));
        $user = new User();
        $this->assertNull($user->getDateOfBirth());
        $user->setDateOfBirth($beforeFiftyYears);
        $this->assertSame($beforeFiftyYears, $user->getDateOfBirth());

        $nullDate = null;
        $user = new User();
        $this->assertNull($user->getDateOfBirth());
        $user->setDateOfBirth($nullDate);
        $this->assertSame($nullDate, $user->getDateOfBirth());
    }

    /**
     * testSetDni
     */
    public function testSetDni()
    {
        $user = new User();
        $dni = '1234567Y';
        $user->setDni($dni);
        $this->assertSame($dni, $user->getDni());
    }

    /**
     * Test SetEmail
     */
    public function testSetEmail()
    {
        $faker = Factory::create();
        $user = new User();
        $email = $faker->email;
        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
    }

    /**
     * testSetFullName
     */
    public function testSetFullName()
    {
        $faker = Factory::create();
        $user = new User();
        $fullName = $faker->name . ' ' . $faker->lastName;
        $user->setFullName($fullName);
        $this->assertSame($fullName, $user->getFullName());
    }

    /**
     * testAddOrderHistory
     */
    public function testAddOrderHistory()
    {
        $user = new User();
        $orderHistoryMock = $this->getMock(
            'Pagantis\OrdersApiClient\Model\Order\User\OrderHistory'
        );
        $user->addOrderHistory($orderHistoryMock);
        $ordersHistory = $user->getOrderHistory();
        $objectOrderHistory = array_pop($ordersHistory);
        $this->assertSame($orderHistoryMock, $objectOrderHistory);
    }

    /**
     * testImport
     */
    public function testImport()
    {
        $orderJson = file_get_contents($this->resourcePath.'Order.json');
        $object = json_decode($orderJson);
        $object = $object->user;
        $user = new User();
        $user->import($object);
        $this->assertEquals($object, json_decode(json_encode($user->export())));
    }
}
