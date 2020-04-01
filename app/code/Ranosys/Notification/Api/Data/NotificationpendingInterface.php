<?php

namespace Ranosys\Notification\Api\Data;

interface NotificationpendingInterface
{

    const ID = 'id';
    const NOTIFICATION_ID = 'notification_id';
    const REGISTRATION_ID = 'registration_id';
    const DEVICE_TYPE = 'device_type';
    const DEVICE_ID = 'device_id';
    const CUSTOMER_ID = 'customer_id';
    const CREATED_AT = 'created_at';
    const ALERT = 'alert';
    const TITLE = 'title';
    const MESSAGE = 'message';
    const TYPE = 'type';
    const TYPE_ID = 'type_id';
    const REDIRECTION_TITLE = 'redirection_title';
    const IMAGE = 'image';
    
    
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();
    
    /**
     * Set Id.
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);   
    
    /**
     * Get DeviceType.
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
     * Get registration id.
     *
     * @return string
     */
    public function getRegistrationId();
    
    /**
     * Set registration id.
     * 
     * @param string $registration_id
     * @return $this
     */
    public function setRegistrationId($registration_id); 
    
    /**
     * Get device id.
     *
     * @return string
     */
    public function getDeviceId();

    /**
     * Set Device id.
     * 
     * @param string $device_id
     */
    public function setDeviceId($device_id);

    /**
     * Get customer id.
     *
     * @return int
     */
    public function getCustomerId();
    
    /**
     * Set customer id.
     * 
     * @param int $customer_id
     * @return $this
     */
    public function setCustomerId($customer_id);

    /**
     * Get CreatedAt.
     *
     * @return string
     */
    public function getCreatedAt();
    
    /**
     * Set CreatedAt.
     * 
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at);
    
    /**
     * Get notification id.
     *
     * @return int
     */
    public function getNotificationId();
    
    /**
     * Set notification id.
     * 
     * @param int $notification_id
     * @return $this
     */
    public function setNotificationId($notification_id);
 
    /**
     * Get alert.
     *
     * @return string
     */
    public function getAlert();
    
    /**
     * Set alert.
     * 
     * @param string $alert
     * @return $this
     */
    public function setAlert($alert);       
    
    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();
    
    /**
     * Set title.
     * 
     * @param string $title
     * @return $this
     */
    public function setTitle($title);  
    
    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage();
    
    /**
     * Set message.
     * 
     * @param string $message
     * @return $this
     */
    public function setMessage($message); 
    
    /**
     * Get type
     *
     * @return sting
     */
    public function getType();
    
    /**
     * Set type
     * 
     * @param string $type
     * @return $this
     */
    public function setType($type);
    
    /**
     * Get type_id
     *
     * @return int
     */
    public function getTypeId();
    
    /**
     * Set type_id
     * 
     * @param int $type_id
     * @return $this
     */
    public function setTypeId($type_id);
    
    /**
     * Get redirection_title
     *
     * @return string
     */
    public function getRedirectionTitle();
    
    /**
     * Set redirection_title
     * 
     * @param string $redirection_title
     * @return $this
     */
    public function setRedirectionTitle($redirection_title);
   
    /**
     * Get image
     * 
     * @return string
     */
    public function getImage();
    
    /**
     * Set Image
     * @param string $image
     * @return $this
     */
    public function setImage($image);
    
}
