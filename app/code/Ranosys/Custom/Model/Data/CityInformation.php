<?php

namespace Ranosys\Custom\Model\Data;

class CityInformation extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Custom\Api\Data\CityInformationInterface {
    
    const KEY_NAME = 'name';
    const KEY_VALUE = 'value';
    
    /**
     * @inheritDoc
     */
    public function getName() {
        return $this->_getData(self::KEY_NAME);
    }
    
    /**
     * @inheritDoc
     */
    public function setName($name) {
        return $this->setData(self::KEY_NAME, $name);
    }
    
    /**
     * @inheritDoc
     */
    public function getValue() {
        return $this->getData(self::KEY_VALUE);
    }
    
    /**
     * @inheritDoc
     */
    public function setValue($value) {
        return $this->setData(self::KEY_VALUE, $value);
    }
    
}