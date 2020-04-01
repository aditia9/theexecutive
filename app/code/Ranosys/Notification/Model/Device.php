<?php

namespace Ranosys\Notification\Model;

use Ranosys\Notification\Api\Data\DeviceInterface;

class Device extends \Magento\Framework\Model\AbstractModel implements DeviceInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'notification_devices';

    /**
     * @var string
     */
    protected $cacheTag = 'notification_devices';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'notification_devices';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Notification\Model\ResourceModel\Device');
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
}
