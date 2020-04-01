<?php

namespace Hypework\Shipping\Model\ResourceModel;

use Magento\Framework\DB\Select;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class Carrier extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_storeManager;

    /**
     * Date model
     * 
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        $this->_storeManager = $storeManager;
        $this->_date = $date;
        parent::__construct($context);
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('hypework_shipping_carrier', 'entity_id');
    }

}