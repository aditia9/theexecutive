<?php

namespace Ranosys\Notification\Api\Data;

interface NotificationDeliveredDeviceInterface
{

    const ID = 'id';
    const DEVICE_TYPE = 'device_type';
    const REGISTRATION_ID = 'registration_id';
    const DEVICE_ID = 'device_id';
    const NOTIFICATION_DELIVERED_ID = 'notification_delivered_id';
    const CUSTOMER_ID = 'customer_id';
    const IS_READ = 'is_read';
    const READ_AT = 'read_at';
    
    
    
    /**
     * Get id
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Set id
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);
    
    
    /**
     * Get Device Type
     * 
     * @return string
     */
    public function getDeviceType();
    
    /**
     * Set Device Type
     * 
     * @param string $device_type
     * @return $this
     */
    public function setDeviceType($device_type);
    
    
    /**
     * Get Registration Id
     * 
     * @return string 
     */
    public function getRegistrationId();
    
    /**
     * Set Registration Id
     * 
     * @param string $registration_id
     * @return $this
     */
    public function setRegistrationId($registration_id); 
    
    
    /**
     * Get Device Id 
     * 
     * @return string
     */
    public function getDeviceId();

    /**
     * Set Device Id
     * 
     * @param string $device_id
     * @return $this
     */
    public function setDeviceId($device_id);

    
    /**
     * Get Notification Delivered Id
     * 
     * @return int
     */
    public function getNotificationDeliveredId();
     
    /**
     * Set Notification Delivered Id
     * 
     * @param int $notification_delivered_id
     * @return $this
     */
    public function setNotificationDeliveredId($notification_delivered_id);
     
    /**
     * Get Is Read
     * 
     * @return boolean
     */
    public function getIsRead();
    
    /**
     * Set Is Read
     * @param boolean $is_read
     * @return $this
     */
    public function setIsRead($is_read);
         
    /**
     *
     * Get Read At
     * @return string
     */
    public function getReadAt();
    
    /**
     * Set Read At
     *   
     * @param string $read_at
     * @return $this
     */
    public function setReadAt($read_at);
    
    /**
     * Get Customer Id
     * 
     * @return int
     */
    public function getCustomerId();
   
    /**
     * Set Customer Id
     * 
     * @param int $customer_id
     * @return $this
     */
    public function setCustomerId($customer_id);
    
    
}
