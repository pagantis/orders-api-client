<?php


/**
 * @param $message
 * @param $fileName
 * @param $withDate bool
 *
 * @return false|int
 */
function writeLog(
    $message,
    $fileName,
    $withDate
) {
    $dateFormat = '[D M j G:i:s o]';
    if ($withDate) {
        $date = getCurrentDate($dateFormat);
        return file_put_contents('logs/pagantis.log', $date . " " . jsonEncoded($fileName)
            . " $message.\n",
            FILE_APPEND);
    }
    return file_put_contents('logs/pagantis.log', " " . jsonEncoded($fileName) . " $message.\n",
        FILE_APPEND);
}

/**
 * @param $dateFormat
 *
 * @return false|string
 */
function getCurrentDate($dateFormat)
{
    // TODO https://www.php.net/manual/en/function.date-default-timezone-set.php
    $currentDate = date($dateFormat);
    return $currentDate;
}

/**
 * @param $object
 *
 * @return false|string
 */
function jsonEncoded($object)
{
    return json_encode($object,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
}


/**
 * @param $jsonString
 *
 * @return mixed
 */
function jsonToArray($jsonString)
{
    $myArray = json_decode($jsonString, true);
    return $myArray;
}

/**
 * @param array $array
 * @param       $key
 *
 * @return mixed
 */
function getValueOfKey(array $array, $key)
{
    if (!is_string($key)) {
        new \Exception($key . ' must be a string' . gettype($key)
            . ' was provided');
    }
    $value = $array[$key];
    return $value;
}

/**
 * @param $authorizedOrders
 *
 * @return bool
 */
function isAuthorizedOrderCountAboveZero($authorizedOrders)
{

    if (count($authorizedOrders) >= 1) {
        return true;
    }
    return false;
}