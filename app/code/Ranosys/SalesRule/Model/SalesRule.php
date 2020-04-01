<?php

namespace Ranosys\SalesRule\Model;

class SalesRule extends \Magento\Framework\Model\AbstractModel {
    
    protected function _construct() {
        $this->_init('Ranosys\SalesRule\Model\ResourceModel\SalesRule');
    }

}