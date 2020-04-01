<?php

namespace Ranosys\Rma\Plugin\Api;

class MyOrdersPlugin {
    
    protected $orderExtensionFactory;
    
    protected $returntoAddressFactory;
    
    protected $scopeConfig;
    
    public function __construct(
        \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory,
        \Ranosys\Rma\Model\Data\ReturntoAddressFactory $returntoAddressFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->returntoAddressFactory = $returntoAddressFactory;
        $this->scopeConfig = $scopeConfig;
    }
    
    public function afterGetDetail(\Ranosys\Sales\Api\MyOrdersInterface $myOrders, $order, $orderIncrementId, $customerId){
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }
        
        
        if($this->scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == '1') {
            
            $returntoName = $this->scopeConfig->getValue('hypework_productreturn/rma_returnto_address/returnto_name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $returntoAddressText = $this->scopeConfig->getValue('hypework_productreturn/rma_returnto_address/returnto_address', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $returntoContact = $this->scopeConfig->getValue('hypework_productreturn/rma_returnto_address/returnto_contact', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            
            $returntoAddress = $this->returntoAddressFactory->create();
            $returntoAddress->setReturntoName($returntoName);
            $returntoAddress->setReturntoAddress($returntoAddressText);
            $returntoAddress->setReturntoContact($returntoContact);
            
            $extensionAttributes->setReturntoAddress($returntoAddress);
            
            $order->setExtensionAttributes($extensionAttributes);
        }
        
        return $order;
    }
    
}