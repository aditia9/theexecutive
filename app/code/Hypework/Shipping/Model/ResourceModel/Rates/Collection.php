<?php
namespace Hypework\Shipping\Model\ResourceModel\Rates;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';    

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hypework\Shipping\Model\Rates', 'Hypework\Shipping\Model\ResourceModel\Rates');
    }    
}
