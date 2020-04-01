<?php

namespace Ranosys\BanktransferConfirmation\Api\Data;

/**
 * @api
 */
interface BankTransferdataInterface {
  
    const LABEL = 'label';
    const VALUE = 'value';
 
    /**
     * Get label
     * @return string
     */
    public function getLabel();

    /**
     * Set label
     * 
     * @param string $label
     * @return $this
     */
    public function setLabel($label);
    
    /**
     * Get Value
     * 
     * @return string
     */
    public function getValue();
    
    /**
     * Set value
     * 
     * @param string $value
     * @return this
     */
    public function setValue($value);
    
}
