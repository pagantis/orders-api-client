<?php

namespace PagaMasTarde\OrdersApiClient\Model;

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
     */
    public function import($object);
}
