<?php

namespace Ranosys\Notification\Controller\Adminhtml\Notification;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;


class SendNotification extends \Magento\Backend\App\Action{

    protected $scopeConfig;
    protected $logger;
    protected $timezone;
    protected $notificationsPendingFactory;
    protected $notificationDeliveredFactory;
    protected $notificationDeliveredDeviceFactory;
    protected $notificationFactory;
    protected $storeManager;
    protected $resultFactory;
    protected $notificationDevicePool;

    public function __construct(
             Context $context,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
            \Ranosys\Notification\Model\NotificationpendingFactory $notificationsPendingFactory,
            \Ranosys\Notification\Logger\Logger $logger,
            \Ranosys\Notification\Model\NotificationdeliveredFactory $notificationDeliveredFactory,
            \Ranosys\Notification\Model\NotificationDeliveredDeviceFactory $notificationDeliveredDeviceFactory,
            \Ranosys\Notification\Model\NotificationFactory $notificationFactory,
            \Magento\Store\Model\StoreManagerInterface $storeManager,  
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
            \Ranosys\Notification\Model\Notification\DevicePool $notificationDevicePool
            
    ) {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->notificationsPendingFactory = $notificationsPendingFactory;
        $this->timezone = $timezone;
        $this->notificationDeliveredFactory = $notificationDeliveredFactory;
        $this->notificationDeliveredDeviceFactory = $notificationDeliveredDeviceFactory;
        $this->notificationFactory = $notificationFactory;
        $this->storeManager = $storeManager;
        $this->notificationDevicePool = $notificationDevicePool;
        parent::__construct($context);
    }

    public function execute() {
        
        $notification_id = $this->getRequest()->getParam('id');
        
        if (!$notification_id) {
            $this->messageManager->addError(__('Please publish notification first.'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        }
        
        $notification = $this->notificationFactory->create()->load($notification_id);
        
        if(!$notification->getId()){
            $this->messageManager->addError(__('Notification does not exist.'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        }
        
        if(!$notification->canSend())
        {
            $this->messageManager->addError(__('Error sending notification. Check if it is enabled/published and not already sent'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        }

        $notificationPendingCollection = $this->notificationsPendingFactory->create()->getCollection();
        $notificationPendingCollection->addFieldToFilter('notification_id', array('eq' => $notification->getId()));
        $notificationPendingCollection->setOrder('created_at', 'DESC');
        
        $deliveredNotification = $this->setNotificationAsDelivered($notification);
        $notification_delivered_id = $deliveredNotification->getId();
        $notifications_sent = 0;
        
        foreach ($notificationPendingCollection as $pendingNotification) {
            try {
                $pendingNotification->setNotificationId($notification_delivered_id);
                $result = NULL;
                $notificationBuilder = $this->notificationDevicePool->getNotificationBuilder($pendingNotification->getDeviceType());

                if ($notificationBuilder) {
                    $result = $notificationBuilder->setNotification($pendingNotification)->send();
                }

                if ($result && $result->success) {

                    $notifications_sent++;
                    $sent_status = 1;
                    //$deliveredNotification->setSentStatus($sent_status)->save();
                    $this->setDeliveredNotificationForDevices($pendingNotification, $notification_delivered_id);
                    $pendingNotification->delete();
                } else {
                    $this->logger->critical('===== Notification Debugging Start =======');
                    $message = "Unable to send notification({$notification_id}) to registration id: {$pendingNotification->getRegistrationId()} with device {$pendingNotification->getDeviceId()}";
                    $message .= "Error : " . $result->results[0]->error;
                    $this->logger->info($message);
                    $this->logger->critical('===== Notification End =======');
                }
            } catch (\Exception $e) {
                $this->logger->critical('===== Notification Debugging Start =======');
                $message = "Unable to send notification({$notification_id}) to registration id : {$notification->getRegistrationId()} with device {$notification->getDeviceId()}";
                $message .= $e->getMessage();
                $message .= $e->getTraceAsString();
                $this->logger->critical($message);
                $this->logger->critical('===== Notification Debugging  End =======');
            }
        }
        
        if(!$notifications_sent){
            $deliveredNotification->delete();
        }
        
        $cur_date = $this->timezone->gmtDate();
        $notification->setPublishStatus(\Ranosys\Notification\Model\Notification::NOTIFICATION_STATUS_SENT)
                ->setSentDate($cur_date)
                ->setNotificationsSent($notifications_sent)
                ->save();

        $this->messageManager->addSuccess(__('Notification Successfully Sent'));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('notification/notification/index');
    }

    public function setNotificationAsDelivered($notification) {

        $sent_status = 1;
        $store_id = $this->storeManager->getStore()->getId();
        $cur_date = $this->timezone->gmtDate();
        $notificationDelivered = array(
            'notification_id' => $notification->getId(),
            'sent_status' => $sent_status,
            'created_at' => $notification->getCreatedAt(),           
            'store_id' => $store_id,
            'sent_date' => $cur_date,
            'type' => $notification->getType(),
            'type_id' => $notification->getTypeId(),
            'title' => $notification->getTitle(),
            'alert' => $notification->getTitle(),
            'message' => $notification->getDescription(),
            'redirection_title' => $notification->getRedirectionTitle(),
            'image' => $notification->getImage()
        );
        return $this->notificationDeliveredFactory->create()->setData($notificationDelivered)->save();
    }

    public function setDeliveredNotificationForDevices($notification, $delivered_id) {
        $notificationDeliveredDevice = array(
            'notification_delivered_id' => $delivered_id,
            'registration_id' => $notification->getRegistrationId(),
            'device_id' => $notification->getDeviceId(),
            'device_type' => $notification->getDeviceType(),
            'customer_id' => $notification->getCustomerId()
        );
        $this->notificationDeliveredDeviceFactory->create()->setData($notificationDeliveredDevice)->save();
    }

}
