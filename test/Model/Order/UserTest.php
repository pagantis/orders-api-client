<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\Order\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order
 */
class UserTest extends TestCase
{
    /**
     * Fake DNI generated
     */
    const FAKE_DNI = '68178726X';

    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $user = new User();
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\User\Address',
            $user->getAddress()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\User\Address',
            $user->getBillingAddress()
        );
        $this->assertInstanceOf(
            'PagaMasTarde\OrdersApiClient\Model\Order\User\Address',
            $user->getShippingAddress()
        );
        $this->assertTrue(is_array($user->getOrderHistory()));
    }

    /**
     * testSetDateOfBirth
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetDateOfBirth()
    {
        $today = date('Y-m-d');
        $beforeFiftyYears = date('Y-m-d', strtotime('-18 years'));
        $grandFather = date('Y-m-d', strtotime('-50 years'));

        $user = new User();
        $user->setDateOfBirth(null);
        $this->assertNull($user->getDateOfBirth());

        $user->setDateOfBirth($beforeFiftyYears);
        $this->assertSame($beforeFiftyYears, $user->getDateOfBirth());

        $user->setDateOfBirth($grandFather);
        $this->assertSame($grandFather, $user->getDateOfBirth());

        //Younger than 18 will not pass test
        $user->setDateOfBirth($today);
    }

    /**
     * testSetDni
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetDni()
    {
        $faker = Factory::create();
        $user = new User();
        $user->setDni(self::FAKE_DNI);
        $this->assertSame(self::FAKE_DNI, $user->getDni());
        $user->setDni($faker->name);
    }

    /**
     * Test SetEmail
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetEmail()
    {
        $faker = Factory::create();
        $user = new User();
        $email = $faker->email;
        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
        $user->setEmail($faker->name);
    }

    /**
     * testSetFullName
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetFullName()
    {
        $faker = Factory::create();
        $user = new User();
        $fullName = $faker->name . ' ' . $faker->lastName;
        $user->setFullName($fullName);
        $user->setFullName($fullName);
        $this->assertSame($fullName, $user->getFullName());
        $user->setFullName(null);
    }

    /**
     * testAddOrderHistory
     */
    public function testAddOrderHistory()
    {
        $user = new User();
        $orderHistoryMock = $this->getMock(
            'PagaMasTarde\OrdersApiClient\Model\Order\User\OrderHistory'
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
        $orderJson = file_get_contents('test/Resources/Order.json');
        $object = json_decode($orderJson);
        $object = $object->user;
        $user = new User();
        $user->import($object);
        $this->assertEquals($object, json_decode(json_encode($user->export())));
    }

    /**
     * testValidate
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $user = new User();

        //test AbstractModel calls validate
        $address = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\User\Address');
        $address->expects($this->atLeastOnce())->method('validate');

        //test OrderHistory calls validate
        $orderHistory = $this->getMock('PagaMasTarde\OrdersApiClient\Model\Order\User\OrderHistory');
        $orderHistory->expects($this->atLeastOnce())->method('validate');

        $user
            ->setAddress($address)
            ->addOrderHistory($orderHistory)
        ;

        try {
            $user->validate();
        } catch (\Exception $exception) {
            //FullName and Email Cannot be null
            $this->assertTrue(true);
        }

        $user
            ->setFullName($faker->name)
            ->setEmail($faker->email)
        ;
        $this->assertTrue($user->validate());
    }
}
