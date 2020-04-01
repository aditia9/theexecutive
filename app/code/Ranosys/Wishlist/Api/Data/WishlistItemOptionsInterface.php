<?php

namespace Ranosys\Wishlist\Api\Data;

interface WishlistItemOptionsInterface {
    
    /**
     * Get wishlist item product option attribute label
     * 
     * @return string
     */
    public function getLabel();
    
    /**
     * Set wishlist item product option attribute label
     * 
     * @param int $label
     * @return $this
     */
    public function setLabel($label);
    
    /**
     * Get wishlist item product option attribute value
     * @return string
     */
    public function getValue();
    
    /**
     * Set wishlist item product option attribute value
     * 
     * @param string $value
     * @return $this
     */
    public function setValue($value);
    
    /**
     * Get wishlist item product option id
     * 
     * @return int
     */
    public function getOptionId();
    
    /**
     * Set wishlist item product option id
     * 
     * @param int $optionId
     * @return $this
     */
    public function setOptionId($optionId);
    
    /**
     * Get wishlist item product option value
     * 
     * @return int
     */
    public function getOptionValue();
    
    /**
     * Set wishlist item product option value
     * 
     * @param int $optionValue
     * @return $this
     */
    public function setOptionValue($optionValue);
    
}