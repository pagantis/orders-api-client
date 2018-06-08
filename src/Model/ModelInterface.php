<?php

namespace PagaMasTarde\OrdersApiClient\Model;
use Exceptions\Data\IntegrityException;
use Exceptions\Data\ValidationException;

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
     * @throws IntegrityException
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
