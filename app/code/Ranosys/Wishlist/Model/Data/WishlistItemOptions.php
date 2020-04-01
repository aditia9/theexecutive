<?php

namespace Ranosys\Wishlist\Model\Data;

class WishlistItemOptions extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Wishlist\Api\Data\WishlistItemOptionsInterface {
    
    const KEY_LABEL = 'label';
    const KEY_VALUE = 'value';
    const KEY_OPTIONID = 'option_id';
    const KEY_OPTIONVALUE = 'option_value';
    
    /**
     * {@inheritdoc}
     */
    public function getLabel() {
        return $this->_getData(self::KEY_LABEL);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLabel($label) {
        return $this->setData(self::KEY_LABEL, $label);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getValue() {
        return $this->_getData(self::KEY_VALUE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue($value) {
        return $this->setData(self::KEY_VALUE, $value);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOptionId() {
        return $this->_getData(self::KEY_OPTIONID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOptionId($optionId) {
        return $this->setData(self::KEY_OPTIONID, $optionId);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOptionValue() {
        return $this->_getData(self::KEY_OPTIONVALUE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOptionValue($optionValue) {
        return $this->setData(self::KEY_OPTIONVALUE, $optionValue);
    }
    
}