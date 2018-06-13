<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;
use PagaMasTarde\OrdersApiClient\Model\Order\User\Address;
use PagaMasTarde\OrdersApiClient\Model\Order\User\OrderHistory;

/**
 * Class User
 * @package PagaMasTarde\OrdersApiClient\Model\Order
 */
class User extends AbstractModel
{
    /**
     * @var Address $address User address stored in merchant
     */
    protected $address;

    /**
     * @var Address $billingAddress Billing address for the order
     */
    protected $billingAddress;

    /**
     * @var string $dateOfBirth 'YYYY-MM-DD'
     */
    protected $dateOfBirth;

    /**
     * @var string $dni ID of the user
     */
    protected $dni;

    /**
     * @var string $email User email.
     */
    protected $email;

    /**
     * @var string $fixPhone Fix Phone of the user
     */
    protected $fixPhone;

    /**
     * @var string $fullName Full name of the user including 2 surnames.
     */
    protected $fullName;

    /**
     * @var string $mobilePhone Mobile phone of the user
     */
    protected $mobilePhone;

    /**
     * @var OrderHistory[] $orderHistory Array of previous orders
     */
    protected $orderHistory;

    /**
     * @var Address $shippingAddress Shipping address of the order.
     */
    protected $shippingAddress;

    /**
     * Not adding getters nor setters
     *
     * @deprecated
     */
    protected $truncated = false;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->address = new Address();
        $this->billingAddress = new Address();
        $this->shippingAddress = new Address();
        $this->orderHistory = array();
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return User
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     *
     * @return User
     */
    public function setBillingAddress(Address $billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $dateOfBirth
     *
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        if (null !== $dateOfBirth) {
            $dateOfBirthParsed = new \DateTime($dateOfBirth);
            $matureFilterDate = new \DateTime(date('Y-m-d', strtotime('-18 years')));
            if ($dateOfBirthParsed <= $matureFilterDate) {
                $this->dateOfBirth = $dateOfBirthParsed->format('Y-m-d');
                return $this;
            }
            throw new ValidationException('Date of birth error. User cant have less than 18 years');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     *
     * @return User
     */
    public function setDni($dni)
    {
        if (self::dniCheck($dni)) {
            $this->dni = $dni;
            return $this;
        }

        throw new ValidationException('Invalid DNI');
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return $this;
        }

        throw new ValidationException('Invalid User Email');
    }

    /**
     * @return string
     */
    public function getFixPhone()
    {
        return $this->fixPhone;
    }

    /**
     * @param string $fixPhone
     *
     * @return User
     */
    public function setFixPhone($fixPhone)
    {
        $this->fixPhone = $fixPhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        if (!empty($fullName)) {
            $this->fullName = $fullName;
            return $this;
        }

        throw new ValidationException('Full name cannot be empty');
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     *
     * @return User
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderHistory()
    {
        return $this->orderHistory;
    }

    /**
     * @param OrderHistory $orderHistory
     *
     * @return $this
     */
    public function addOrderHistory(OrderHistory $orderHistory)
    {
        $this->orderHistory[] = $orderHistory;

        return $this;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param Address $shippingAddress
     *
     * @return User
     */
    public function setShippingAddress(Address $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * @param $dni
     *
     * @return bool
     */
    public static function dniCheck($dni)
    {
        try {
            $letter = substr($dni, -1);
            $numbers = substr($dni, 0, -1);
            if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter &&
                strlen($letter) == 1 &&
                strlen($numbers) == 8
            ) {
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }

        return false;
    }

    /**
     * Overwrite import to fill ordersHistory correctly
     *
     * @param $object
     */
    public function import($object)
    {
        parent::import($object);
        $properties = get_object_vars($object);
        foreach ($properties as $key => $value) {
            if (is_array($value) && $key == 'order_history') {
                $this->orderHistory = array();
                foreach ($value as $orderHistory) {
                    $orderHistoryObject = new OrderHistory();
                    $orderHistoryObject->import($orderHistory);
                    $this->addOrderHistory($orderHistoryObject);
                }
            }
        }
    }

    /**
     * Validate setters, objects and full name + email can not be empty.
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        foreach ($this as $key => $value) {
            if ($value instanceof AbstractModel) {
                $value->validate();
            }
        }

        foreach ($this->orderHistory as $orderHistory) {
            $orderHistory->validate();
        }

        if (empty($this->fullName) || empty($this->email)) {
            throw new ValidationException('Full name and Email can not be null');
        }

        return true;
    }
}
