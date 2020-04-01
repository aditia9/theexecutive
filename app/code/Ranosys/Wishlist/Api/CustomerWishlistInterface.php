<?php

namespace Ranosys\Wishlist\Api;

/**
 * Interface for adding product in wishlist 
 */
interface CustomerWishlistInterface
{
    /**
     * Add Product To Wishlist
     *
     * @param int $customerId
     * @param string $productSku
     * @param mixed $options
     * 
     * @return string message 
     */
    public function addToWishlist($customerId, $productSku, $options = null);
    
    /**
     * Get customer wishlist information
     * 
     * @param int $customerId
     * @return \Ranosys\Wishlist\Api\Data\WishlistInformationInterface
     */
    public function getInformation($customerId);
    
    /**
     * Delete wishlist item
     * @param int $customerId
     * @param int $id
     * @return string
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function deleteItem($customerId, $id);
    
    /**
     * Add Product To cart
     *
     * @param int $customerId
     * @param int $cartId
     * @param int $id
     * @param int $qty
     * @return string message 
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addToCart($customerId, $cartId, $id, $qty);
    
    /**
     * Move Product To Wishlist from cart
     *
     * @param int $customerId
     * @param int $cartId
     * @param int $id
     * @return string message
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveToWishlistFromCart($customerId, $cartId, $id);
}
