<?php

namespace Examples\Utils;

class FakeUser
{
	public static function getAddress(){
		$userAddress =  new \Pagantis\OrdersApiClient\Model\Order\User\Address();
		$userAddress
			->setZipCode('28031')
			->setFullName('María Sanchez Escudero')
			->setCountryCode('ES')
			->setCity('Madrid')
			->setAddress('Paseo de la Castellana, 95')
			->setDni('59661738Z')
			->setNationalId('59661738Z')
			->setFixPhone('911231234')
			->setMobilePhone('600123123');
		return $userAddress;
	}
}