<?php

namespace Hypework\Shipping\Model;

class Region extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'directory_country_region';

    protected function _construct() {
        $this->_init('Hypework\Shipping\Model\ResourceModel\Region');
    }
}