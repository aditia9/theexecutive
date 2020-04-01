<?php

namespace Ranosys\Notification\Model;

use Magento\Framework\Exception\LocalizedException;
use Ranosys\Notification\Api\FcmnotificationInterface;

class Fcmnotification implements FcmnotificationInterface {

    protected $deviceFactory;
    protected $notificationDeliveredFactory;
    protected $notificationFactory;
    protected $timezone;
    protected $notificationDataFactory;
    protected $storeManager;
    protected $tokenFactory;
    protected $notificationDeliveredDeviceFactory;

    public function __construct(
        \Ranosys\Notification\Model\Device $deviceFactory,
        \Ranosys\Notification\Model\Notificationdelivered $notificationDeliveredFactory,
        \Ranosys\Notification\Api\Data\FcmnotificationdataInterfaceFactory $notificationDataFactory,
        \Ranosys\Notification\Model\NotificationDeliveredDevice $notificationDeliveredDeviceFactory,
        \Ranosys\Notification\Model\Notification $notificationFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
        \Magento\Integration\Model\Oauth\TokenFactory $tokenFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->deviceFactory = $deviceFactory;
        $this->timezone = $timezone;
        $this->notificationDeliveredFactory = $notificationDeliveredFactory;
        $this->notificationFactory = $notificationFactory;
        $this->notificationDataFactory = $notificationDataFactory;
        $this->notificationDeliveredDeviceFactory = $notificationDeliveredDeviceFactory;
        $this->tokenFactory = $tokenFactory;
        $this->storeManager = $storeManager;
    }

    public function registerDevice($device_type, $registration_id, $device_id) {
    
          if(!$device_id || !$device_type ||!$registration_id){
           throw new LocalizedException(
                    __('Please Fill all the Required Fields')
                );
        }
        
	$store_id =  $this->storeManager->getStore()->getId();
        $updated_at = $this->timezone->gmtDate();
        $deviceCollection = $this->deviceFactory->getCollection()
                            ->addFieldToFilter('device_type', array('eq' => $device_type))
                            ->addFieldToFilter('device_id', array('eq' => $device_id));
        
        $data = $deviceCollection->getSize();
        
        if (empty($data)) {
            $this->deviceFactory->setData(
                    [ 'device_type' => $device_type,
                      'registration_id' => $registration_id,
                      'store_id' => $store_id,
                      'device_id' => $device_id,
                      'updated_at' => $updated_at,
                      'created_at' => $updated_at,]);
            $this->deviceFactory->save();
            return true;
        } else {
            foreach ($deviceCollection as $item) {
                $item->setRegistrationId($registration_id);
                $item->setUpdatedAt($updated_at);
                $item->setStoreId($store_id);		
                $item->save();
                
            }
            return true;
        }
    }

    public function logoutCustomer($device_id, $customerId) {
       
        $updated_at = $this->timezone->gmtDate();
        
        $deviceCollection = $this->deviceFactory->getCollection()
                            ->addFieldToFilter('customer_id', array('eq' => $customerId))
                            ->addFieldToFilter('device_id', array('eq' => $device_id));
        
        $data = $deviceCollection->getSize();

        if (empty($data)) {
            return false;
        } else {
            foreach ($deviceCollection as $item) {
                $item->setCustomerId(null);
                $item->setUpdatedAt($updated_at);
                $item->save();
               
            }
             return true;
        }
    }
    
    
     public function changeNotificationStatus($notification_id, $device_id, $customer_token=null) {
        $collection = $this->notificationDeliveredDeviceFactory->getCollection(); 
        
        if($customer_token && $customer_token != '') {
            $token = $this->tokenFactory->create()->loadByToken($customer_token);
            if(!$token->getId()){
                return false;
            }
            $collection->getSelect()->where("((`main_table`.`notification_delivered_id` = '{$notification_id}' AND `main_table`.`customer_id` = {$token->getCustomerId()}) OR (`main_table`.`notification_delivered_id` = '{$notification_id}' AND `main_table`.`device_id` = '{$device_id}' AND `main_table`.`customer_id` IS null))");
        } else {
            $collection->getSelect()->where("(`main_table`.`notification_delivered_id` = '{$notification_id}' AND `main_table`.`device_id` = '{$device_id}' AND `main_table`.`customer_id` IS null)");
        }

        $read_at = $this->timezone->gmtDate();
        if ($collection->getSize()) {
            foreach ($collection as $item) {
                $item->setIsRead(1);
                $item->setReadAt($read_at);
                $item->save();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @api
     * @param int customerId
     * @param string deviceId
     * @return \Ranosys\Notification\Api\Data\FcmnotificationdataInterface[]
     */
     public function getNotificationList($customerId, $deviceId) {
         
        if(empty($deviceId)){
            throw new LocalizedException(__('Please provide device id.'));
        }

        $cur_date = $this->timezone->gmtDate(); 
        $to_time = strtotime($cur_date);
        $to_time = $to_time - (7*24*60*60); 
        $cur_date = date("Y-m-d H:i:s", $to_time);
        $devicecollection = $this->notificationDeliveredDeviceFactory->getCollection()
                ->distinct(true)
                ->addFieldToSelect('notification_delivered_id');
        $devicecollection->getSelect()->where("(`main_table`.`customer_id` = $customerId) OR (`main_table`.`device_id`= '$deviceId' AND `main_table`.`customer_id` IS null)");

        $collection = $this->notificationDeliveredFactory->getCollection()->addFieldToFilter('id', [
            'in' => $devicecollection->getSelect()
        ])
        ->addFieldToFilter('sent_date', array('gteq' => $cur_date))     
        ->setOrder('sent_date','DESC');
        $media_url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);


        $notifications = array();

        if (!empty($collection->getSize())) {
            foreach ($collection as $item) {
                if ($item->getImage()) {
                    $image_url = $media_url . 'notification_image' . $item->getImage();
                } else {
                    $image_url = '';
                }
                $id = $item->getId();
                $deliveredDeviceCollection = $this->notificationDeliveredDeviceFactory->getCollection()
                ->addFieldToSelect('is_read');
                //$deliveredDeviceCollection->getSelect()->where("((`main_table`.`notification_delivered_id` = $id AND `main_table`.`device_id`= '$deviceId') AND (`main_table`.`customer_id` = $customerId OR `main_table`.`customer_id` IS null))");
                $deliveredDeviceCollection->getSelect()->where("((`main_table`.`notification_delivered_id` = $id) AND ((`main_table`.`customer_id` = $customerId) OR (`main_table`.`notification_delivered_id` = $id AND `main_table`.`device_id`= '$deviceId' AND `main_table`.`customer_id` IS null)))");

                $data = $deliveredDeviceCollection->getData();
                
                if(!empty($data)){
                    $is_read = $data[0]['is_read'];
                } else {
                    $is_read = 0;
                }
                
                $notification_data = $this->notificationDataFactory->create();
           
                $notification_data->setId($item->getId());
                $notification_data->setNotificationId($item->getNotificationId());
                $notification_data->setStoreId($item->getStoreId());
                $notification_data->setIsRead($is_read);
                $notification_data->setSentDate($item->getSentDate());
                $notification_data->setTypeId($item->getTypeId());
                $notification_data->setType($item->getType());
                $notification_data->setDescription($item->getMessage());
                $notification_data->setTitle($item->getTitle());
                $notification_data->setRedirectionTitle($item->getRedirectionTitle());
                $notification_data->setImage($image_url);
                $notifications[] = $notification_data;
            }
        }
        return $notifications;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnreadCount($customerId, $deviceId) {
        if(empty($deviceId)){
            throw new LocalizedException(__('Please provide device id.'));
        }
        
        $cur_date = $this->timezone->gmtDate(); 
        $to_time = strtotime($cur_date);
        $to_time = $to_time - (7*24*60*60); 
        $cur_date = date("Y-m-d H:i:s", $to_time);
        $devicecollection = $this->notificationDeliveredDeviceFactory->getCollection()
                ->distinct(true)
                ->addFieldToSelect('notification_delivered_id');
        $devicecollection->getSelect()->where("((`main_table`.`customer_id` = $customerId) OR (`main_table`.`device_id`= '$deviceId' AND `main_table`.`customer_id` IS null)) AND (`main_table`.`is_read` = 0)");
        
        $collection = $this->notificationDeliveredFactory->getCollection()->addFieldToFilter('id', [
            'in' => $devicecollection->getSelect()
        ])
        ->addFieldToFilter('sent_date', array('gteq' => $cur_date));
        
        return $collection->getSize();
    }

}
