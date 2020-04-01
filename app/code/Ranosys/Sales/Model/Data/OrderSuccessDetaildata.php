<?php

namespace Ranosys\Sales\Model\Data;

class OrderSuccessDetaildata extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Sales\Api\Data\OrderSuccessDetailInterface {
    
      /**
     * {@inheritdoc}
     */
    public function getOrderId() {
        return $this->_getData(self::ORDER_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOrderId($order_id) {
        return $this->setData(self::ORDER_ID, $order_id);
    }
      
    /**
     * {@inheritdoc}
     */
    public function getShippingMethod() {
        return $this->_getData(self::SHIPPING_METHOD);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setShippingMethod($shipping_method) {
        return $this->setData(self::SHIPPING_METHOD, $shipping_method);
    }
  
    /**
     * {@inheritdoc}
     */
    public function getGrandTotal() {
        return $this->_getData(self::GRAND_TOTAL);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setGrandTotal($grand_total) {
        return $this->setData(self::GRAND_TOTAL, $grand_total);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPaymentMethod() {
        return $this->_getData(self::PAYMENT_METHOD);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPaymentMethod($payment_method) {
        return $this->setData(self::PAYMENT_METHOD, $payment_method);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVirtualAccountNumber() {
        return $this->_getData(self::VIRTUAL_ACCOUNT_NUMBER);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVirtualAccountNumber($virtual_account_number) {
        return $this->setData(self::VIRTUAL_ACCOUNT_NUMBER, $virtual_account_number);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBaseCurrencyCode() {
        return $this->_getData(self::BASE_CURRENCY_CODE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBaseCurrencyCode($base_currency_code) {
        return $this->setData(self::BASE_CURRENCY_CODE, $base_currency_code);
    }
    /**
     * {@inheritdoc}
     */
    public function getStatusCode() {
        return $this->_getData(self::STATUS_CODE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStatusCode($status_code) {
        return $this->setData(self::STATUS_CODE, $status_code);
    }
    /**
     * {@inheritdoc}
     */
    public function getStatusLabel() {
        return $this->_getData(self::STATUS_LABEL);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStatusLabel($status_label) {
        return $this->setData(self::STATUS_LABEL, $status_label);
    }
    /**
     * {@inheritdoc}
     */
    public function getOrderState() {
        return $this->_getData(self::ORDER_STATE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOrderState($order_state) {
        return $this->setData(self::ORDER_STATE, $order_state);
    }
}
