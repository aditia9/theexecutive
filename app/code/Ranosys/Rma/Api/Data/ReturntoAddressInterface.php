<?php

namespace Ranosys\Rma\Api\Data;

interface ReturntoAddressInterface {
    
    /**
     * Get return to name
     * 
     * @return string
     */
    public function getReturntoName();
    
    /**
     * Set return to name
     * 
     * @param string $returntoName
     * @return $this
     */
    public function setReturntoName($returntoName);
    
    /**
     * Get return to address
     * 
     * @return string
     */
    public function getReturntoAddress();
    
    /**
     * Set return to address
     * 
     * @param string $returntoAddress
     * @return $this
     */
    public function setReturntoAddress($returntoAddress);
    
    /**
     * Get return to contact
     * 
     * @return string
     */
    public function getReturntoContact();
    
    /**
     * Set return to contact
     * 
     * @param string $returntoContact
     * @return $this
     */
    public function setReturntoContact($returntoContact);
    
}