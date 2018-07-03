<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Refund
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class Refund extends AbstractModel
{
    /**
     * @var string $id This is the refund Id
     */
    protected $id;

    /**
     * @var int $promotedAmount In cents the amount of the refund that is considered as promoted
     */
    protected $promotedAmount;

    /**
     * @var \DateTime $refundedAt Datetime of the refund moment
     */
    protected $refundedAt;

    /**
     * @var int $totalAmount Total amount for the refund.
     */
    protected $totalAmount;

    /**
     * Refund constructor.
     */
    public function __construct()
    {
        $this->promotedAmount = 0;
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
     * @return Refund
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPromotedAmount()
    {
        return $this->promotedAmount;
    }

    /**
     * @param $promotedAmount
     *
     * @return $this
     * @throws ValidationException
     */
    public function setPromotedAmount($promotedAmount)
    {
        if ($promotedAmount >= 0) {
            $this->promotedAmount = $promotedAmount;
            return $this;
        }

        throw new ValidationException('Promoted amount has to be a natural number');
    }

    /**
     * @return \DateTime
     */
    public function getRefundedAt()
    {
        return $this->refundedAt;
    }

    /**
     * @param \DateTime $refundedAt
     *
     * @return $this
     */
    public function setRefundedAt(\DateTime $refundedAt)
    {
        $this->refundedAt = $refundedAt;

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
        if ($this->getTotalAmount() < $this->getPromotedAmount()) {
            throw new ValidationException('Promoted amount can not be higher than total amount');
        }

        return true;
    }
}
