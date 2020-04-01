<?php

namespace Hypework\ShippingLion\Model;

class Carrier extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'hypework_shippinglion_carrier';

    protected function _construct() {
        $this->_init('Hypework\ShippingLion\Model\ResourceModel\Carrier');
    }
}