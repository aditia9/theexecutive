<?php

namespace Hypework\Shipping\Model;

class Carrier extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'hypework_shipping_carrier';

    protected function _construct() {
        $this->_init('Hypework\Shipping\Model\ResourceModel\Carrier');
    }
}