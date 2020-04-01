<?php

namespace Ranosys\Catalog\Api\Data;

interface ProductDataInterface {
    
    /**
     * Set total product count
     * 
     * @return int|null
     */
    public function getTotalCount();
    
    /**
     * Set total product count
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount);
    
    /**
     * Get category products items
     * 
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getItems();
    
    /**
     * Set category products items
     * 
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}