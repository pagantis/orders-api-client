<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\User;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Address
 * @package PagaMasTarde\OrdersApiClient\Model\Order\User
 */
class Address extends AbstractModel
{
    /**
     * @var string $address the street name with the address details.
     */
    protected $address;

    /**
     * @var string $city the city name
     */
    protected $city;

    /**
     * @var string $countryCode the country code ES, FR, PT, IT
     */
    protected $countryCode;

    /**
     * @var string $fullName the full name of the user, including 2 sur names
     */
    protected $fullName;

    /**
     * @var string $zipCode $the zipCode of the address.
     */
    protected $zipCode;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return Address
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

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
     * @param $fullName
     *
     * @return $this
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
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Address has no validation
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        return true;
    }
}
