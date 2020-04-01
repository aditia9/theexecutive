<?php

namespace Ranosys\Customer\Plugin\Model\ResourceModel;

use Magento\Framework\Registry;

class Customer {
    
    protected $registry;
    
    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;
    }
    
    public function beforeSave(\Magento\Customer\Model\ResourceModel\Customer $subject, \Magento\Customer\Model\Customer $customer){
        
        // bypass the customer confirmation if user is registered using social media(fb & g+)
        if($customer->getConfirmation() == 'social') {
            $this->registry->register('skip_confirmation_if_email', $customer->getEmail());
            $customer->setForceConfirmed(true);
        }
        return NULL;
    }
    
}