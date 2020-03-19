<?php


namespace Examples\OrdersApiClient\utils;


class Log
{
	/**
	 * Write log file
	 *
	 * @param $message
	 * @param bool $withDate
	 * @return false|int
	 */
	public static function write($message, $withDate = false)
	{
		$date = Helpers::getCurrentDate($dateFormat = "c");
		if (!$withDate) {
			return file_put_contents('pagantis.log', "$date $message.\n", FILE_APPEND);
		}
		return file_put_contents('pagantis.log', "$message.\n", FILE_APPEND);
	}
}