<?php

namespace Ranosys\Notification\Model;

use \Magento\Framework\Api\AttributeValueFactory;

class Fcmnotificationmodel extends \Magento\Framework\Api\AbstractExtensibleObject implements
\Ranosys\Notification\Api\Data\FcmnotificationdataInterface
{

    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }
   
    /**
     * {@inheritdoc}
     */
    public function getIsRead()
    {
        return $this->_get(self::IS_READ);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsRead($is_read)
    {
         return $this->setData(self::IS_READ, $is_read);
    }
        
    /**
     * {@inheritdoc}
     */
    public function getSentDate()
    {
          return $this->_get(self::SENT_DATE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSentDate($sent_date)
    {
          return $this->setData(self::SENT_DATE, $sent_date);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
           return $this->_get(self::TITLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
          return $this->setData(self::TITLE, $title);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
            return $this->_get(self::DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
         return $this->setData(self::DESCRIPTION, $description);
    }
     
    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStoreId($store_id)
    {
        return $this->setData(self::STORE_ID, $store_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
          return $this->_get(self::TYPE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
         return $this->setData(self::TYPE, $type);
    }
    
    /**
     * {@inheritdoc}
     */ 
    public function getTypeId()
    {
         return $this->_get(self::TYPE_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTypeId($type_id)
    {
          return $this->setData(self::TYPE_ID, $type_id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRedirectionTitle()
    {
        return $this->_get(self::REDIRECTION_TITLE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRedirectionTitle($redirection_title)
    {
         return $this->setData(self::REDIRECTION_TITLE, $redirection_title);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getNotificationId()
    {
           return $this->_get(self::NOTIFICATION_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNotificationId($notification_id)
    {
         return $this->setData(self::NOTIFICATION_ID, $notification_id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
           return $this->_get(self::ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
         return $this->setData(self::ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
         return $this->_get(self::IMAGE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}
