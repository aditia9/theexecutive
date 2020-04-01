<?php

namespace Ranosys\Newsletter\Model;

use Magento\Newsletter\Model\Subscriber;

class CustomerNewsletterSubscribe implements \Ranosys\Newsletter\Api\CustomerNewsletterSubscribeInterface {
    /*
     * @var subscriberFactory
     */

    protected $subscriberFactory;
    
    /**
     *
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;
    
    /**
     *
     * @var  \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->subscriberFactory = $subscriberFactory;
        $this->customerRepository = $customerRepositoryInterface;
        $this->customerSession = $customerSession;
    }
    
    /**
     * {@inheritdoc}
     */
    public function customerNewsletterSubscription($customerId, $email) {   
        $customer = $this->customerRepository->getById($customerId);
        if($customer->getEmail() == $email){
            $this->customerSession->setCustomerId($customerId);
        }
        
        $subscriberModel = $this->subscriberFactory->create();
        $subscriber = $subscriberModel->loadByEmail($email);
        
        if($subscriber->getId()){
            return sprintf('%s', __('Email already subscribed to newsletter'));
        }
        
        $result = $subscriberModel->subscribe($email);
        if ($result == Subscriber::STATUS_SUBSCRIBED || $result == Subscriber::STATUS_UNCONFIRMED) {
            $subscribe = sprintf('%s', __('Subscribed Successfully'));
        } elseif($result == Subscriber::STATUS_UNSUBSCRIBED) {
            $subscribe = sprintf('%s', __('User is Unsubscribed'));
        } elseif($result == Subscriber::STATUS_NOT_ACTIVE) {
            $subscribe = sprintf('%s', __('User is not Active'));
        }
        return $subscribe;
    }

}
