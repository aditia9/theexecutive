<?php

namespace Ranosys\Custom\Model\Data;

class ProductContentURLdata extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Custom\Api\Data\ProductURLdataInterface {
    
    
    /**
     * @inheritDoc
     */
    public function getCompositionAndCare() {
        return $this->_getData(self::COMPOSITION_AND_CARE);
    }
    
    /**
     * @inheritDoc
     */
    public function setCompositionAndCare($composition) {
        return $this->setData(self::COMPOSITION_AND_CARE, $composition);
    }
    
    /**
     * @inheritDoc
     */
    public function getSizeGuideline() {
        return $this->_getData(self::SIZE_GUIDELINE);
    }
    
    /**
     * @inheritDoc
     */
    public function setSizeGuideline($sizeguidline) {
        return $this->setData(self::SIZE_GUIDELINE, $sizeguidline);
    }
    
    /**
     * @inheritDoc
     */
    public function getShipping() {
        return $this->_getData(self::SHIPPING);
    }
    
    /**
     * @inheritDoc
     */
    public function setShipping($shipping) {
        return $this->setData(self::SHIPPING, $shipping);
    }
    
    /**
     * @inheritDoc
     */
    public function getReturns() {
        return $this->_getData(self::RETURNS);
    }
    
    /**
     * @inheritDoc
     */
    public function setReturns($returns) {
        return $this->setData(self::RETURNS, $returns);
    }
    
    /**
     * @inheritDoc
     */
    public function getBuyingGuideline() {
        return $this->_getData(self::BUYING_GUIDELINE);
    }
    
    /**
     * @inheritDoc
     */
    public function setBuyingGuideline($buyguidline) {
        return $this->setData(self::BUYING_GUIDELINE, $buyguidline);
    }
    
    /**
     * @inheritDoc
     */
    public function getContactUs() {
        return $this->_getData(self::CONTACT_US);
    }
    
    /**
     * @inheritDoc
     */
    public function setContactUs($contactus) {
        return $this->setData(self::CONTACT_US, $contactus);
    }
}