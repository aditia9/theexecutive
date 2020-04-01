<?php

namespace Ranosys\LayeredNavigation\Api\Data;

interface FilterOptionsInterface {
    
    /**
     * Get filter option label
     * 
     * @return string|null
     */
    public function getLabel();
    
    /**
     * Set filter option label
     * 
     * @param string $name
     * @return $this
     */
    public function setLabel($label);
    
    /**
     * Get option code
     * 
     * @return string|null
     */
    public function getCode();
    
    /**
     * Set option code
     * 
     * @param string $code
     * @return $this
     */
    public function setCode($code);
    
    /**
     * Get filter options
     * 
     * @return string|null
     */
    public function getValue();
    
    /**
     * Set filter options
     * 
     * @param string $value
     * @return $this
     */
    public function setValue($value);
    
}