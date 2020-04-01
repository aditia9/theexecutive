<?php

namespace Ranosys\Notification\Observer;

use Magento\Framework\Event\ObserverInterface;

class AbandonedCartNotification implements ObserverInterface {
    protected $notificationsPendingFactory;
    
    protected $notificationDevicePool;
    
    protected $deviceFactory;
    
    protected $notificationHelper;
    
    protected $timezone;
    
    protected $logger;
    
    protected $notificationDeliveredFactory;
    
    protected $storeManager;
    
    protected $notificationDeliveredDeviceFactory;
    
    public function __construct(
        \Ranosys\Notification\Model\NotificationpendingFactory $notificationsPendingFactory,
        \Ranosys\Notification\Model\Notification\DevicePool $notificationDevicePool,
        \Ranosys\Notification\Model\NotificationdeliveredFactory $notificationDeliveredFactory,
        \Ranosys\Notification\Model\NotificationDeliveredDeviceFactory $notificationDeliveredDeviceFactory,
        \Ranosys\Notification\Model\DeviceFactory $deviceFactory,
        \Ranosys\Notification\Helper\Data $notificationHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
        \Ranosys\Notification\Logger\Logger $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->notificationsPendingFactory = $notificationsPendingFactory;
        $this->notificationDeliveredFactory = $notificationDeliveredFactory;
        $this->notificationDeliveredDeviceFactory = $notificationDeliveredDeviceFactory;
        $this->notificationDevicePool = $notificationDevicePool;
        $this->deviceFactory = $deviceFactory;
        $this->notificationHelper = $notificationHelper;
        $this->timezone = $timezone;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $cart = $observer->getEvent()->getOrder();
        $customerId = $cart->getCustomerId();
  
        if(!$customerId){
            return;
        }
        
        $customerDevices = $this->deviceFactory->create()->getCollection();
        $customerDevices->addFieldToFilter('customer_id', array('eq' => $customerId));
      
        if(!$customerDevices->getSize()){
            return;
        }
        
                
       
        $pendingNotification = $this->notificationsPendingFactory->create();
        $message = __('You have Items in Your Shopping Bag');

        $setNotificationDeliver = $this->setNotificationAsDelivered($cart, $message);
        $notification_delivered_id = $setNotificationDeliver->getId();
        
        
        foreach($customerDevices as $customerDevice) {
            try {
                $pendingNotification->setId(0);
                $pendingNotification->setDeviceType($customerDevice->getDeviceType());
                $pendingNotification->setRegistrationId($customerDevice->getRegistrationId());
                $pendingNotification->setDeviceId($customerDevice->getDeviceId());
                $pendingNotification->setCustomerId($customerId);
                $pendingNotification->setCreatedAt($this->timezone->gmtDate());
                $pendingNotification->setNotificationId($notification_delivered_id);
                $pendingNotification->setTitle('Abandoned Cart');
                $pendingNotification->setMessage($message);
                $pendingNotification->setType('Abandoned');
                $pendingNotification->setTypeId('');
                $pendingNotification->setRedirectionTitle('');

                $result = NULL;
                $notificationBuilder = $this->notificationDevicePool->getNotificationBuilder($pendingNotification->getDeviceType());

                if($notificationBuilder) {
                    $result = $notificationBuilder->setNotification($pendingNotification)->send();
                }

                if($result->success == 1){
                      
                      $this->setDeliveredNotificationForDevices($pendingNotification, $notification_delivered_id);
                      
                }
                else
                {
                    $this->logger->critical('===== Abandoned Cart Notification Debugging Start =======');
                    $errmessage = "Unable to send notification to registration id: {$pendingNotification->getRegistrationId()} with device {$pendingNotification->getDeviceId()} ";
                    $errmessage .= "Error : " . $result->results[0]->error;
                    $this->logger->info($errmessage);
                    $this->logger->critical('===== Abandoned Cart Notification End =======');
                }

            } catch(\Exception $e) {
                $this->logger->critical('===== Abandoned Cart Notification Debugging Start =======');
                $errmessage = "Unable to send notification to registration id : {$pendingNotification->getRegistrationId()} with device {$pendingNotification->getDeviceId()} ";
                $errmessage .= $e->getMessage();
                $errmessage .= $e->getTraceAsString();
                $this->logger->critical($errmessage);
                $this->logger->critical('===== Abandoned Cart Notification Debugging  End =======');
            }
        }
    }
     public function setNotificationAsDelivered($notification, $message) {

        $sent_status = 1;
        $store_id = $this->storeManager->getStore()->getId();
        $cur_date = $this->timezone->gmtDate();
        $notificationDelivered = array(
            'notification_id' => 0,
            'sent_status' => $sent_status,
            'store_id' => $store_id,
            'created_at' => $this->timezone->gmtDate(),
            'sent_date' => $cur_date,
            'type' => 'Abandoned',
            'type_id' => '',
            'title' => 'Abandoned Cart',
            'alert' => 'Abandoned Cart',
            'message' => $message,
            'redirection_title' => '',
        );
        return $this->notificationDeliveredFactory->create()->setData($notificationDelivered)->save();
    }

    public function setDeliveredNotificationForDevices($notification, $delivered_id) {
        $notificationDeliveredDevice = array(
            'notification_delivered_id' => $delivered_id,
            'registration_id' => $notification->getRegistrationId(),
            'device_id' => $notification->getDeviceId(),
            'device_type' => $notification->getDeviceType(),
            'customer_id' => $notification->getCustomerId(),
        );
        $this->notificationDeliveredDeviceFactory->create()->setData($notificationDeliveredDevice)->save();
    }

}