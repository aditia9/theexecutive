<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/22/18
 * Time: 1:56 AM
 */

namespace Hypework\Payment\Model\Payment;

class PrismalinkVabca extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'prismalink_vabca';
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