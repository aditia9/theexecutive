<?php

namespace Ranosys\Custom\Model;

use Ranosys\Custom\Api\MobileAppVersionInterface;
use Magento\Framework\Exception\InputException;

/**
 * Implementation class of contract.
 */
class MobileAppVersion implements MobileAppVersionInterface
{

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $storeManager;

    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Ranosys\Custom\Api\Data\MobileAppVersiondataInterfaceFactory $dataFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Helper\Page $cmsPage
    ) {
        $this->dataFactory = $dataFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->pageFactory = $pageFactory;
        $this->cmsPage = $cmsPage;
    }

    /**
     * Return array
     *
     * @api
     * @param string $os
     * @return \Ranosys\Custom\Api\Data\MobileAppVersiondataInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getConfiguration($os) {
        if($os == 'ios') {
            $version = $this->scopeConfig->getValue('mobileappversion/general/ios_version', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $maintenance = $this->scopeConfig->getValue('mobileappversion/general/ios_maintenance', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $maintenance_message = $this->scopeConfig->getValue('mobileappversion/general/message_maintenance', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $store_url = $this->scopeConfig->getValue('mobileappversion/general/appstore_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }
        elseif ($os == 'android') {
            $version = $this->scopeConfig->getValue('mobileappversion/general/android_version', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $store_url = $this->scopeConfig->getValue('mobileappversion/general/playstore_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $maintenance = $this->scopeConfig->getValue('mobileappversion/general/android_maintenance', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $maintenance_message = $this->scopeConfig->getValue('mobileappversion/general/message_maintenance', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);             
        } else {
            throw new InputException(__('Invalid os type provided'));
        }
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."catalog/product/";
        $categoryUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."catalog/category/";
        $voucher = $this->scopeConfig->getValue('subscription/general_tab2/coupon_amount', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $subscriptionmessage = $this->scopeConfig->getValue('subscription/general_tab2/subscription_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $homepromotionmessage = $this->scopeConfig->getValue('mobileappversion/general/home_promotion_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $catalogpromotionmessage = $this->scopeConfig->getValue('mobileappversion/general/catalog_listing_promotion_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $homepromotionmessageurlkey = $this->scopeConfig->getValue('mobileappversion/general/home_promotion_message_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $catalogpromotionmessageurlkey = $this->scopeConfig->getValue('mobileappversion/general/catalog_listing_promotion_message_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $homepromotionmessageurl = $this->cmsPage->getPageUrl($homepromotionmessageurlkey);
        $catalogpromotionmessageurl = $this->cmsPage->getPageUrl($catalogpromotionmessageurlkey);
        $buyingguidurlkey = $this->scopeConfig->getValue('mobileappversion/general/buying_guide_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $contactusurlkey = $this->scopeConfig->getValue('mobileappversion/general/contact_us_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $termsandconditionurlkey = $this->scopeConfig->getValue('mobileappversion/general/term_condition_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $buyingguidurl = $this->cmsPage->getPageUrl($buyingguidurlkey);
        $contactusurl = $this->cmsPage->getPageUrl($contactusurlkey);
        $termsandconditionurl = $this->cmsPage->getPageUrl($termsandconditionurlkey);
        
        if(!$voucher){
            $voucher = '';
        }
        
        if(!$subscriptionmessage){
            $subscriptionmessage = '';
        }
        
        if(!$homepromotionmessage){
            $homepromotionmessage = '';
        }
        if(!$catalogpromotionmessage){
            $catalogpromotionmessage = '';
        }
        if(!$homepromotionmessageurl){
            $homepromotionmessageurl = '';
        }
        if(!$catalogpromotionmessageurl){
            $catalogpromotionmessageurl = '';
        }
        
        $mobileAppData = $this->dataFactory->create();
        $mobileAppData->setVersion($version);
        $mobileAppData->setMaintenance($maintenance);
        $mobileAppData->setMaintenanceMessage($maintenance_message);
        $mobileAppData->setAppstoreUrl($store_url);
        $mobileAppData->setProductMediaUrl($mediaUrl);
        $mobileAppData->setCategoryMediaUrl($categoryUrl);
        $mobileAppData->setVoucherAmount($voucher);
        $mobileAppData->setSubscriptionMessage($subscriptionmessage);
        $mobileAppData->setHomePromotionMessage($homepromotionmessage);
        $mobileAppData->setCatalogListingPromotionMessage($catalogpromotionmessage);
        $mobileAppData->setHomePromotionMessageUrl($homepromotionmessageurl);
        $mobileAppData->setCatalogListingPromotionMessageUrl($catalogpromotionmessageurl);
        $mobileAppData->setBuyingGuideUrl($buyingguidurl);
        $mobileAppData->setContactUsUrl($contactusurl);
        $mobileAppData->setTermsAndConditionUrl($termsandconditionurl);
        return $mobileAppData;
        
    }
    
    public function getCmsPageContent($identifier)
    {
        if ($identifier) {
            $content = $this->pageFactory->create();
            $content->load($identifier, 'identifier');
        }
        return $content->getContent();
    }

}
