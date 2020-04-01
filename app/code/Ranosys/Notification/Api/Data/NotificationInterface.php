<?php

namespace Ranosys\Notification\Api\Data;

interface NotificationInterface
{
    
    const ID = 'id';
    const TITLE = 'title';
    const ALERT = 'alert';
    const DESCRIPTION = 'description';
    const STORE_ID = 'store_id';
    const SENT_DATE = 'sent_date';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const STATUS = 'status';
    const IMAGE = 'image';
    const NOTIFICATION_SENT = 'notification_sent';
    const TYPE = 'type';
    const TYPE_ID = 'type_id';
    const REDIRECTION_TITLE = 'redirection_title';
    const NOTIFICATION_TYPE = 'notification_type';
    const PUBLISH_STATUS = 'publish_status';   
    
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
     * Get Alert
     * 
     * @return string 
     */
    public function getAlert();
   
    /**
     * Set Alert
     * 
     * @param string $alert
     * @return $this
     */
    public function setAlert($alert); 
    
    
    /**
     * Get Title
     *  
     * @return string
     */
    public function getTitle();

    /**
     * Set Title 
     * 
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get Description
     * 
     * @return string
     */
    public function getDescription();

    /**
     * Set Description
     * 
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
    
    /**
     * Get Store Id
     * 
     * @return int
     */
    public function getStoreId();
     
    /**
     * Set Store Id 
     * 
     * @param int $store_id
     * @return $this
     */
    public function setStoreId($store_id);
    
    /**
     * Get Sent Date
     * 
     * @return string
     */
    public function getSentDate();
    
    /**
     * Set Sent Date
     * @param string $sent_date
     * @return $this
     */
    public function setSentDate($sent_date);   
    
    /**
     * Get Created At
     * 
     * @return string
     */
    public function getCreatedAt();
     
    /**
     * Set Created At 
     * 
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at);
       
    /**
     * Get Updated At
     * 
     * @return string
     */
    public function getUpdatedAt();
     
    /**
     * Set Updated At
     * 
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at);
    
    /**
     * Get Status
     * 
     * @return boolean
     */
    public function getStatus();
     
    /**
     * Set Status
     * 
     * @param boolean $status
     * @return $this
     */
    public function setStatus($status);
    
    /**
     * Get Image 
     * 
     * @return string
     */
    public function getImage();
    
    /**
     * Set Image
     * 
     * @param string $image
     * @return $this
     */
    public function setImage($image);
    
    /**
     * Get Notification Sent 
     * 
     * @return int
     */
    public function getNotificationSent();
     
    /**
     * Set Notification Sent
     * 
     * @param int $notification_sent
     * @return $this
     */
    public function setNotificationSent($notification_sent);
    
    /**
     * Get Type
     * 
     * @return int
     */
    public function getType();
     
    /**
     * Set Type
     * 
     * @param string $type
     * @return $this
     */
    public function setType($type);
    
    /**
     * Get Type Id
     * 
     * @return string
     */
    public function getTypeId();
     
    /**
     *
     * @param string $type_id
     * @return $this
     */
    public function setTypeId($type_id);
    
    /**
     * Get Redirection Title
     * 
     * @return string
     */
    public function getRedirectionTitle();
     
    /**
     * Set Redirection Title
     * 
     * @param int $redirection_title
     * @return $this
     */
    public function setRedirectionTitle($redirection_title);
    
        
    /**
     * Get Notification Type
     * 
     * @return string
     */
    public function getNotificationType();
     
    /**
     * Set Notification Type
     * 
     * @param int $notification_type
     * @return $this
     */
    public function setNotificationType($notification_type);
    
    /**
     * Get publish status
     * 
     * @return int
     */
    public function getPublishStatus();
    
    /**
     * Set publish status
     * 
     * @param int $publishStatus
     * @return $this
     */
    public function setPublishStatus($publishStatus);
}
