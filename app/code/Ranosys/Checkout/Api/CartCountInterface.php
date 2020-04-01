<?php

namespace Ranosys\Checkout\Api;


/**
 * Count items in cart
 */
interface CartCountInterface {

    /**
     * Return number of item in cart
     *
     * @api
     * @param  int $cartId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCartCount($cartId);
    
      /**
     * Return number of item in guest cart
     *
     * @api
     * @param  string $cartId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
     public function getGuestCartCount($cartId);
}
