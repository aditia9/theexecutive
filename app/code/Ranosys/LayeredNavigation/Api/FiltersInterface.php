<?php

namespace Ranosys\LayeredNavigation\Api;

interface FiltersInterface{
    
    /**
     * Get Shop by filters
     * 
     * @param string $id
     * @return \Ranosys\LayeredNavigation\Api\Data\FiltersDataInterface
     */
    public function get($id);
    
}