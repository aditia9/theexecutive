<?php

namespace Ranosys\Wishlist\Api\Data;

interface WishlistItemInterface{
    
    /**
     * Get wishlist item id
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Set wishlist item id
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);
    
    /**
     * Get wishlist item product id
     * 
     * @return int
     */
    public function getProductId();
    
    /**
     * Set wishlist item product id
     * 
     * @param $productid
     * @return $this
     */
    public function setProductId($productid);
    
    /**
     * Get product type
     * 
     * @return string
     */
    public function getTypeId();
    
    /**
     * Set product type
     * 
     * @param string $typeId
     * @return $this
     */
    public function setTypeId($typeId);
    
    /**
     * Get wishlist item product quntity
     * 
     * @return int
     */
    public function getQty();
    
    /**
     * Set wishlist item product quantity
     * 
     * @param int $qty
     * @return $this
     */
    public function setQty($qty);
    
    /**
     * Get wishlist item product sku
     * 
     * @return string
     */
    public function getSku();
    
    /**
     * Set wishlist item product sku
     * 
     * @param string $sku
     * @return $this
     */
    public function setSku($sku);
    
    /**
     * Get wishlist item product name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Set wishlist item product name
     * 
     * @param string $name
     * @return $this
     */
    public function setName($name);
    
    /**
     * Get wishlist item product image
     * 
     * @return string
     */
    public function getImage();
    
    /**
     * Set wishlist item product image
     * 
     * @param string $image
     * @return $this
     */
    public function setImage($image);
    
    /**
     * Get wishlist item product regular price
     * 
     * @return float
     */
    public function getRegularPrice();
    
    /**
     * Set wishlist item product regular price
     * 
     * @param float $regularPrice
     * @return $this
     */
    public function setRegularPrice($regularPrice);
    
    /**
     * Get wishlist item product final price
     * 
     * @return float
     */
    public function getFinalPrice();
    
    /**
     * Set wishlist item product final price
     * 
     * @param float $finalPrice
     * @return $this
     */
    public function setFinalPrice($finalPrice);
    
    /**
     * Get wishlist item stock options
     * 
     * @return \Magento\CatalogInventory\Api\Data\StockItemInterface
     */
    public function getStockItem();
    
    /**
     * Set wishlist item stock options
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @return $this
     */
    public function setStockItem($stockItem);
    
    /**
     * Get wishlist item product options
     * 
     * @return \Ranosys\Wishlist\Api\Data\WishlistItemOptionsInterface[]
     */
    public function getOptions();
    
    /**
     * Set wishlist item product options
     * @param \Ranosys\Wishlist\Api\Data\WishlistItemOptionsInterface[]
     * @return $this
     */
    public function setOptions($options);
    
}