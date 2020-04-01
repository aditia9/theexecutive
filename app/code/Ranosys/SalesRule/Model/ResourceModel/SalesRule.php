<?php

namespace Ranosys\SalesRule\Model\ResourceModel;

class SalesRule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    protected function _construct() {
        $this->_init('cart_rule_area', 'id');
    }

}
