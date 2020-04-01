<?php

namespace Ranosys\LayeredNavigation\Api\Data;

interface FilterInformationInterface{
    
    /**
     * Get filter name
     * 
     * @return string!null
     */
    public function getName();
    
    /**
     * Set filter name
     * 
     * @param string $name
     * @return $this
     */
    public function setName($name);
    
    /**
     * Get filter code
     * 
     * @return string
     */
    public function getCode();
    
    /**
     * Set filter code
     * 
     * @param string $code
     * @return $this
     */
    public function setCode($code);
    
    /**
     * Get filter options
     * 
     * @return \Ranosys\LayeredNavigation\Api\Data\FilterOptionsInterface[]|null
     */
    public function getOptions();
    
    /**
     * Set filter options
     * 
     * @param \Ranosys\LayeredNavigation\Api\Data\FilterOptionsInterface[] $options
     * @return $this
     */
    public function setOptions(array $options = null);
    
}