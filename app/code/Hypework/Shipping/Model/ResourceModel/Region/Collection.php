<?php
namespace Hypework\Shipping\Model\ResourceModel\Region;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'region_id';    

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hypework\Shipping\Model\Region', 'Hypework\Shipping\Model\ResourceModel\Region');
    }    
}
