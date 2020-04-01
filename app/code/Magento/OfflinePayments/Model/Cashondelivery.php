<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\OfflinePayments\Model;

/**
 * Cash on delivery payment method model
 *
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * @api
 * @since 100.0.2
 */
class Cashondelivery extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_CASHONDELIVERY_CODE = 'cashondelivery';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_CASHONDELIVERY_CODE;

    /**
     * Cash On Delivery payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \Magento\OfflinePayments\Block\Form\Cashondelivery::class;

    /**
     * Info instructions block path
     *
     * @var string
     */
    protected $_infoBlockType = \Magento\Payment\Block\Info\Instructions::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    protected $_excludePaymentMethods = ['lion_lion'];

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions()
    {
        return trim($this->getConfigData('instructions'));
    }

    /**
     * Payment availability condition
     * @param  \Magento\Quote\Api\Data\CartInterface|null $quote [description]
     * @return boolean                                           [description]
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        $om =   \Magento\Framework\App\ObjectManager::getInstance();
        $shippingMethod = $om->get('Magento\Checkout\Model\Cart')->getQuote()
                             ->getShippingAddress()->getShippingMethod();
        
        /* 
         * resolve issue in logic
         * in case of apis shipping method is null, as cart session is not maintained,
         * so retreive shipping method from quote variable
         * although below logic can also be used for frontend, as quote is already passed in parameter so no need to load cart from object manager
         */
        if($shippingMethod === NULL && ($quote !== NULL)){
            $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        }

        if (!in_array(strtolower($shippingMethod), $this->_excludePaymentMethods))
            return false;

        return true;
    }
}