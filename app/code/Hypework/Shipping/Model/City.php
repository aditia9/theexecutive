<?php

namespace Hypework\Shipping\Model;

class City extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'hypework_shipping_city';

    protected function _construct() {
        $this->_init('Hypework\Shipping\Model\ResourceModel\City');
    }
}