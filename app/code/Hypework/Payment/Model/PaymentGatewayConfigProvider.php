<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/12/18
 * Time: 5:27 AM
 */
namespace Hypework\Payment\Model;

class PaymentGatewayConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    protected $scopeConfig;
    protected $_logger;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getRequestUrlIpay88()
    {
        if ($this->getEnvironmentIpay88() == 'Production-Production') {
            return 'https://payment.ipay88.co.id/epayment/entry.asp';
        } else {
            return 'https://sandbox.ipay88.co.id/epayment/entry.asp';
        }
    }

    public function getEnvironmentIpay88()
    {
        return $this->scopeConfig->getValue('payment/ipay88_cc/environment', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getConfig()
    {
        $config = [
            'payment' => [
                'ipay88_cc' => [
                    'is_token' => false,
                    'payment_title' => $this->scopeConfig->getValue('payment/ipay88_cc/title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'merchant_code' => $this->scopeConfig->getValue('payment/ipay88_cc/merchant_code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'merchant_key' => $this->scopeConfig->getValue('payment/ipay88_cc/merchant_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'instructions' => $this->scopeConfig->getValue('payment/ipay88_cc/instructions', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'environment' => $this->scopeConfig->getValue('payment/ipay88_cc/environment', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'request_url' => $this->getRequestUrlIpay88()
                ],
                'prismalink_vabca' => [
                    'is_token'      => false,
                    'payment_title' => $this->scopeConfig->getValue('payment/prismalink_vabca/title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'partner_id'    => $this->scopeConfig->getValue('payment/prismalink_vabca/partner_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'shared_key'    => $this->scopeConfig->getValue('payment/prismalink_vabca/shared_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'prefix_bin'    => $this->scopeConfig->getValue('payment/prismalink_vabca/prefix_bin', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'instructions'  => $this->scopeConfig->getValue('payment/prismalink_vabca/instructions', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                    'environment'   => $this->scopeConfig->getValue('payment/prismalink_vabca/environment', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                ]
            ]
        ];
        return $config;
    }
}