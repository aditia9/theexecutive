<?php

namespace Ranosys\Promotion\Model\ResourceModel\Grid;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'promotion_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Promotion\Model\Grid', 'Ranosys\Promotion\Model\ResourceModel\Grid');
    }
}