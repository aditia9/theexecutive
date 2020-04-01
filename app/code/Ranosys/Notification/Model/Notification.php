<?php

namespace Ranosys\Notification\Model;

use Ranosys\Notification\Api\Data\NotificationInterface;

class Notification extends \Magento\Framework\Model\AbstractModel implements NotificationInterface
{
    const NOTIFICATION_DISABLED = 0;
    const NOTIFICATION_ENABLED = 1;
    const NOTIFICATION_STATUS_PENDING = 0;
    const NOTIFICATION_STATUS_PUBLISHED = 1;
    const NOTIFICATION_STATUS_SENT = 2;
    const NOTIFICATION_STATUS_PENDING_LABEL = 'Pending';
    const NOTIFICATION_STATUS_PUBLISHED_LABEL = 'Published';
    const NOTIFICATION_STATUS_SENT_LABEL = 'Sent';
    
    
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'notifications';

    /**
     * @var string
     */
    protected $cacheTag = 'notifications';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'notifications';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Notification\Model\ResourceModel\Notification');
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
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
    public function getAlert()
    {
        return $this->getData(self::ALERT);
    }

    /**
     * {@inheritdoc}
     */
    public function setAlert($alert)
    {
        return $this->setData(self::ALERT, $alert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
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
        return $this->getData(self::DESCRIPTION);
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
        return $this->getData(self::STORE_ID);
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
    public function getSentDate()
    {
        return $this->getData(self::SENT_DATE);
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
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updated_at)
    {
        return $this->setData(self::UPDATED_AT, $updated_at);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
  
    /**
     * {@inheritdoc}
     */
    public function getNotificationSent()
    {
        return $this->getData(self::NOTIFICATION_SENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setNotificationSent($notification_sent)
    {
        return $this->setData(self::NOTIFICATION_SENT, $notification_sent);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
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
        return $this->getData(self::TYPE_ID);
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
        return $this->getData(self::REDIRECTION_TITLE);
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
    public function getNotificationType()
    {
        return $this->getData(self::NOTIFICATION_TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setNotificationType($notification_type)
    {
        return $this->setData(self::NOTIFICATION_TYPE, $notification_type);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPublishStatus()
    {
        return $this->getData(self::PUBLISH_STATUS);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function setPublishStatus($publishStatus)
    {
        return $this->setData(self::PUBLISH_STATUS, $publishStatus);
    }
    
    public function canSend(){
        if(($this->getPublishStatus() == self::NOTIFICATION_STATUS_PUBLISHED) && ($this->getStatus() == self::NOTIFICATION_ENABLED)){
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function canEdit(){
        if($this->getPublishStatus() == self::NOTIFICATION_STATUS_PENDING){
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function canPublish(){
        if(($this->getPublishStatus() == self::NOTIFICATION_STATUS_PENDING) && ($this->getStatus() == self::NOTIFICATION_ENABLED)){
            return TRUE;
        }
        
        return FALSE;
    }
    
}
