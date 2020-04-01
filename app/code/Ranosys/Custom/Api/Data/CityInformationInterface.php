<?php

namespace Ranosys\Custom\Api\Data;

interface CityInformationInterface {
    
    /**
     * get city name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * set city name
     * 
     * @param string $name
     * @return $this
     */
    public function setName($name);
    
    /**
     * get city value
     * 
     * @return int
     */
    public function getValue();
    
    /**
     * get city value
     * 
     * @param string $value
     * @return $this
     */
    public function setValue($value);
    
}