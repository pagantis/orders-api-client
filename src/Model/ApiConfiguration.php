<?php

namespace PagaMasTarde\OrdersApiClient\Model;
use http\Url;
use PagaMasTarde\OrdersApiClient\Exception\UrlException;

/**
 * Class ApiConfiguration
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class ApiConfiguration extends AbstractModel
{
    /**
     * Base URL for API calls
     */
    const BASE_URI = 'http://docker-ext-stg.digitalorigin.com:20010';

    /**
     * Base URL for API calls
     */
    const SANDBOX_BASE_URI = 'http://docker-ext-stg.digitalorigin.com:20010';

    /**
     * Private key for API calls
     *
     * @var string $privateKey
     */
    protected $privateKey;

    /**
     * Public key for API calls
     *
     * @var string $publicKey
     */
    protected $publicKey;

    /**
     * SandBox url should be specified here
     *
     * @var string $baseUri
     */
    protected $baseUri;

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     *
     * @return ApiConfiguration
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     *
     * @return ApiConfiguration
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param $baseUri
     *
     * @return $this
     *
     * @throws UrlException
     */
    public function setBaseUri($baseUri)
    {
        if (Urls::urlValidate($baseUri)) {
            $this->baseUri = $baseUri;
            return $this;
        }

        throw new UrlException('Invalid base URL on the ApiConfiguration setter');
    }
}
