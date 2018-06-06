<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\UpsellException;

/**
 * Class Upsell
 * @package PagaMasTarde\OrdersApiClient\Model
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
     * @param int $totalAmount
     *
     * @return Upsell
     *
     * @throws UpsellException
     */
    public function setTotalAmount($totalAmount)
    {
        if ($totalAmount >= 1 && is_int($totalAmount)) {
            $this->totalAmount = $totalAmount;
            return $this;
        }

        throw new UpsellException('Total amount has to be a non zero natural number');
    }
}
