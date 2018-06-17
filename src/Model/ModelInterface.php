<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;

/**
 * Interface ModelInterface
 * @package PagaMasTarde\OrdersApiClient\Model
 */
interface ModelInterface
{
    /**
     * @param bool $validation Define if we should launch or not the validation
     *
     * @return array
     */
    public function export($validation = true);

    /**
     * @param \stdClass $object
     *
     * @throws ValidationException
     */
    public function import($object);

    /**
     * Each Model should implement their own validation methods
     *
     * @return true
     *
     * @throws ValidationException
     */
    public function validate();
}
