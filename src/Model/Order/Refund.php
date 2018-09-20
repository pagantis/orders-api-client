<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

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
     * @var \DateTime $createdAt Datetime of the refund moment
     */
    protected $createdAt;

    /**
     * @var int $totalAmount Total amount for the refund.
     */
    protected $totalAmount;

    /**
     * @var int $refundedMerchantCost, the cost applied to the merchant.
     */
    protected $refundedMerchantCost;

    /**
     * @var int $paymentProcessorCost, the cost generated by the payment processor.
     */
    protected $paymentProcessorCost;

    /**
     * Refund constructor.
     */
    public function __construct()
    {
        $this->promotedAmount = 0;
        $this->paymentProcessorCost = 0;
        $this->refundedMerchantCost = 0;
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
     */
    public function setPromotedAmount($promotedAmount)
    {
        $this->promotedAmount = $promotedAmount;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

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
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return int
     */
    public function getRefundedMerchantCost()
    {
        return $this->refundedMerchantCost;
    }

    /**
     * @param int $refundedMerchantCost
     *
     * @return Refund
     */
    public function setRefundedMerchantCost($refundedMerchantCost)
    {
        $this->refundedMerchantCost = $refundedMerchantCost;

        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentProcessorCost()
    {
        return $this->paymentProcessorCost;
    }

    /**
     * @param int $paymentProcessorCost
     *
     * @return Refund
     */
    public function setPaymentProcessorCost($paymentProcessorCost)
    {
        $this->paymentProcessorCost = $paymentProcessorCost;

        return $this;
    }
}
