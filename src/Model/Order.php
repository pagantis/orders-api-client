<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Model\Order\ActionUrls;
use PagaMasTarde\OrdersApiClient\Model\Order\Configuration;
use PagaMasTarde\OrdersApiClient\Model\Order\Metadata;
use PagaMasTarde\OrdersApiClient\Model\Order\Refund;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;
use PagaMasTarde\OrdersApiClient\Model\Order\Upsell;
use PagaMasTarde\OrdersApiClient\Model\Order\User;

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
     * @var string $gracePeriodMonth
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
     * Order constructor.
     */
    public function __construct()
    {
        $this->actionUrls = new ActionUrls();
        $this->configuration = new Configuration();
        $this->metadata = new Metadata();
        $this->refunds = array();
        $this->shoppingCart = new ShoppingCart();
        $this->upsells = array();
        $this->user = new User();
        $this->createdAt = new \DateTime();
        $this->confirmedAt = new \DateTime();
        $this->expiresAt = new \DateTime();
    }

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
     * @param Refund $refund
     *
     * @return $this
     */
    public function addRefund(Refund $refund)
    {
        $this->refunds[] = $refund;

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
     * @param Upsell $upsell
     *
     * @return $this
     */
    public function addUpsell(Upsell $upsell)
    {
        $this->upsells[] = $upsell;

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

    /**
     * @param \stdClass $object
     */
    public function import($object)
    {
        parent::import($object);
        $properties = get_object_vars($object);
        foreach ($properties as $key => $value) {
            if (is_array($value)) {
                if (is_array($this->{$key}) && $key == 'refunds') {
                    $this->refunds = array();
                    foreach ($value as $refund) {
                        $refundObject = new Refund();
                        $refundObject->import($refund);
                        $this->addRefund($refundObject);
                    }
                }
                if (is_array($this->{$key}) && $key == 'upsells') {
                    $this->upsells = array();
                    foreach ($value as $refund) {
                        $upsellObject = new Upsell();
                        $upsellObject->import($refund);
                        $this->addUpsell($upsellObject);
                    }
                }
            }
        }
    }

    /**
     * Check setters and validate the mandatory fields:
     * User, Configuration and Shopping Cart
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();
        foreach ($this as $key => $value) {
            if ($value instanceof AbstractModel) {
                $value->validate();
            }
        }

        return true;
    }
}
