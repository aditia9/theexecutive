<?php

namespace Ranosys\LayeredNavigation\Model\Data;

class FilterInformation extends \Magento\Framework\Model\AbstractModel 
    implements \Ranosys\LayeredNavigation\Api\Data\FilterInformationInterface {
    
    const KEY_NAME = 'name';
    const KEY_CODE = 'code';
    const KEY_OPTIONS = 'options';
    
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
    public function getCode() {
        return $this->_getData(self::KEY_CODE);;
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
    public function getOptions() {
        return $this->_getData(self::KEY_OPTIONS);
    }
    
    /**
     * @inheritDoc
     */
    public function setOptions(array $options = null) {
        return $this->setData(self::KEY_OPTIONS, $options);
    }
}