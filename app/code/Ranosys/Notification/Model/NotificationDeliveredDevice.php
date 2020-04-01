<?php

namespace Ranosys\Notification\Model;

use Ranosys\Notification\Api\Data\NotificationDeliveredDeviceInterface;

class NotificationDeliveredDevice extends \Magento\Framework\Model\AbstractModel implements NotificationDeliveredDeviceInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'notification_delivered_devices';

    /**
     * @var string
     */
    protected $cacheTag = 'notification_delivered_devices';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'notification_delivered_devices';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Notification\Model\ResourceModel\NotificationDeliveredDevice');
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
    public function getNotificationDeliveredId()
    {
        return $this->getData(self::NOTIFICATION_DELIVERED_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setNotificationDeliveredId($notification_delivered_id)
    {
        return $this->setData(self::NOTIFICATION_DELIVERED_ID, $notification_delivered_id);
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
    public function getIsRead()
    {
        return $this->getData(self::IS_READ);
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
    public function getReadAt()
    {
        return $this->getData(self::READ_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setReadAt($read_at)
    {
        return $this->setData(self::READ_AT, $read_at);
    }
}
