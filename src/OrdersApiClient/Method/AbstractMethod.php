<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Httpful\Mime;
use Httpful\Request;

/**
 * Class AbstractMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
abstract class AbstractMethod
{
    /**
     * BASE API URI
     */
    const BASE_URI = 'https://api.pagantis.com';

    /**
     * Public key for API calls
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Private key for API calls
     *
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AbstractService constructor.
     *
     * @param string $publicKey
     * @param string $privateKey
     * @param null   $baseUri
     */
    public function __construct($publicKey, $privateKey, $baseUri = null)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->baseUri = $baseUri === null ? self::BASE_URI : $baseUri;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return Request::init()
            ->sendsType(Mime::JSON)
            ->addHeader('Authorization', 'Bearer ' . $this->privateKey)
            ->expects(Mime::JSON)
            ->timeoutIn(2)
        ;
    }

    /**
     * @param $array
     *
     * @return string
     */
    protected function addGetParameters($array)
    {
        $query = http_build_query(array_filter($array));

        return empty($query) ? '' : '?' . $query;
    }
}
