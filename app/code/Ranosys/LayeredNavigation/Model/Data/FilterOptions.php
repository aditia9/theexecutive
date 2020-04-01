<?php

namespace Ranosys\LayeredNavigation\Model\Data;

class FilterOptions extends \Magento\Framework\Model\AbstractModel implements \Ranosys\LayeredNavigation\Api\Data\FilterOptionsInterface {
    
    const KEY_LABEL = 'label';
    const KEY_CODE = 'code';
    const KEY_VALUE = 'value';
    
    /**
     * @inheritDoc
     */
    public function getLabel() {
        return $this->_getData(self::KEY_LABEL);
    }
    
    /**
     * @inheritDoc
     */
    public function setLabel($label) {
        return $this->setData(self::KEY_LABEL, $label);
    }
    
    /**
     * @inheritDoc
     */
    public function getCode() {
        return $this->_getData(self::KEY_CODE);
    }
    
    /**
     * @inheritDoc
     */
    public function setCode($code) {
        return $this->setData(self::KEY_CODE, $code);
    }
    
    /**
     * @inheritDoc
     */
    public function getValue() {
        return $this->_getData(self::KEY_VALUE);
    }
    
    /**
     * @inheritDoc
     */
    public function setValue($value) {
        return $this->setData(self::KEY_VALUE, $value);
    }
    
}