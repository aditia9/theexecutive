<?php

namespace Ranosys\Notification\Model;

use Ranosys\Notification\Api\Data\NotificationpendingInterface;

class Notificationpending extends \Magento\Framework\Model\AbstractModel implements NotificationpendingInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'notifications_pending';

    /**
     * @var string
     */
    protected $cacheTag = 'notifications_pending';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'notifications_pending';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Notification\Model\ResourceModel\Notificationpending');
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
    public function getDeviceType()
    {
        return $this->getData(self::DEVICE_TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setDeviceType($device_type)
    {
        return $this->setData(self::DEVICE_TYPE, $device_type);
    }  
    
    /**
     * {@inheritdoc}
     */
    public function getRegistrationId()
    {
        return $this->getData(self::REGISTRATION_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setRegistrationId($registration_id)
    {
        return $this->setData(self::REGISTRATION_ID, $registration_id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDeviceId()
    {
        return $this->getData(self::DEVICE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setDeviceId($device_id)
    {
        return $this->setData(self::DEVICE_ID, $device_id);
    }
     
    /**
     * {@inheritdoc}
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerId($customer_id)
    {
        return $this->setData(self::CUSTOMER_ID, $customer_id);
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
    public function getNotificationId()
    {
        return $this->getData(self::NOTIFICATION_ID);
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
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
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
}
