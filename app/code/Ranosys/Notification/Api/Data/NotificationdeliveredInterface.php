<?php

namespace Ranosys\Notification\Api\Data;

interface NotificationdeliveredInterface
{

    const ID = 'id';
    const NOTIFICATION_ID = 'notification_id';
    const STORE_ID = 'store_id';
    const CREATED_AT = 'created_at';
    const READ_STATUS = 'read_status';
    const SENT_DATE = 'sent_date';
    const TYPE = 'type';
    const TYPE_ID = 'type_id';
    const REDIRECTION_TITLE = 'redirection_title';
    const IMAGE = 'image';
    const ALERT = 'alert';
    const TITLE = 'title';
    const MESSAGE = 'message';
    
    
    
    /**
     *Get id
     * 
     * @return int
     */
    public function getId();
     
    /**
     * Set Id
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);
    
    /**
     * Get Store Id
     * 
     * @return int
     */
    public function getStoreId();
     
    /**
     * Set Store Id
     * @param int $store_id
     * @return $this
     */
    public function setStoreId($store_id);
     
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
     * Get Notification Id 
     * 
     * @return int
     */
    public function getNotificationId();
     
    /**
     * Set Notification Id
     * 
     * @param int $notification_id
     * @return $this
     */
    public function setNotificationId($notification_id);
    
    /**
     * Get Read Status
     * 
     * @return boolean
     */
    public function getReadStatus();
    
    /**
     * Set Read Status
     * @param boolean $read_status
     * @return $this
     */
    public function setReadStatus($read_status);
    
    /**
     * Get Sent Date
     * 
     * @return string
     */
    public function getSentDate();
    
    /**
     * Set Sent Date
     * 
     * @param string $sent_date
     * @return $this
     */
    public function setSentDate($sent_date);
    
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
     * 
     * @param string $image
     * @return $this
     */
    public function setImage($image);
   
}
