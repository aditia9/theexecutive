<?php

namespace Ranosys\LayeredNavigation\Model\Data;

class FiltersData extends \Magento\Framework\Model\AbstractModel implements \Ranosys\LayeredNavigation\Api\Data\FiltersDataInterface {
    
    const KEY_TOTALCOUNT = 'total_count';
    const KEY_FILTERS = 'filters';
    const KEY_ACTIVEFILTERS = 'active_filters';
    
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
    public function getFilters() {
        return $this->_getData(self::KEY_FILTERS);
    }
    
    /**
     * @inheritDoc
     */
    public function setFilters(array $filters = null) {
        return $this->setData(self::KEY_FILTERS, $filters);
    }
    
    /**
     * @inheritDoc
     */
    public function getActiveFilters() {
        return $this->_getData(self::KEY_ACTIVEFILTERS);
    }
    
    /**
     * @inheritDoc
     */
    public function setActiveFilters(array $activeFilters = null) {
        return $this->setData(self::KEY_ACTIVEFILTERS, $activeFilters);;
    }
    
}