<?php

namespace Ranosys\Wishlist\Api\Data;

interface WishlistInformationInterface {
    
    /**
     * Get wishlist id
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Set wishlist id
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);
    
    /**
     * Get wishlist name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Set wishlist name
     * 
     * @param string $name
     * @return $this
     */
    public function setName($name);
    
    /**
     * Get wishlist items count
     * 
     * @return int
     */
    public function getItemsCount();
    
    /**
     * Set wishlist items count
     * 
     * @param int $itemsCount
     * @return $this
     */
    public function setItemsCount($itemsCount);
    
    /**
     * Get wishlist items
     * 
     * @return \Ranosys\Wishlist\Api\Data\WishlistItemInterface[]
     */
    public function getItems();
    
    /**
     * Set wishlist items
     * 
     * @param \Ranosys\Wishlist\Api\Data\WishlistItemInterface[]
     * @return $this
     */
    public function setItems($items);
    
}