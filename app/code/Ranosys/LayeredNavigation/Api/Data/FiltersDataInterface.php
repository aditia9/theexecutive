<?php

namespace Ranosys\LayeredNavigation\Api\Data;

interface FiltersDataInterface {
    
    /**
     * Get total product count
     * 
     * @return int|null
     */
    public function getTotalCount();
    
    /**
     * Set total product count
     * 
     * @param int $label
     * @return $this
     */
    public function setTotalCount($totalCount);
    
    /**
     * Get category filters
     * 
     * @return \Ranosys\LayeredNavigation\Api\Data\FilterInformationInterface[]|null
     */
    public function getFilters();
    
    /**
     * Set category filters
     * 
     * @param \Ranosys\LayeredNavigation\Api\Data\FilterInformationInterface[] $filters
     * @return $this
     */
    public function setFilters(array $filters = null);
    
    /**
     * Get active filters
     * 
     * @return \Ranosys\LayeredNavigation\Api\Data\FilterOptionsInterface[]|null
     */
    public function getActiveFilters();
    
    
    /**
     * Set active filters
     * 
     * @return \Ranosys\LayeredNavigation\Api\Data\FilterOptionsInterface[] $activeFilters
     */
    public function setActiveFilters(array $activeFilters = null);
    
}