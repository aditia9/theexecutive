<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/10/18
 * Time: 8:49 PM
 */
namespace Hypework\Payment\Model\Payment;

class Ipay88Cc extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'ipay88_cc'; 
    protected $_excludePaymentMethods = ['lion_lion'];

    /**
     * Payment availability condition
     * @param  \Magento\Quote\Api\Data\CartInterface|null $quote [description]
     * @return boolean                                           [description]
     */
	public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();

        if (in_array(strtolower($shippingMethod), $this->_excludePaymentMethods))
            return false;

    	return true;
    }
}