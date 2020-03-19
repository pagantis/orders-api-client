<?php


namespace Examples\OrdersApiClient\utils;


class Helpers
{
	public static function getCurrentDate($dateFormat)
	{
		$currentDate = date($dateFormat);
		return $currentDate;
	}

}