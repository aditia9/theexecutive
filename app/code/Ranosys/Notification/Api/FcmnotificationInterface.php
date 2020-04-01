<?php

namespace Ranosys\Notification\Api;

interface FcmnotificationInterface {
    /**
     * @api
     * @param string device_type
     * @param string registration_id
     * @param string device_id
     * @return boolean
     */
    public function registerDevice($device_type, $registration_id, $device_id);

    /**
     * @api
     * @param string device_id
     * @param int customerId
     * @return boolean
     */
    public function logoutCustomer($device_id, $customerId);
    
    
    /**
     * Return notification status
     *
     * @api
     * @param int notification_id
     * @param string device_id
     * @param string $customer_token
     * @return bool
     */
    public function changeNotificationStatus($notification_id, $device_id, $customer_token = null);
    
   
    /**
     * 
     *
     * @api
     * @param int customerId
     * @param string deviceId
     * @return \Ranosys\Notification\Api\Data\FcmnotificationdataInterface[]
     */
    public function getNotificationList($customerId, $deviceId);
    
    /**
     * Get unread notifications count
     * 
     * @param int $customerId
     * @param string $deviceId
     * @return int
     */
    public function getUnreadCount($customerId, $deviceId);
}
