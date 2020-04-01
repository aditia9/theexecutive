<?php

namespace Ranosys\CatalogSearch\Api;

interface ResultInterface {
    
    /**
     * Get search result products list
     * 
     * @param string $q
     * @return \Ranosys\CatalogSearch\Api\Data\ResultDataInterface
     * @thorws \Magento\Framework\Exception\InputException
     */
    public function get($q);
    
}