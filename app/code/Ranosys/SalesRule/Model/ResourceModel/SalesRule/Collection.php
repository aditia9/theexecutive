<?php

namespace Ranosys\SalesRule\Model\ResourceModel\SalesRule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected function _construct() {
        $this->_init('Ranosys\SalesRule\Model\SalesRule', 'Ranosys\SalesRule\Model\ResourceModel\SalesRule');
    }

}
