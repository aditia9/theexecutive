<?php

namespace Ranosys\Notification\Model\ResourceModel\NotificationDeliveredDevice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'Ranosys\Notification\Model\NotificationDeliveredDevice',
            'Ranosys\Notification\Model\ResourceModel\NotificationDeliveredDevice'
        );
    }
}
