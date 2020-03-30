<?php


/**
 * PLEASE SET YOUR PUBLIC KEY AND PRIVATE KEY
 */
//const PK = 'tk_45fe164c88c646a8a993d755';   //Set your public key
//const PRIK = '4efe623438e14e3d'; //Set your public key

const PUBLIC_KEY = 'tk_45fe164c88c646a8a993d755';   //Set your public key
const PRIVATE_KEY = '4efe623438e14e3d';             //Set your public key


/**
 * @return \Pagantis\OrdersApiClient\Client
 * @throws \Httpful\Exception\ConnectionErrorException
 * @throws \Pagantis\OrdersApiClient\Exception\ClientException
 * @throws Exception
 */
function getOrderApiClient()
{
    $publicKey = PUBLIC_KEY;
    $privateKey = PRIVATE_KEY;
    if ($publicKey == '' || $privateKey == '') {
        die();
    }
    $orderClient = new \Pagantis\OrdersApiClient\Client($publicKey, $privateKey);
    return $orderClient;
}

/**
 * @param $message
 * @param $fileName
 * @param $withDate bool
 * @return false|int
 */
function writeLog($message, $fileName, $withDate)
{
    $dateFormat = '[D M j G:i:s o]';
    if ($withDate) {
        $date = getCurrentDate($dateFormat);
        return file_put_contents('../pagantis.log', $date . " " . jsonEncoded($fileName) . " $message.\n", FILE_APPEND);
    }
    return file_put_contents('../pagantis.log', " " . jsonEncoded($fileName) . " $message.\n", FILE_APPEND);
}

/**
 * @param $dateFormat
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
 * @return false|string
 */
function jsonEncoded($object)
{
    return json_encode($object, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}


/**
 * @param $jsonString
 * @return mixed
 */
function jsonToArray($jsonString)
{
    $myArray = json_decode($jsonString, true);
    return $myArray;
}


/**
 * @return bool
 */
function areKeysSet()
{
    if (PUBLIC_KEY == '' || PRIVATE_KEY == '') {
        return false;
    }
    return true;
}

/**
 *
 */
function setCurrentPageInSession()
{
    $url = basename($_SERVER['PHP_SELF']);
    return $_SESSION['current_page'] = $url;
}

/**
 * @return mixed
 */
function getPreviousPageFromSession()
{
    $previous_page = $_SESSION['current_page'];
    return $previous_page;
}

/**
 * @return string
 */
function showKeysMissingErrorMessage()
{
    $keysNotSetErrorMessage = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<i class="fas fa-exclamation-triangle"></i>
  Please set the public and private key in examples/utils/Helpers.php
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    return $keysNotSetErrorMessage;
}

/**
 * @return string
 */

function showHomeButton()
{
    $button = '<button type="button" class="btn btn-link" id="homeRedirect" onclick="redirectHome()">Home</button>';
    return $button;
}


function dot($array, $prepend = '')
{
    $results = array();

    foreach ($array as $key => $value) {
        if (is_array($value) && !empty($value)) {
            $results = array_merge($results, dot($value, $prepend . $key . '.'));
        } else {
            $results[$prepend . $key] = $value;
        }
    }

    return $results;
}