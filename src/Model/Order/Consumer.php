<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;

/**
 * Class Consumer
 * @package Pagantis\OrdersApiClient\Model\Order
 */
class Consumer extends AbstractModel
{
    /**
     * @var string $email Consumer email.
     */
    protected $email;

    /**
     * @var string $phoneNumber Fix Phone of the user
     */
    protected $phoneNumber;

    /**
     * @var string $givenNames Given Names The consumer’s first name and any middle names.
     */
    protected $givenNames;

    /**
     * @var string $surname Consumer Surname. The consumer’s last name.
     */
    protected $surname;

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
        //No dependencies
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Consumer
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getGivenNames()
    {
        return $this->givenNames;
    }

    /**
     * @param $givenNames
     *
     * @return $this
     */
    public function setGivenNames($givenNames)
    {
        $this->givenNames = $givenNames;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return Consumer
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }
}
