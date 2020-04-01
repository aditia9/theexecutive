<?php

namespace Ranosys\AbandonedCart\Model\ResourceModel\AbandonedCartMail;

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
            'Ranosys\AbandonedCart\Model\AbandonedCartMail',
            'Ranosys\AbandonedCart\Model\ResourceModel\AbandonedCartMail'
        );
    }
}
