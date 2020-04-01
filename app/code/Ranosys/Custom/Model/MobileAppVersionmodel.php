<?php

namespace Ranosys\Custom\Model;

use \Magento\Framework\Api\AttributeValueFactory;

class MobileAppVersionmodel extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Ranosys\Custom\Api\Data\MobileAppVersiondataInterface
{

    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }
    
    /**
     * Get mobile app version
     * @return string
     */
    public function getVersion() {
        return $this->_get(self::VERSION);
    }
    
    /**
     * Get if app is in maintenance mode
     * 
     * @return string
     */
    public function getMaintenance(){
        return $this->_get(self::MAINTENANCE);
    }
    
    /**
     * Get maintenance message
     * 
     * @return string
     */
    public function getMaintenanceMessage(){
        return $this->_get(self::MAINTENANCE_MESSAGE);
    }
    
    /**
     * Get appstore url
     * 
     * @return string
     */
    public function getAppstoreUrl(){
        return $this->_get(self::APPSTORE_URL);
    }

    /**
     * Set mobile app version
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version) {
        return $this->setData(self::VERSION, $version);
    }
    
    
    /**
     * Set if app is in maintenance mode
     * 
     * @param string $maintenance
     * @return this
     */
    public function setMaintenance($maintenance) {
        return $this->setData(self::MAINTENANCE, $maintenance);
    }
    
    /**
     * Set maintenance message
     * 
     * @param string $message
     * @return this
     */
    public function setMaintenanceMessage($message) {
        return $this->setData(self::MAINTENANCE_MESSAGE, $message);
    }   
    
    /**
     * Set app store url
     * 
     * @param string $url
     * @return this
     */
    public function setAppstoreUrl($url) {
        return $this->setData(self::APPSTORE_URL, $url);
    }
    
    /**
     * Get media url
     * @return string $mediaUrl
     */
    public function getProductMediaUrl() {
        return $this->_get(self::MEDIA);
    }

    /**
     * Set media url
     *
     * @param string $mediaUrl
     * @return $this
     */
    public function setProductMediaUrl($mediaUrl) {
        return $this->setData(self::MEDIA, $mediaUrl);
    }
     /**
     * Get category url
     * @return string $categoryUrl
     */
    public function getCategoryMediaUrl() {
        return $this->_get(self::CATEGORY);
    }
    /**
     * Set category url
     *
     * @param string $categoryUrl
     * @return $this
     */
    public function setCategoryMediaUrl($categoryUrl) {
        return $this->setData(self::CATEGORY, $categoryUrl);
    }
    
         /**
     * Get voucher amount
     * @return string $voucher
     */
    public function getVoucherAmount() {
        return $this->_get(self::VOUCHER_AMOUNT);
    }
    /**
     * Set voucher amount
     *
     * @param string $voucher
     * @return $this
     */
    public function setVoucherAmount($voucher) {
        return $this->setData(self::VOUCHER_AMOUNT, $voucher);
    }
    
     /**
     * Get subscription message
     * @return string $subscriptionmessage
     */
    public function getSubscriptionMessage() {
        return $this->_get(self::SUBSCRIPTION_MESSAGE);
    }
    /**
     * Set subscription message
     *
     * @param string $subscriptionmessage
     * @return $this
     */
    public function setSubscriptionMessage($subscriptionmessage) {
        return $this->setData(self::SUBSCRIPTION_MESSAGE, $subscriptionmessage);
    }
    
    /**
     * Get Home Promotion message
     * @return string $homepromotionmessage
     */
    public function getHomePromotionMessage() {
        return $this->_get(self::HOME_PROMOTION_MESSAGE);
    }
    /**
     * Set Home Promotion message
     *
     * @param string $homepromotionmessage
     * @return $this
     */
    public function setHomePromotionMessage($homepromotionmessage) {
        return $this->setData(self::HOME_PROMOTION_MESSAGE, $homepromotionmessage);
    }
    
    /**
     * Get catalog listing promotion message
     * @return string $homepromotionmessage
     */
    public function getCatalogListingPromotionMessage() {
        return $this->_get(self::PRODUCT_CATALOG_PROMOTION_MESSAGE);
    }
    /**
     * Set catalog listing promotion message
     *
     * @param string $cataloglistingpromotionmessage
     * @return $this
     */
    public function setCatalogListingPromotionMessage($cataloglistingpromotionmessage) {
        return $this->setData(self::PRODUCT_CATALOG_PROMOTION_MESSAGE, $cataloglistingpromotionmessage);
    }
    
    /**
     * Get Home Promotion message url
     * @return string $homepromotionmessageurl
     */
    public function getHomePromotionMessageUrl() {
        return $this->_get(self::HOME_PROMOTION_MESSAGE_URL);
    }
    /**
     * Set Home Promotion message url
     *
     * @param string $homepromotionmessageurl
     * @return $this
     */
    public function setHomePromotionMessageUrl($homepromotionmessageurl) {
        return $this->setData(self::HOME_PROMOTION_MESSAGE_URL, $homepromotionmessageurl);
    }
    
    /**
     * Get catalog listing promotion message url
     * @return string $homepromotionmessageurl
     */
    public function getCatalogListingPromotionMessageUrl() {
        return $this->_get(self::PRODUCT_CATALOG_PROMOTION_MESSAGE_URL);
    }
    /**
     * Set catalog listing promotion message url
     *
     * @param string $cataloglistingpromotionmessageurl
     * @return $this
     */
    public function setCatalogListingPromotionMessageUrl($cataloglistingpromotionmessageurl) {
        return $this->setData(self::PRODUCT_CATALOG_PROMOTION_MESSAGE_URL, $cataloglistingpromotionmessageurl);
    }
    
    /**
     * Get Buying Guide url
     * @return string $homepromotionmessageurl
     */
    public function getBuyingGuideUrl() {
        return $this->_get(self::BUYING_GUIDE_URL);
    }
    /**
     * Set Buying Guide url
     *
     * @param string $buyingguideurl
     * @return $this
     */
    public function setBuyingGuideUrl($buyingguideurl) {
        return $this->setData(self::BUYING_GUIDE_URL, $buyingguideurl);
    }
    
    /**
     * Get contact us url
     * @return string $contactusurl
     */
    public function getContactUsUrl() {
        return $this->_get(self::CONTACT_US_URL);
    }
    /**
     * Set contact us url
     *
     * @param string $contactusurl
     * @return $this
     */
    public function setContactUsUrl($contactusurl) {
        return $this->setData(self::CONTACT_US_URL, $contactusurl);
    }
    
    /**
     * Get terms and condition url
     * @return string
     */
    public function getTermsAndConditionUrl() {
        return $this->_get(self::TERMS_CONDITION_URL);
    }
    /**
     * Set terms and condition url
     *
     * @param string $termsandcondition
     * @return $this
     */
    public function setTermsAndConditionUrl($termsandcondition) {
        return $this->setData(self::TERMS_CONDITION_URL, $termsandcondition);
    }

}
