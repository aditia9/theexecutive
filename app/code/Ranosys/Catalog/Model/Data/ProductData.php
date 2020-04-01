<?php

namespace Ranosys\Catalog\Model\Data;

class ProductData extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Catalog\Api\Data\ProductDataInterface {
    
    const KEY_TOTALCOUNT = 'total_count';
    const KEY_ITEMS = 'items';
    
    /**
     * @inheritDoc
     */
    public function getTotalCount() {
        return $this->_getData(self::KEY_TOTALCOUNT);
    }
    
    /**
     * @inheritDoc
     */
    public function setTotalCount($totalCount) {
        return $this->setData(self::KEY_TOTALCOUNT, $totalCount);
    }
    
    /**
     * @inheritDoc
     */
    public function getItems() {
        return $this->_getData(self::KEY_ITEMS);
    }
    
    /**
     * @inheritDoc
     */
    public function setItems(array $items) {
        return $this->setData(self::KEY_ITEMS, $items);
    }
    
}