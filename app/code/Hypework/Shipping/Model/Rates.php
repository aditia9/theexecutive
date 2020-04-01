<?php

namespace Hypework\Shipping\Model;

class Rates extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'hypework_shipping_rates';

    protected function _construct() {
        $this->_init('Hypework\Shipping\Model\ResourceModel\Rates');
    }
}