<?php

namespace Ranosys\Custom\Model;

use Ranosys\Custom\Api\ProductContentURLInterface;
use Magento\Framework\Exception\InputException;

/**
 * Implementation class of contract.
 */
class ProductContentURL implements ProductContentURLInterface
{

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Ranosys\Custom\Api\Data\ProductURLdataInterfaceFactory $dataFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->dataFactory = $dataFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Return array
     *
     * @api
     * @param
     * @return \Ranosys\Custom\Api\Data\ProductURLdataInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getContentURL() {
        
        $compositionandcare = $this->scopeConfig->getValue('staticcontent/general_tab3/composition_and_care', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $sizeguidline = $this->scopeConfig->getValue('staticcontent/general_tab3/size_guideline', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $shipping = $this->scopeConfig->getValue('staticcontent/general_tab3/shipping_page', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $returns = $this->scopeConfig->getValue('staticcontent/general_tab3/returns_page', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $buyingguidelines = $this->scopeConfig->getValue('staticcontent/general_tab3/buying_guideline', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $contactus = $this->scopeConfig->getValue('staticcontent/general_tab3/contact_us', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        
        $compositionUrl = $this->storeManager->getStore()->getUrl($compositionandcare);
        $sizeguideUrl = $this->storeManager->getStore()->getUrl($sizeguidline);
        $shippingUrl = $this->storeManager->getStore()->getUrl($shipping);
        $returnsUrl = $this->storeManager->getStore()->getUrl($returns);
        $buyguideUrl = $this->storeManager->getStore()->getUrl($buyingguidelines);
        $contactusUrl = $this->storeManager->getStore()->getUrl($contactus);
        
        if(!$compositionandcare){
            $compositionUrl=null;
        }
        if(!$sizeguidline){
            $sizeguideUrl=null;
        }
        if(!$shipping){
            $shippingUrl=null;
        }
        if(!$returns){
            $returnsUrl=null;
        }
        if(!$buyingguidelines){
            $buyguideUrl=null;
        }
        if(!$contactus){
            $contactus=null;
        }
        
        $productURLdata = $this->dataFactory->create();
        $productURLdata->setCompositionAndCare($compositionUrl);
        $productURLdata->setSizeGuideline($sizeguideUrl);
        $productURLdata->setShipping($shippingUrl);
        $productURLdata->setReturns($returnsUrl);
        $productURLdata->setBuyingGuideline($buyguideUrl);
        $productURLdata->setContactUs($contactusUrl);
        
        return $productURLdata;
    }

}