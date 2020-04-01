<?php

namespace Ranosys\LayeredNavigation\Api;

interface SearchFiltersInterface {
    
    /**
     * Get Shop by filters
     * 
     * @param string $q
     * @return \Ranosys\LayeredNavigation\Api\Data\FiltersDataInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function get($q);
    
}