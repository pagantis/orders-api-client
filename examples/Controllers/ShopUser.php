<?php

namespace Examples\OrdersApiClient\Controllers;

use Examples\OrdersApiClient\utils\Log;
use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\User\Address;

class ShopUser extends AbstractModel
{

    public $userAddress;

    public function __construct()
    {
        $this->userAddress = new Address();

    }

    public function setAddressInfo()
    {

        $this->userAddress
            ->setZipCode('28031')
            ->setFullName('María Sanchez Escudero')
            ->setCountryCode('ES')
            ->setCity('Madrid')
            ->setAddress('Paseo de la Castellana, 95')
            ->setDni('59661738Z')
            ->setNationalId('59661738Z')
            ->setFixPhone('911231234')
            ->setMobilePhone('600123123');
        return $this->userAddress;

    }
}