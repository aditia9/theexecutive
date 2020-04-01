<?php

namespace Ranosys\Notification\Model\ResourceModel\Notification;

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
            'Ranosys\Notification\Model\Notification',
            'Ranosys\Notification\Model\ResourceModel\Notification'
        );
    }
}
