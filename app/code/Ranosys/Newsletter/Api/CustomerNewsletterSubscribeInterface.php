<?php

namespace Ranosys\Newsletter\Api;

/**
 * Interface providing Customer Newsletter Subscription
 */
interface CustomerNewsletterSubscribeInterface
{
    /**
     * Subscribe customer for newsletter.
     *
     * @param int $customerId
     * @param string email
     * @return string message 
     */
    public function customerNewsletterSubscription($customerId, $email);
    
}
