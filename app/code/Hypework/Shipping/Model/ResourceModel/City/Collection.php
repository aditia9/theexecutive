<?php
namespace Hypework\Shipping\Model\ResourceModel\City;

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
        $this->_init('Hypework\Shipping\Model\City', 'Hypework\Shipping\Model\ResourceModel\City');
    }    
}
