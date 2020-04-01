<?php

namespace Ranosys\Sales\Api\Data;

/**
 * @api
 */
interface OrderSuccessDetailInterface {
    
    /**#@+
     * Constants defined for keys of the data array.
     */
    const SHIPPING_METHOD = 'shipping_method';
    const GRAND_TOTAL = 'grand_total';
    const PAYMENT_METHOD = 'payment_method';
    const VIRTUAL_ACCOUNT_NUMBER = 'virtual_account_number';  
    const ORDER_ID = 'order_id';  
    const BASE_CURRENCY_CODE = 'base_currency_code';  
    const STATUS_LABEL = 'status_label';  
    const STATUS_CODE = 'status_code';  
    const ORDER_STATE = 'order_state';  
    
    
     /**
     * Get order id
     *
     * @return string
     */
    public function getOrderId();
    /**
     * Set order id
     * 
     * @param string $order_id
     * @return $this
     */
    public function setOrderId($order_id);
    
    /**
     * Get shipping method
     *
     * @return string
     */
    public function getShippingMethod();
    
    /**
     * Set shipping method
     * 
     * @param string $shipping_method
     * @return $this
     */
    public function setShippingMethod($shipping_method);

    /**
     * Get grand total
     *
     * @return string
     */
    public function getGrandTotal();
    
    /**
     * Set grand total
     * 
     * @param string $grand_total
     * @return $this
     */
    public function setGrandTotal($grand_total);
    
    /**
     * Get payment method
     *
     * @return string
     */
    public function getPaymentMethod();
   
    /**
     * Set payment method
     * 
     * @param string $payment_method
     * @return $this
     */
    public function setPaymentMethod($payment_method);
    
    /**
     * Get virtual account number
     *
     * @return string
     */
    public function getVirtualAccountNumber();
   
    /**
     * Set virtual account number
     * 
     * @param string $virtual_account_number
     * @return $this
     */
    public function setVirtualAccountNumber($virtual_account_number);
    
    /**
     * Get base currency code
     *
     * @return string
     */
    public function getBaseCurrencyCode();
    
    /**
     * Set base currency code
     * 
     * @param string $base_currency_code
     * @return $this
     */
    public function setBaseCurrencyCode($base_currency_code);
   
    /**
     * Get status code
     *
     * @return string
     */
    public function getStatusCode();
   
    /**
     * Set status code
     * 
     * @param string $status_code
     * @return $this
     */
    public function setStatusCode($status_code);
   
    /**
     * Get status label
     *
     * @return string
     */
    public function getStatusLabel();
    
    /**
     * Set status label
     * 
     * @param string $status_label
     * @return $this
     */
    public function setStatusLabel($status_label);
    
    /**
     * Get  order state
     *
     * @return string
     */
    public function getOrderState();
   
    /**
     * Set order state
     * 
     * @param string $order_state
     * @return $this
     */
    public function setOrderState($order_state);
}
