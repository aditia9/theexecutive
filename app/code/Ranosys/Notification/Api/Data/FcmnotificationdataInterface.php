<?php

namespace Ranosys\Notification\Api\Data;

interface FcmnotificationdataInterface
{

   
  
    const REGISTRATION_ID = 'registration_id';
    const NOTIFICATION_ID = 'notification_id';
    const STORE_ID = 'store_id';
    const IS_READ = 'is_read';
    const SENT_DATE = 'sent_date';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const TYPE = 'type';
    const TYPE_ID = 'type_id';
    const ID = 'id';
    const IMAGE = 'image';
    const REDIRECTION_TITLE = 'redirection_title';
    
    
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
     * Get Type
     * 
     * @return string
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
     * Set Type Id 
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
     * Set Is Read
     *  
     * @return boolean
     */
    public function getIsRead();
     
    /**
     * Set Is Read
     * 
     * @param boolean $is_read
     * @return $this
     */
    public function setIsRead($is_read);
  
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
     * 
     * @param string $sent_date
     * @return $this
     */
    public function setSentDate($sent_date);
       
    /**
     *Get Image
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
