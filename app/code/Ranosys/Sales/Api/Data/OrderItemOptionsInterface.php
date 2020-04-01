<?php

namespace Ranosys\Sales\Api\Data;

interface OrderItemOptionsInterface {
    
    /**
     * Get option attribute Label
     * 
     * @return $string
     */
    public function getLabel();
    
    /**
     * Set option attribute label
     * 
     * @param string $label
     * @return $this
     */
    public function setLabel($label);
    
    /**
     * Get option label
     * 
     * @return string
     */
    public function getValue();
    
    /**
     * set option label
     * 
     * @param string $value
     * @return $this
     */
    public function setValue($value);
    
    /**
     * Get option attribute id
     * 
     * @return int
     */
    public function getOptionId();
    
    /**
     * Set option attribute id
     * 
     * @param int $optionId
     * @return $this
     */
    public function setOptionId($optionId);
    
    /**
     * Get option value
     * 
     * @return int
     */
    public function getOptionValue();
    
    /**
     * Set option value
     * 
     * @param int $optionValue
     * @return $this
     */
    public function setOptionValue($optionValue);
    
}