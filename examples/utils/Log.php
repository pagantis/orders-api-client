<?php


namespace Examples\OrdersApiClient\utils;


class Log
{
    /**
     * Write log file
     *
     * @param string $message
     * @param string $dateFormat
     * @param bool   $withDate
     *
     * @return false|int
     */
    public static function write(
        $message,
        $withDate
    ) {
        $dateFormat = '[D M j G:i:s o]';
        if ($withDate) {
            $date = Helpers::getCurrentDate($dateFormat);
            return file_put_contents('logs/pagantis.log', "$date  $message.\n",
                FILE_APPEND);
        }
        return file_put_contents('logs/pagantis.log', "$message.\n",
            FILE_APPEND);
    }
}