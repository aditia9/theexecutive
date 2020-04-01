<?php

namespace Ranosys\Checkout\Api;

interface CartMergeInterface {
    /**
     * Merge guest and logged in customer cart
     * 
     * @param int $customerId
     * @param string $guestCartId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function mergeCart($customerId, $guestCartId);
}