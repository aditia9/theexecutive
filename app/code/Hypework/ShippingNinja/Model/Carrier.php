<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/18/18
 * Time: 8:35 PM
 */
namespace Hypework\ShippingNinja\Model;
class Carrier extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'hypework_shippingninja_carrier';

    protected function _construct() {
        $this->_init('Hypework\ShippingNinja\Model\ResourceModel\Carrier');
    }
}