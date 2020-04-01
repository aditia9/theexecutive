<?php

namespace Hypework\Shipping\Model;

class District extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface,
\Hypework\Shipping\Model\Inter\DistrictInterface
{
    const CACHE_TAG = 'hypework_shipping_district';

    protected $_cacheTag = 'hypework_shipping_district';

    protected $_eventPrefix = 'hypework_shipping_district';

    protected function _construct() {
        $this->_init('Hypework\Shipping\Model\ResourceModel\District');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
    }


    /** GETTER **/
    public function getEntityId() {
        return $this->getData(self::ENTITY_ID);
    }
    public function getName() {
        return $this->getData(self::NAME);   
    }
    public function getCreatedAt() {
        return $this->getData(self::CREATED_AT);   
    }
    public function getUpdatedAt() {
        return $this->getData(self::UPDATED_AT);   
    }

    /** SETTER **/
    public function setEntityId($id) {
        return $this->setData(self::ENTITY_ID, $id);
    }
    public function setName($name) {
        return $this->setData(self::NAME, $name);
    }
    public function setCreatedAt($createdAt) {
        return $this->setData(self::CREATED_AT, $createdAt);   
    }
    public function setUpdatedAt($updatedAt) {
        return $this->setData(self::UPDATED_AT, $updatedAt);      
    }

}