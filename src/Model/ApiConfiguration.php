<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Urls;

/**
 * Class ApiConfiguration
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class ApiConfiguration extends AbstractModel
{
    /**
     * Base URL for API calls
     */
    const BASE_URI = 'https://api.pagamastarde.com/v2';

    /**
     * Base URL for API calls
     */
    const SANDBOX_BASE_URI = 'https://api-stg.pagamastarde.com/v2';

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
     * @throws ValidationException
     */
    public function setBaseUri($baseUri)
    {
        if (Urls::urlValidate($baseUri)) {
            $this->baseUri = $baseUri;
            return $this;
        }

        throw new ValidationException('Invalid base URL on the ApiConfiguration setter');
    }

    /**
     * @return bool|true
     * @throws ValidationException
     */
    public function validate()
    {
        if (empty($this->publicKey) || empty($this->privateKey)) {
            throw new ValidationException('Public Key and Private Key can not be empty');
        }
        if (!Urls::urlValidate($this->getBaseUri())) {
            throw new ValidationException('Invalid Base URL');
        }

        return true;
    }
}
