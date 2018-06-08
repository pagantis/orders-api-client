<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use Exceptions\Data\ValidationException;
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
     * @param int $promotedAmount
     *
     * @return Refund
     */
    public function setPromotedAmount($promotedAmount)
    {
        if ($promotedAmount >= 0 && is_int($promotedAmount)) {
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
     * @param int $totalAmount
     *
     * @return Refund
     */
    public function setTotalAmount($totalAmount)
    {
        if ($totalAmount >= 1 && is_int($totalAmount)) {
            $this->totalAmount = $totalAmount;
            return $this;
        }

        throw new ValidationException('Total amount has to be a non zero natural number');
    }

    /**
     * Validation occurs on setters.
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();
        if (!$this->getTotalAmount() < $this->getPromotedAmount()) {
            return true;
        }

        throw new ValidationException('Promoted amount can not be higher than total amount');
    }
}
