<?php

namespace Ranosys\Notification\Observer;

use Magento\Framework\Event\ObserverInterface;

class OrderPlaceNotification implements ObserverInterface {
    
    protected $notificationsPendingFactory;
    
    protected $notificationDevicePool;
    
    protected $deviceFactory;
    
    protected $notificationHelper;
    
    protected $timezone;
    
    protected $logger;
    
    protected $storeManager;
    
    protected $notificationDeliveredDeviceFactory;
    
    public function __construct(
        \Ranosys\Notification\Model\NotificationpendingFactory $notificationsPendingFactory,
        \Ranosys\Notification\Model\Notification\DevicePool $notificationDevicePool,
        \Ranosys\Notification\Model\NotificationDeliveredDeviceFactory $notificationDeliveredDeviceFactory,
        \Ranosys\Notification\Model\DeviceFactory $deviceFactory,
        \Ranosys\Notification\Helper\Data $notificationHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
        \Ranosys\Notification\Model\NotificationdeliveredFactory $notificationDeliveredFactory,
        \Ranosys\Notification\Logger\Logger $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->notificationsPendingFactory = $notificationsPendingFactory;
        $this->notificationDevicePool = $notificationDevicePool;
        $this->deviceFactory = $deviceFactory;
        $this->notificationHelper = $notificationHelper;
        $this->timezone = $timezone;
        $this->notificationDeliveredFactory = $notificationDeliveredFactory;
        $this->notificationDeliveredDeviceFactory = $notificationDeliveredDeviceFactory;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer) {
        date_default_timezone_set('UTC');
        $order = $observer->getEvent()->getOrder();
        
        $payment = $order->getPayment();
        $method = $payment->getMethodInstance();
        $paymentMethodCode = $method->getCode();
        
        if($paymentMethodCode == 'ipay88_cc'){
            return;
        }
        
        $customerId = $order->getCustomerId();
        
        if(!$customerId){
            return;
        }
        
        $customerDevices = $this->deviceFactory->create()->getCollection();
        $customerDevices->addFieldToFilter('customer_id', array('eq' => $customerId));
        
        if(!$customerDevices->getSize()){
            return;
        }
        
        $pendingNotification = $this->notificationsPendingFactory->create();
        
        $message = __('Your order #%1 placed successfully.', $order->getIncrementId());
        
        $setNotificationDeliver = $this->setNotificationAsDelivered($order, $message);
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
                $pendingNotification->setTitle('');
                $pendingNotification->setMessage($message);
                $pendingNotification->setType('Order');
                $pendingNotification->setTypeId($order->getIncrementId());
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
                    $this->logger->critical('===== Order Notification Debugging Start =======');
                    $errmessage = "Unable to send notification to registration id: {$pendingNotification->getRegistrationId()} with device {$pendingNotification->getDeviceId()} for order {$order->getIncrementId()} ";
                    $errmessage .= "Error : " . $result->results[0]->error;
                    $this->logger->info($errmessage);
                    $this->logger->critical('===== Order Notification End =======');
                }


            } catch(\Exception $e) {
                $this->logger->critical('===== Order Notification Debugging Start =======');
                $message = "Unable to send notification to registration id : {$notification->getRegistrationId()} with device {$notification->getDeviceId()} for order {$order->getIncrementId()} ";
                $errmessage .= $e->getMessage();
                $errmessage .= $e->getTraceAsString();
                $this->logger->critical($errmessage);
                $this->logger->critical('===== Order Notification Debugging  End =======');
            }
        }
    }
    
    public function setNotificationAsDelivered($order, $message) {
        $sent_status = 1;
        $store_id = $this->storeManager->getStore()->getId();
        $cur_date = $this->timezone->gmtDate();
        $notificationDelivered = array(
            'notification_id' => 0,
            'sent_status' => $sent_status,
            'store_id' => $store_id,
            'created_at' => $cur_date,
            'sent_date' => $cur_date,
            'type' => 'Order',
            'type_id' => $order->getIncrementId(),
            'title' => '',
            'alert' => $order->getIncrementId(),
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