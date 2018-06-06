<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\MetadataException;

/**
 * Class Metadata
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class Metadata extends AbstractModel
{
    /**
     * @var array $metadata
     */
    protected $metadata;

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     *
     * @return Metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     *
     * @throws MetadataException
     */
    public function addMetadata($key, $value)
    {
        if (is_string($key) && is_string($value)) {
            $this->metadata[$key] = $value;

            return $this;
        }

        throw new MetadataException('Key and value have to be string');
    }
}
