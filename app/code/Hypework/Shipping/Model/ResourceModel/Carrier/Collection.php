<?php
namespace Hypework\Shipping\Model\ResourceModel\Carrier;

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
        $this->_init('Hypework\Shipping\Model\Carrier', 'Hypework\Shipping\Model\ResourceModel\Carrier');
    }    
}
