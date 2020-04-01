<?php

namespace Ranosys\Sales\Model;

use \Magento\Framework\Api\AttributeValueFactory;

class MyOrdersdata extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Ranosys\Sales\Api\Data\MyOrdersdataInterface
{

    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    /**
     * Get order Id
     * @return string $orderId
     */
    public function getId() {
        return $this->_get(self::ID);
    }
    /**
     * Set order Id
     *
     * @param string $orderId
     * @return $this
     */
    public function setId($orderId) {
        return $this->setData(self::ID, $orderId);
    }
    /**
     * Get order amount
     * @return string $orderPrice
     */
    public function getAmount() {
        return $this->_get(self::AMOUNT);
    }
    /**
     * Set order amount
     *
     * @param string $orderPrice
     * @return $this
     */
    public function setAmount($orderPrice) {
        return $this->setData(self::AMOUNT, $orderPrice);
    }
    /**
     * Get order status
     * @return string $orderStatus
     */
    public function getStatus() {
        return $this->_get(self::STATUS);
    }
    /**
     * Set order status
     *
     * @param string $orderStatus
     * @return $this
     */
    public function setStatus($orderStatus) {
        return $this->setData(self::STATUS, $orderStatus);
    }
    /**
     * Get order Date
     * @return string $orderDate
     */
    public function getDate() {
        return $this->_get(self::DATE);
    }
    /**
     * Set order date
     *
     * @param string $orderDate
     * @return $this
     */
    public function setDate($orderDate) {
        return $this->setData(self::DATE, $orderDate);
    }
         
    /**
     * Get order Image
     * @return string $orderImage
     */
    public function getImage() {
        return $this->_get(self::IMAGE);
    }
    /**
     * Set order image
     *
     * @param string $orderImage
     * @return $this
     */
    public function setImage($orderImage) {
        return $this->setData(self::IMAGE, $orderImage);
    }
    
    /**
     * Get refundable status
     * @return boolean $refundableStatus
     */
    public function getIsRefundable() {
        return $this->_get(self::REFUNDABLE);
    }
    
    /**
     * Set refundable status
     *
     * @param boolean $refundable
     * @return $this
     */
    public function setIsRefundable($refundable) {
        return $this->setData(self::REFUNDABLE, $refundable);
    }
    
    /**
     * Get payment method
     * @return string $paymentMethod
     */
    public function getPaymentMethod() {
        return $this->_get(self::PAYMENT_METHOD);
    }
    
    /**
     * Set payment method
     *
     * @param string $paymentMethod
     * @return $this
     */
    public function setPaymentMethod($paymentMethod) {
        return $this->setData(self::PAYMENT_METHOD, $paymentMethod);
    }
    

}
