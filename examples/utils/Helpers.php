<?php


namespace Examples\OrdersApiClient\utils;


class Helpers
{
    public static function getCurrentDate($dateFormat)
    {
        $currentDate = date($dateFormat);
        return $currentDate;
    }

    public static function getPrettyJsonObject($object)
    {
        return json_encode($object,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    public static function getValueOfKey(array $array, $key)
    {
        if (!is_string($key)) {
            new \Exception($key . ' must be a string' . gettype($key)
                . ' was provided');
        }
        $value = $array[$key];
        return $value;
    }
}