<?php

namespace Ranosys\Sales\Api\Data;

/**
 * @api
 */
interface MyOrdersdataInterface {
    
    /**#@+
     * Constants defined for keys of the data array.
     */
    const ID = 'id';
    const AMOUNT = 'amount';
    const DATE = 'date';
    const STATUS = 'status';
    const IMAGE = 'image';
    const REFUNDABLE = 'refundable';  
    const PAYMENT_METHOD = 'paymentMethod';
    
    /**
     * Get order Id
     *
     * @return string
     */
    public function getId();
    /**
     * Set order Id
     * 
     * @param string $orderId
     * @return $this
     */
    public function setId($orderId);
    /**
     * Get order Amount
     *
     * @return string
     */
    public function getAmount();
    /**
     * Set order Amount
     * 
     * @param string $orderPrice
     * @return $this
     */
    public function setAmount($orderPrice);
    /**
     * Get order Status
     *
     * @return string
     */
    public function getStatus();
    /**
     * Set order Status
     * 
     * @param string $orderStatus
     * @return $this
     */
    public function setStatus($orderStatus);
    /**
     * Get order date
     *
     * @return string
     */
    public function getDate();
    /**
     * Set order date
     * 
     * @param string $orderDate
     * @return $this
     */
    public function setDate($orderDate);
    
    /**
     * Get order image
     *
     * @return string
     */
    public function getImage();
    /**
     * Set order image
     * 
     * @param string $orderImage
     * @return $this
     */
    public function setImage($orderImage);
    
    /**
     * Get refundable status
     *
     * @return boolean
     */
    public function getIsRefundable();
    /**
     * Set refundable status
     * 
     * @param boolean $refundable
     * @return $this
     */
    public function setIsRefundable($refundable);
    
    /**
     * Get payment method
     *
     * @return string
     */
    public function getPaymentMethod();
    /**
     * Set payment method
     * 
     * @param string $paymentMethod
     * @return $this
     */
    public function setPaymentMethod($paymentMethod);
}
