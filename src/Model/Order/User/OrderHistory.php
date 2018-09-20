<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\User;

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
     * @var string $date
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
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return OrderHistory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
