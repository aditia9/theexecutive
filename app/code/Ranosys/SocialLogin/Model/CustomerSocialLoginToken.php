<?php

namespace Ranosys\SocialLogin\Model;

use Magento\Framework\Exception\AuthenticationException;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Customer\Model\Customer;

class CustomerSocialLoginToken implements \Ranosys\SocialLogin\Api\CustomerSocialLoginTokenInterface {
    /*
     * @var curlRequestUrl
     */

    private $curlRequestUrl;

    /*
     * @var customer
     */
    protected $customer;

    /*
     * @var storeManager
     */
    protected $storeManager;

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    public function __construct(
        Customer $customer,
        TokenModelFactory $tokenModelFactory,
        StoreManager $storeManager
    ) {
        $this->customer = $customer;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->storeManager = $storeManager;
    }

    public function createCustomerSocialLoginToken($email, $type, $token) {

        $access_token = $this->authenticateToken($token, $type);

        if ($access_token) {
            $this->customer->setWebsiteId($this->storeManager->getStore()->getId());
            $this->customer->loadByEmail($email);
            
            if(!$this->customer->getId()){
                throw new AuthenticationException(__('Customer not registered.'));
            }

            $customerToken = $this->tokenModelFactory->create();
            return $customerToken->createCustomerToken($this->customer->getId())->getToken();
        } else {
            throw new AuthenticationException(__('Invalid login token provided.'));
        }
        
    }

    public function authenticateToken($token, $type) {      
        $apiUrl = $this->validateType($token, $type);      
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curl = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($curl, true);
            if ((isset($response["email_verified"])) || (isset($response['name']))) {
                $isVerified = true;
            } else {
                $isVerified = false;
            }

            return $isVerified;
        } catch (\Exception $ex) {
            throw new AuthenticationException(__('Cannot authenticate social token provided'));
        }
    }

    public function validateType($token, $type) {   
        if ($type == 'google') {
            $this->curlRequestUrl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$token";
            return $this->curlRequestUrl;
        } else if ($type == 'facebook') {
            $this->curlRequestUrl = "https://graph.facebook.com/app/?access_token=$token";
            return $this->curlRequestUrl;
        } else {
            throw new \Exception('Invalid social login type.');
        }       
    }

}
