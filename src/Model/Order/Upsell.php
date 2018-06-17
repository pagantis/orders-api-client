<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Upsell
 * @package PagaMasTarde\OrdersApiClient\Model\Order
 */
class Upsell extends AbstractModel
{
    /**
     * @var string $id This is the refund Id
     */
    protected $id;

    /**
     * @var \DateTime $refundedAt Datetime of the upsell moment
     */
    protected $upsellAt;

    /**
     * @var int $totalAmount Total amount for the upsell.
     */
    protected $totalAmount;

    /**
     * Upsell constructor.
     */
    public function __construct()
    {
        $this->upsellAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Upsell
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpsellAt()
    {
        return $this->upsellAt;
    }

    /**
     * @param \DateTime $upsellAt
     *
     * @return Upsell
     */
    public function setUpsellAt(\DateTime $upsellAt)
    {
        $this->upsellAt = $upsellAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param $totalAmount
     *
     * @return $this
     * @throws ValidationException
     */
    public function setTotalAmount($totalAmount)
    {
        if ($totalAmount >= 1) {
            $this->totalAmount = $totalAmount;
            return $this;
        }

        throw new ValidationException('Total amount has to be a non zero natural number');
    }

    /**
     * @return bool|true
     * @throws ValidationException
     */
    public function validate()
    {
        $this->triggerSetters();

        if (!$this->totalAmount) {
            throw new ValidationException('Total amount can not be empty');
        }

        return true;
    }
}
