<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\User;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class OrderHistory
 * @package PagaMasTarde\OrdersApiClient\Model\Order\User
 */
class OrderHistory extends AbstractModel
{
    /**
     * @var int $amount
     */
    protected $amount;

    /**
     * @var \DateTime $date
     */
    protected $date;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return $this
     * @throws ValidationException
     */
    public function setAmount($amount)
    {
        if ($amount >= 1) {
            $this->amount = $amount;
            return $this;
        }

        throw new ValidationException('Amount has to be non zero natural number');
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return OrderHistory
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Just trigger the setters in order to validate amount and the Datetime
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        return true;
    }
}
