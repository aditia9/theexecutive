<?php

namespace Ranosys\Notification\Model\ResourceModel\Notificationdelivered;

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
            'Ranosys\Notification\Model\Notificationdelivered',
            'Ranosys\Notification\Model\ResourceModel\Notificationdelivered'
        );
    }
}
