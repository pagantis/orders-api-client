<?php

namespace PagaMasTarde\OrdersApiClient\Model;

/**
 * Class Order
 *
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class Order extends AbstractModel
{
    /**
     * @var ActionUrls $actionUrls
     */
    protected $actionUrls;

    /**
     * @var string $apiVersion
     */
    protected $apiVersion;

    /**
     * @var Configuration $configuration
     */
    protected $configuration;

    /**
     * @var \DateTime $confirmedAt
     */
    protected $confirmedAt;

    /**
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    /**
     * @var \DateTime $expiresAt
     */
    protected $expiresAt;

    /**
     * @var string $gracePeriod
     */
    protected $gracePeriod;

    /**
     * @var string$gracePeriodMonth
     */
    protected $gracePeriodMonth;

    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var Metadata $metadata
     */
    protected $metadata;

    /**
     * @var Refund[] $refunds
     */
    protected $refunds;

    /**
     * @var ShoppingCart $shoppingCart
     */
    protected $shoppingCart;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var Upsell[] $upsells
     */
    protected $upsells;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @return ActionUrls
     */
    public function getActionUrls()
    {
        return $this->actionUrls;
    }

    /**
     * @param ActionUrls $actionUrls
     *
     * @return Order
     */
    public function setActionUrls($actionUrls)
    {
        $this->actionUrls = $actionUrls;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiVersion
     *
     * @return Order
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     *
     * @return Order
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmedAt()
    {
        return $this->confirmedAt;
    }

    /**
     * @param \DateTime $confirmedAt
     *
     * @return Order
     */
    public function setConfirmedAt($confirmedAt)
    {
        $this->confirmedAt = $confirmedAt;

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
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $expiresAt
     *
     * @return Order
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getGracePeriod()
    {
        return $this->gracePeriod;
    }

    /**
     * @param string $gracePeriod
     *
     * @return Order
     */
    public function setGracePeriod($gracePeriod)
    {
        $this->gracePeriod = $gracePeriod;

        return $this;
    }

    /**
     * @return string
     */
    public function getGracePeriodMonth()
    {
        return $this->gracePeriodMonth;
    }

    /**
     * @param string $gracePeriodMonth
     *
     * @return Order
     */
    public function setGracePeriodMonth($gracePeriodMonth)
    {
        $this->gracePeriodMonth = $gracePeriodMonth;

        return $this;
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
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     *
     * @return Order
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return Refund[]
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     * @param Refund[] $refunds
     *
     * @return Order
     */
    public function setRefunds($refunds)
    {
        $this->refunds = $refunds;

        return $this;
    }

    /**
     * @return ShoppingCart
     */
    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    /**
     * @param ShoppingCart $shoppingCart
     *
     * @return Order
     */
    public function setShoppingCart($shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Upsell[]
     */
    public function getUpsells()
    {
        return $this->upsells;
    }

    /**
     * @param Upsell[] $upsells
     *
     * @return Order
     */
    public function setUpsells($upsells)
    {
        $this->upsells = $upsells;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Order
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
