<?php

namespace Ranosys\Custom\Api\Data;

/**
 * @api
 */
interface MobileAppVersiondataInterface {
    
    /**#@+
     * Constants defined for keys of the data array.
     */
    const VERSION = 'version';
    const MAINTENANCE = 'maintenance';
    const MAINTENANCE_MESSAGE = 'message_maintenance';
    const APPSTORE_URL = 'appstore_url';
    const MEDIA = 'product_media_url';
    const CATEGORY = 'category_media_url';
    const VOUCHER_AMOUNT = 'voucher_amount';
    const SUBSCRIPTION_MESSAGE = 'subscription_message';
    const HOME_PROMOTION_MESSAGE = 'home_promotion_message';
    const PRODUCT_CATALOG_PROMOTION_MESSAGE = 'product_catalog_promotion_message';
    const HOME_PROMOTION_MESSAGE_URL = 'home_promotion_message_url';
    const PRODUCT_CATALOG_PROMOTION_MESSAGE_URL = 'product_catalog_promotion_message_url';
    const CONTACT_US_URL = 'contact_us_url';
    const BUYING_GUIDE_URL = 'buying_guide_url';
    const TERMS_CONDITION_URL = 'terms_condition_url';

    /**
     * Get mobile app version
     *
     * @return string
     */
    public function getVersion();

    /**
     * Set mobile app version
     * 
     * @param string $version
     * @return $this
     */
    public function setVersion($version);
    
    /**
     * Get if app is in maintenance mode
     * 
     * @return string
     */
    public function getMaintenance();
    
    /**
     * Set if app is in maintenance mode
     * 
     * @param string $maintenance
     * @return this
     */
    public function setMaintenance($maintenance);
    
    /**
     * Get maintenance message
     * 
     * @return string
     */
    public function getMaintenanceMessage();
    
    /**
     * Set maintenance message
     * 
     * @param string $message
     * @return this
     */
    public function setMaintenanceMessage($message);
    
    /**
     * Get appstore url
     * 
     * @return string
     */
    public function getAppstoreUrl();
    
    /**
     * Set app store url
     * 
     * @param string $url
     * @return this
     */
    public function setAppstoreUrl($url);
    
       /**
     * Get product media base url
     *
     * @return string
     */
    public function getProductMediaUrl();
    /**
     * Set product media base url
     * 
     * @param string $mediaUrl
     * @return $this
     */
    public function setProductMediaUrl($mediaUrl);
    
     /**
     * Get category media url
     *
     * @return string
     */
    public function getCategoryMediaUrl();
    /**
     * Set category media url
     * 
     * @param string $categoryUrl
     * @return $this
     */
    public function setCategoryMediaUrl($categoryUrl);
     
     /**
     * Get voucher amount
     *
     * @return string
     */
    public function getVoucherAmount();
    /**
     * Set category voucher amount
     * 
     * @param string $voucher
     * @return $this
     */
    public function setVoucherAmount($voucher);
  
    /**
     * Get subscription message
     *
     * @return string
     */
    public function getSubscriptionMessage();
    /**
     * Set category subscription message
     * 
     * @param string $subscriptionmessage
     * @return $this
     */
    public function setSubscriptionMessage($subscriptionmessage);
    
    /**
     * Get Home Promotion message
     *
     * @return string
     */
    public function getHomePromotionMessage();
    /**
     * Set Home Promotion message
     * 
     * @param string $homepromotionmessage
     * @return $this
     */
    public function setHomePromotionMessage($homepromotionmessage);
    
    /**
     * Get catalog listing promotion message
     *
     * @return string
     */
    public function getCatalogListingPromotionMessage();
    /**
     * Set catalog listing promotion message
     * 
     * @param string $cataloglistingpromotionmessage
     * @return $this
     */
    public function setCatalogListingPromotionMessage($cataloglistingpromotionmessage);
    
    /**
     * Get Home Promotion message url
     *
     * @return string
     */
    public function getHomePromotionMessageUrl();
    /**
     * Set Home Promotion message url
     * 
     * @param string $homepromotionmessageurl
     * @return $this
     */
    public function setHomePromotionMessageUrl($homepromotionmessageurl);
    
    /**
     * Get catalog listing promotion message url
     *
     * @return string
     */
    public function getCatalogListingPromotionMessageUrl();
    /**
     * Set catalog listing promotion message url
     * 
     * @param string $cataloglistingpromotionmessageurl
     * @return $this
     */
    public function setCatalogListingPromotionMessageUrl($cataloglistingpromotionmessageurl);
    
    /**
     * Get Buying Guide url
     *
     * @return string
     */
    public function getBuyingGuideUrl();
    /**
     * Set Buying Guide url
     * 
     * @param string $buyingguideurl
     * @return $this
     */
    public function setBuyingGuideUrl($buyingguideurl);
    
    /**
     * Get contact us url
     *
     * @return string
     */
    public function getContactUsUrl();
    /**
     * Set contact us url
     * 
     * @param string $contactusurl
     * @return $this
     */
    public function setContactUsUrl($contactusurl);
    
    /**
     * Get terms and condition url
     *
     * @return string
     */
    public function getTermsAndConditionUrl();
    /**
     * Set terms and condition url
     * 
     * @param string $termsandcondition
     * @return $this
     */
    public function setTermsAndConditionUrl($termsandcondition);
}
