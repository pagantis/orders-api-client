<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Channel
 * @package PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class Channel extends AbstractModel
{
    /**
     * Online type, for sales in the website
     */
    const ONLINE = 'ONLINE';

    /**
     * In store type, for sales in a physical store
     */
    const INSTORE = 'INSTORE';

    /**
     * Phonesale type, for sales made on the phone
     */
    const PHONESALE = 'PHONESALE';

    /**
     * @var string type
     */
    protected $type;

    /**
     * @var string $assistedSale
     */
    protected $assistedSale;

    /**
     * @return string
     */
    public function getAssistedSale()
    {
        return $this->assistedSale;
    }

    /**
     * @param string $assistedSale
     *
     * @return Channel
     */
    public function setAssistedSale($assistedSale)
    {
        $this->assistedSale = $assistedSale;

        return $this;
    }

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

        throw new ValidationException('Set type from Channel::class constants');
    }
}
