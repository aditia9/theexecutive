<?php

namespace Ranosys\Notification\Controller\Adminhtml\Notification;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ranosys\Notification\Model\ResourceModel\Notification\CollectionFactory;

class Publish extends \Magento\Backend\App\Action {

    protected $filter;
    protected $collectionFactory;
    protected $deviceFactory;
    protected $notificationDeliveredFactory;
    protected $notificationFactory;
    protected $notificationPendingFactory;
    protected $timezone;


    public function __construct(
            Context $context,
            Filter $filter,
            CollectionFactory $collectionFactory,
            \Ranosys\Notification\Model\DeviceFactory $deviceFactory,
            \Ranosys\Notification\Model\Notificationdelivered $notificationDeliveredFactory, 
            \Ranosys\Notification\Model\NotificationFactory $notificationFactory,
            \Ranosys\Notification\Model\NotificationpendingFactory $notificationPendingFactory,
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone
    ) {
     
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->deviceFactory = $deviceFactory;
        $this->notificationDeliveredFactory = $notificationDeliveredFactory;
        $this->notificationFactory = $notificationFactory;
        $this->notificationPendingFactory = $notificationPendingFactory;
        $this->timezone = $timezone;
        parent::__construct($context);
    }

    public function execute() {

        $notification_id = $this->getRequest()->getParam('id');
        if (!$notification_id) {
            $this->messageManager->addError(__('Please create notification first.'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        } else {
            $notification = $this->notificationFactory->create()->load($notification_id);
            if(!$notification->getId()){
                $this->messageManager->addError(__('Notification does not exist.'));
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
            }
            
            if(!$notification->canPublish())
            {
                $this->messageManager->addError(__('Error publishing notification. Check if it enabled and not already published/sent'));
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
            }
            
            try {         
                $devices = $this->deviceFactory->create()->getCollection();

                if ($devices->getSize() > 0) {
                    foreach ($devices as $device) {
                        $pendingNotificationData = array(
                            'notification_id' => $notification->getId(),
                            'device_type' => $device->getDeviceType(),
                            'registration_id' => $device->getRegistrationId(),
                            'device_id' => $device->getDeviceId(),
                            'alert' => $notification->getAlert(),
                            'title' => $notification->getTitle(),
                            'message' => $notification->getDescription(),
                            'customer_id' => $device->getCustomerId(),                           
                            'type' => $notification->getType(),
                            'type_id' => $notification->getTypeId(),
                            'redirection_title' => $notification->getRedirectionTitle(),                          
                            'image' => $notification->getImage(),
                            'created_at' => $this->timezone->gmtDate()
                        );
                        $this->notificationPendingFactory->create()->setData($pendingNotificationData)->save();
                    }
                    $notification->setPublishStatus(\Ranosys\Notification\Model\Notification::NOTIFICATION_STATUS_PUBLISHED)->save();
                    $this->messageManager->addSuccess(__('Notification has been added in queue to be send.'));
                } else {
                    $this->messageManager->addError(__('There is not any device registered.'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving Notification.'));
            }
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

}
