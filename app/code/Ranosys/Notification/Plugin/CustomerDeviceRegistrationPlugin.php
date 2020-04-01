<?php

namespace Ranosys\Notification\Plugin;

class CustomerDeviceRegistrationPlugin {

    protected $tokenInterface;
    protected $request;
    protected $deviceFactory;
    protected $customerFactory;
    protected $storeManager;
    protected $timezone;

    public function __construct(
            \Magento\Framework\App\Request\Http $request, 
            \Ranosys\Notification\Model\DeviceFactory $deviceFactory,
            \Magento\Integration\Model\Oauth\TokenFactory $tokenInterface,
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
            \Magento\Customer\Model\Customer $customerFactory) {

        
            $this->tokenInterface = $tokenInterface;
            $this->request = $request;
            $this->deviceFactory = $deviceFactory;
            $this->customerFactory = $customerFactory;
            $this->storeManager = $storeManager;
            $this->timezone = $timezone;
    }

    public function afterCreateCustomerToken($tokenInterface, $result, $customerId) {
        $store_id =  $this->storeManager->getStore()->getId();
        $customerData = $this->customerFactory->getCollection()
                        ->addFieldToFilter('entity_id', array('eq' => $customerId))->getData();
        $customer_id = $customerData[0]['entity_id'];
        $device_id = $this->request->getParam('device_id');
        $device_type = $this->request->getParam('device_type');
        $registration_id = $this->request->getParam('registration_id');
        
        if(!$device_id || !$device_type ||!$registration_id){
            return $result;
        }

        $updated_at = $this->timezone->gmtDate();
        
        $deviceCollection = $this->deviceFactory->create()->getCollection()
                            ->addFieldToFilter('device_type', array('eq' => $device_type))
                            ->addFieldToFilter('device_id', array('eq' => $device_id));
        
        if (!$deviceCollection->getSize()) {
            $device = $this->deviceFactory->create();
            $device->setData(
                [
                    'device_type' => $device_type,
                    'registration_id' => $registration_id,
                    'device_id' => $device_id,
                    'customer_id' => $customer_id,
                    'store_id' => $store_id,
                    'created_at' => $updated_at,
                    'updated_at' => $updated_at
                ]
            );
            $device->save();
        } else {
            foreach ($deviceCollection as $item) {
                $item->setCustomerId($customer_id);
                $item->setRegistrationId($registration_id);
                $item->setUpdatedAt($updated_at);
                $item->setStoreId($store_id);
                $item->save();
            }
        }
        
        return $result;
    }

}
