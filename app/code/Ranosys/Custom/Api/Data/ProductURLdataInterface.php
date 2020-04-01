<?php

namespace Ranosys\Custom\Api\Data;

/**
 * @api
 */
interface ProductURLdataInterface {
    
    /**#@+
     * Constants defined for keys of the data array.
     */
    const COMPOSITION_AND_CARE = 'composition_and_care_url';
    
    const SIZE_GUIDELINE = 'size_guideline_url';
    
    const SHIPPING = 'shipping_url';
    
    const RETURNS = 'return_url';
    
    const BUYING_GUIDELINE = 'buying_guideline_url';
    
    const CONTACT_US = 'contact_us';

    /**
     * Get Composition And Care URl
     *
     * @return string
     */
    public function getCompositionAndCare();

    /**
     * Set Composition And Care URl
     * 
     * @param string $composition
     * @return $this
     */
    public function setCompositionAndCare($composition);
    
    /**
     * Get Size Guideline URl
     *
     * @return string
     */
    public function getSizeGuideline();

    /**
     * Set Size Guideline URl
     * 
     * @param string $sizeguidline
     * @return $this
     */
    public function setSizeGuideline($sizeguidline);
    
    /**
     * Get Shipping URl
     *
     * @return string
     */
    public function getShipping();

    /**
     * Set Shipping URl
     * 
     * @param string $shipping
     * @return $this
     */
    public function setShipping($shipping);
    
        /**
     * Get Returns URl
     *
     * @return string
     */
    public function getReturns();

    /**
     * Set Returns URl
     * 
     * @param string $returns
     * @return $this
     */
    public function setReturns($returns);
    
    /**
     * Get Buying Guideline URl
     *
     * @return string
     */
    public function getBuyingGuideline();

    /**
     * Set Buying Guideline URl
     * 
     * @param string $buyguidline
     * @return $this
     */
    public function setBuyingGuideline($buyguidline);
    
    /**
     * Get Contact Us URl
     *
     * @return string
     */
    public function getContactUs();

    /**
     * Set Contact Us URl
     * 
     * @param string $contactus
     * @return $this
     */
    public function setContactUs($contactus);
    
    
}
