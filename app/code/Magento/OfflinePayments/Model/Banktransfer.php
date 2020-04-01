<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\OfflinePayments\Model;

/**
 * Bank Transfer payment method model
 *
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * @api
 * @since 100.0.2
 */
class Banktransfer extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_BANKTRANSFER_CODE = 'banktransfer';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_BANKTRANSFER_CODE;

    /**
     * Bank Transfer payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \Magento\OfflinePayments\Block\Form\Banktransfer::class;

    /**
     * Instructions block path
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
        
        if($shippingMethod === NULL && ($quote !== NULL)){
            $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        }

        if (in_array(strtolower($shippingMethod), $this->_excludePaymentMethods))
            return false;

        return true;
    }
}