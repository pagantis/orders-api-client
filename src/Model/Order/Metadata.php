<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Metadata
 * @package PagaMasTarde\OrdersApiClient\Model\Order
 */
class Metadata extends AbstractModel
{
    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws ValidationException
     */
    public function addMetadata($key, $value)
    {
        if (is_string($key) && is_string($value)) {
            $this->{$key} = $value;
            return $this;
        }

        throw new ValidationException('Key and value have to be string');
    }

    /**
     * @param $object
     *
     * @throws ValidationException
     */
    public function import($object)
    {
        foreach ($object as $key => $value) {
            $this->addMetadata($key, $value);
        }
    }

    /**
     * Metadata will not use Str::ToCamelCase because we respect the merchant naming convention.
     *
     * @param bool $validation
     *
     * @return array
     */
    public function export($validation = true)
    {
        if ($validation) {
            $this->validate();
        }
        $result = array();
        foreach ($this as $key => $value) {
            if ($value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Nothing to validate.
     *
     * @return bool|true
     */
    public function validate()
    {
        return true;
    }
}
