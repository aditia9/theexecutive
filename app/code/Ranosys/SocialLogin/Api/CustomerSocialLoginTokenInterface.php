<?php

namespace Ranosys\SocialLogin\Api;

/**
 * Interface providing token generation for Customers for Social login
 */
interface CustomerSocialLoginTokenInterface
{
    /**
     * Create access token for admin given the customer social login credentials.
     *
     * @param string token
     * @param string type
     * @param string email
     * @return string Token created
     * @throws \Magento\Framework\Exception\AuthenticationException
     */
    public function createCustomerSocialLoginToken($email, $type, $token);
    
}
