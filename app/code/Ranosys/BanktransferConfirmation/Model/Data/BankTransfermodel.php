<?php

namespace Ranosys\BanktransferConfirmation\Model\Data;

class BankTransfermodel extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Ranosys\BanktransferConfirmation\Api\Data\BankTransferdataInterface
{ 
    
    /**
     * Get label
     * @return string
     */
    public function getLabel() {
        return $this->_get(self::LABEL);
    }
    
    /**
     * Get value
     * 
     * @return string
     */
    public function getValue(){
        return $this->_get(self::VALUE);
    }
    

    /**
     * Set label
     * 
     * @param string $label
     * @return this
     */
    public function setLabel($label) {
        return $this->setData(self::LABEL, $label);
    }   
    
    /**
     * Set value
     * 
     * @param string $value
     * @return this
     */
    public function setValue($value) {
        return $this->setData(self::VALUE, $value);
    }

}
