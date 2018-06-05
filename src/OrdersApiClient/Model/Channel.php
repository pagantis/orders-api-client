<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\TypeException;

/**
 * Class Channel
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class Channel extends AbstractModel
{
    /**
     * Online type, for sales in the website
     */
    const ONLINE = 'online';

    /**
     * In store type, for sales in a physical store
     */
    const INSTORE = 'instore';

    /**
     * Phonesale type, for sales made on the phone
     */
    const PHONESALE = 'phonesale';

    /**
     * @var string type
     */
    protected $type;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     * @throws TypeException
     */
    public function setType($type)
    {
        $validTypes = array(
            self::ONLINE,
            self::INSTORE,
            self::PHONESALE,
        );

        if (in_array($type, $validTypes)) {
            $this->type = $type;
            return $this;
        }

        throw new TypeException('Invalid type chosen');
    }
}
